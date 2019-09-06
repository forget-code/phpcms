<?php
require './include/common.inc.php';
if ($dosubmit)
{
	$res = $db->query("SELECT ".TABLE_MEMBER.".userid,".TABLE_MEMBER_GROUP.".messagelimit FROM ".TABLE_MEMBER_GROUP.",".TABLE_MEMBER." WHERE ".TABLE_MEMBER.".groupid=".TABLE_MEMBER_GROUP.".groupid AND ".TABLE_MEMBER.".username='$sendto'");
	if ($db->num_rows($res) > 0)
	{
		$row = $db->fetch_row($res);
		if ($row[1] > 0)
		{
			$res = $db->query("SELECT id FROM ".TABLE_MESSAGE_FRIEND." WHERE userself='$sendto' AND userother='$_username' AND types=1");
			if ($db->num_rows($res) < 1)
			{
				$sendtime = time();
				$res = $db->query("SELECT id FROM ".TABLE_MESSAGE_INBOX." WHERE receiver='$sendto' AND types=0 UNION ALL SELECT ".TABLE_MESSAGE_INBOX.".id FROM ".TABLE_MESSAGE_INBOX." LEFT JOIN ".TABLE_MESSAGE_READ." ON ".TABLE_MESSAGE_INBOX.".id=".TABLE_MESSAGE_READ.".messageid AND ".TABLE_MESSAGE_READ.".userid='$row[0]' AND ".TABLE_MESSAGE_READ.".forsake=1 WHERE ".TABLE_MESSAGE_INBOX.".types=1 AND ".TABLE_MESSAGE_READ.".messageid IS NULL");
				if ($db->num_rows($res) > 0)
				{
					$inboxnum = $db->num_rows($res);
				}
				else
				{
					$inboxnum = 0;
				}
				$res = $db->query("SELECT id FROM ".TABLE_MESSAGE_OUTBOX." WHERE sender='$sendto'");
				if ($db->num_rows($res) > 0)
				{
					$outboxnum = $db->num_rows($res);
				}
				else
				{
					$outboxnum = 0;
				}
				if ($row[1] > $inboxnum + $outboxnum)
				{
					if (isset($save))
					{
						$db->query("INSERT INTO ".TABLE_MESSAGE_OUTBOX." (sender,receiver,title,content,sendtime) VALUES ('$_username','$sendto','$title','$content',$sendtime)");
					}
					$db->query("INSERT INTO ".TABLE_MESSAGE_INBOX." (sender,receiver,title,content,sendtime) VALUES ('$_username','$sendto','$title','$content',$sendtime)");
					if ($db->affected_rows() > 0)
					{
						showmessage($LANG['operation_success'], $PHP_REFERER);
					}
					else
					{
						showmessage($LANG['operation_failure'], $PHP_REFERER);
					}
				}
				else
				{
					showmessage($sendto . $LANG['reached_maximum_number'], $PHP_REFERER);
				}
			}
			else
			{
				showmessage($sendto . $LANG['unable_send_message'] . $sendto, $PHP_REFERER);
			}
		}
		else
		{
			showmessage($sendto . $LANG['forbidden_group members'], $PHP_REFERER);
		}
	}
	else
	{
		showmessage($sendto . $LANG['not_member'], $PHP_REFERER);
	}
}
elseif (isset($mid) && intval($mid) > 0)
{
	$mid = intval($mid);
	if (isset($action) && in_array($action, array('reply', 'forward')))
	{
		$res = $db->query("SELECT sender,title,content,sendtime FROM ".TABLE_MESSAGE_INBOX." WHERE id=$mid AND receiver='$_username' AND forsake=0 AND types=0");
		if ($db->num_rows($res) > 0)
		{
			$row = $db->fetch_row($res);
			$sendtime = date('Y-m-d H:i:s', $row[3]);
			switch ($action)
			{
				case 'reply':
					$sendto = $row[0];
					$title = "Re:{$row[1]}";
					break;
				case 'forward':
					$sendto = "";
					$title = "Fw:{$row[1]}";
			}
			$content = "<span style='font-weight:bold'>{$LANG['primitive_message']}:</span><br><span style='font-weight:bold'>{$LANG['from']}:</span>{$row[0]}<br><span style='font-weight:bold'>{$LANG['title']}:</span>{$row[1]}<br><span style='font-weight:bold'>{$LANG['time']}:</span>{$sendtime}<br><span style='font-weight:bold'>{$LANG['Content']}:</span>{$row[2]}";
		}
		else
		{
			$sendto = "";
			$title = "";
			$content = "";
		}
	}
	elseif (isset($action) && $action == 'track')
	{
		$res = $db->query("SELECT title,content FROM ".TABLE_MESSAGE_INBOX." WHERE id=$mid AND sender='$_username'");
		if ($db->num_rows($res) > 0)
		{
			$row = $db->fetch_row($res);
			$sendto = "";
			$title = $row[0];
			$content = $row[1];
		}
		else
		{
			$sendto = "";
			$title = "";
			$content = "";
		}
	}
	else
	{
		$res = $db->query("SELECT receiver,title,content FROM ".TABLE_MESSAGE_OUTBOX." WHERE id=$mid AND sender='$_username' AND forsake=0");
		if ($db->num_rows($res) > 0)
		{
			$row = $db->fetch_row($res);
			$sendto = $row[0];
			$title = $row[1];
			$content = $row[2];
		}
		else
		{
			$sendto = "";
			$title = "";
			$content = "";
		}
	}
}
else
{
	$sendto = '';
	$title = '';
	$content = '';
}
include(MOD_ROOT.'/include/global.inc.php');
include(MOD_ROOT.'/include/friend.inc.php');
include template('message','send');
?>