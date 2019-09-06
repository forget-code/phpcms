<?php
defined('IN_PHPCMS') or exit('Access Denied');
$file = basename($PHP_SELF, '.php');
$res = $db->query("SELECT messagelimit FROM ".TABLE_MEMBER_GROUP." WHERE groupid='$_groupid' ORDER BY messagelimit DESC LIMIT 1");
$row = $db->fetch_row($res);
$limit = $row[0];
if ($limit == 0)
{
	showmessage($LANG['forbidden_your_group'], $PHP_REFERER);
}
$res = $db->query("(SELECT id,sender,title,sight,types,sendtime FROM ".TABLE_MESSAGE_INBOX." WHERE receiver='$_username' AND forsake=0 AND types=0) UNION ALL (SELECT ".TABLE_MESSAGE_INBOX.".id,".TABLE_MESSAGE_INBOX.".sender,".TABLE_MESSAGE_INBOX.".title,0,".TABLE_MESSAGE_INBOX.".types,".TABLE_MESSAGE_INBOX.".sendtime FROM ".TABLE_MESSAGE_INBOX." LEFT JOIN ".TABLE_MESSAGE_READ." ON ".TABLE_MESSAGE_INBOX.".id=".TABLE_MESSAGE_READ.".messageid AND ".TABLE_MESSAGE_READ.".userid='$_userid' AND ".TABLE_MESSAGE_READ.".forsake=1 WHERE ".TABLE_MESSAGE_INBOX.".types=1 AND ".TABLE_MESSAGE_READ.".messageid IS NULL) ORDER BY id DESC");
if ($db->num_rows($res) > 0)
{
	$inboxnum = $db->num_rows($res);
	$inbox = array();
	while ($row = $db->fetch_row($res))
	{
		$inbox[] = $row;
	}
	$res = $db->query("SELECT messageid FROM ".TABLE_MESSAGE_READ." WHERE userid='$_userid' AND forsake=0");
	if ($db->num_rows($res) > 0)
	{
		$unread = $inboxnum - $db->num_rows($res);
		for ($i = 0; $i < count($inbox); $i++)
		{
			if ($inbox[$i][3] == 1 && $inbox[$i][4] == 0)
			{
				if (isset($type) && $type == 'unread')
				{
					unset($inbox[$i]);
				}
				$unread--;
			}
		}
		$inbox = array_values($inbox);
		while ($row = $db->fetch_row($res))
		{
			for ($i = 0; $i < count($inbox); $i++)
			{
				if ($inbox[$i][0] == $row[0])
				{
					if (isset($type) && $type == 'unread')
					{
						unset($inbox[$i]);
					}
					else
					{
						$inbox[$i][3] = 1;
					}
				}
			}
		}
		$inbox = array_values($inbox);
	}
	else
	{
		$unread = $inboxnum;
		for ($i = 0; $i < count($inbox); $i++)
		{
			if ($inbox[$i][3] == 1 && $inbox[$i][4] == 0)
			{
				if (isset($type) && $type == 'unread')
				{
					unset($inbox[$i]);
				}
				$unread--;
			}
		}
		$inbox = array_values($inbox);
	}
}
else
{
	$inboxnum = 0;
	$unread = 0;
}
$res = $db->query("SELECT id,receiver,title,sendtime FROM ".TABLE_MESSAGE_OUTBOX." WHERE sender='$_username' AND forsake=0");
if ($db->num_rows($res) > 0)
{
	if (in_array($file, array('outbox', 'track')))
	{
		$outbox = array();
		while ($row = $db->fetch_row($res))
		{
			$outbox[] = $row;
		}
	}
	$outboxnum = $db->num_rows($res);
}
else
{
	$outboxnum = 0;
}
$res = $db->query("(SELECT id,sender,title,0,sendtime FROM ".TABLE_MESSAGE_INBOX." WHERE receiver='$_username' AND forsake=1 AND types=0) UNION ALL (SELECT id,receiver,title,1,sendtime FROM ".TABLE_MESSAGE_OUTBOX." WHERE sender='$_username' AND forsake=1) ORDER BY id DESC");
if ($db->num_rows($res) > 0)
{
	if ($file == 'recycle')
	{
		$recycle = array();
		while ($row = $db->fetch_row($res))
		{
			$recycle[] = $row;
		}
	}
	$recyclenum = $db->num_rows($res);
}
else
{
	$recyclenum = 0;
}
$totalnum = $inboxnum + $outboxnum + $recyclenum;
$percent = round(($totalnum / $limit) * 100, 2);
$arrPos  = array();
$arrPos['inbox'] = $LANG['inbox'];
$arrPos['outbox'] = $LANG['outbox'];
$arrPos['recycle'] = $LANG['recycle'];
$arrPos['track'] = $LANG['message_track'];
$arrPos['search'] = $LANG['message_search'];
$arrPos['export'] = $LANG['message_export'];
$arrPos['friends'] = $LANG['friends_list'];
$arrPos['send'] = $limit['send_message'];
if (isset($folder))
{
	$curpos = $arrPos[$folder];
}
else
{
	$curpos = $arrPos[$file];
}

$db->query("UPDATE ".TABLE_MEMBER." SET newmessages=$unread WHERE userid=$_userid");
?>