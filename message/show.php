<?php
require './include/common.inc.php';
if (isset($folder))
{
	switch ($folder)
	{
		case 'inbox':
			if (isset($mid) && isset($types))
			{
				$res = $db->query("SELECT sender,title,content,sendtime FROM ".TABLE_MESSAGE_INBOX." WHERE id=".intval($mid)." AND types=".intval($types)." AND receiver IN ('$_username','null')");
				if ($db->num_rows($res) > 0)
				{
					$row = $db->fetch_row($res);
					$message = array();
					$message = $row;
					if (intval($types) == 0)
					{
						$db->query("UPDATE ".TABLE_MESSAGE_INBOX." SET sight=1 WHERE id=".intval($mid)." AND types=0 AND receiver='$_username'");
					}
					else
					{
						$res = $db->query("SELECT id FROM ".TABLE_MESSAGE_READ." WHERE messageid=".intval($mid)." AND userid='$_userid'");
						if ($db->num_rows($res) < 1)
						{
							$db->query("INSERT INTO ".TABLE_MESSAGE_READ." (messageid,userid) VALUES (".intval($mid).",'$_userid')");
						}
					}
				}
				else
				{
					showmessage($LANG['illegal_operation'], $PHP_REFERER);
				}
			}
			break;
		case 'outbox':
			if (isset($mid) && intval($mid) > 0)
			{
				$res = $db->query("SELECT receiver,title,content,sendtime FROM ".TABLE_MESSAGE_OUTBOX." WHERE id=".intval($mid)." AND sender='$_username' AND forsake=0");
				if ($db->num_rows($res) > 0)
				{
					$row = $db->fetch_row($res);
					$message = array();
					$message = $row;
				}
				else
				{
					showmessage($LANG['illegal_operation'], $PHP_REFERER);
				}
			}
			else
			{
				showmessage($LANG['illegal_operation'], $PHP_REFERER);
			}
			break;
		case 'recycle':
			if (isset($mid) && isset($types))
			{
				if (intval($types == 0))
				{
					$res = $db->query("SELECT sender,title,content,sendtime FROM ".TABLE_MESSAGE_INBOX." WHERE id=".intval($mid)." AND receiver='$_username' AND types=0 AND forsake=1");
				}
				else
				{
					$res = $db->query("SELECT receiver,title,content,sendtime FROM ".TABLE_MESSAGE_OUTBOX." WHERE id=".intval($mid)." AND sender='$_username' AND forsake=1");
				}
				if ($db->num_rows($res) > 0)
				{
					$row = $db->fetch_row($res);
					$message = array();
					$message = $row;
				}
				else
				{
					showmessage($LANG['illegal_operation'], $PHP_REFERER);
				}
			}
			else
			{
				showmessage($LANG['illegal_operation'], $PHP_REFERER);
			}
			break;
		case 'track':
			if (isset($mid) && intval($mid) > 0)
			{
				$res = $db->query("SELECT receiver,title,content,sendtime FROM ".TABLE_MESSAGE_INBOX." WHERE id=".intval($mid)." AND sender='$_username'");
				if ($db->num_rows($res) > 0)
				{
					$row = $db->fetch_row($res);
					$message = array();
					$message = $row;
				}
				else
				{
					showmessage($LANG['illegal_operation'], $PHP_REFERER);
				}
			}
			else
			{
				showmessage($LANG['illegal_operation'], $PHP_REFERER);
			}
	}
}
else
{
	showmessage($LANG['illegal_operation'], $PHP_REFERER);
}
include(MOD_ROOT.'/include/global.inc.php');
include template('message','show'.$folder);
?>