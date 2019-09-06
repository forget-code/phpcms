<?php
defined('IN_PHPCMS') or exit('Access Denied');
if ($dosubmit)
{
	$types = intval($types);
	$time = intval($time);
	if ($time == 0)
	{
		$sql = "DELETE FROM ".TABLE_MESSAGE_INBOX." WHERE types=$types";
		$db->query("TRUNCATE TABLE ".TABLE_MESSAGE_READ);
	}
	else
	{
		$time = time() - $time * 24 * 60 * 60;
		$res = $db->query("SELECT ID FROM ".TABLE_MESSAGE_INBOX." WHERE types=$types AND sendtime<'$time'");
		if ($db->num_rows($res)) {
			$mid = array();
			while ($row = $db->fetch_row($res)) $mid = $row[0];
			$ids = implode(',', $mid);
			$db->query("DELETE FROM ".TABLE_MESSAGE_READ." WHERE messageid in $ids");
			$sql = "DELETE FROM ".TABLE_MESSAGE_INBOX." WHERE types=$types AND sendtime<'$time'";
		}
	}
	$db -> query($sql);
	showmessage('', $PHP_REFERER);
}
else
{
	$sysmessage = array();
	$uermessage = array();
	$res = $db -> query("SELECT COUNT(*),MIN(sendtime),types FROM ".TABLE_MESSAGE_INBOX." GROUP BY types");
	while ($row = $db -> fetch_row($res))
	{
		if ($row[2] == 1)
		{
			$sysmessage[] = $row[0];
			$sysmessage[] = date('Y-m-d', $row[1]);
		}
		else
		{
			$uermessage[] = $row[0];
			$uermessage[] = date('Y-m-d', $row[1]);
		}
	}
	$arrcnt1 = count($sysmessage);
	$arrcnt2 = count($uermessage);
}
?>