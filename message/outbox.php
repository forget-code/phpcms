<?php
require './include/common.inc.php';
if ($dosubmit)
{
	$mids = "";
	foreach ($mid as $value)
	{
		$mids .= intval($value) . ',';
	}
	if (!empty($mids))
	{
		$mids = substr($mids, 0, -1);
		if (isset($quite))
		{
			$db->query("DELETE FROM ".TABLE_MESSAGE_OUTBOX." WHERE id IN ($mids) AND sender='$_username'");
		}
		else
		{
			$db->query("UPDATE ".TABLE_MESSAGE_OUTBOX." SET forsake=1 WHERE id IN ($mids) AND sender='$_username'");
		}
	}
}
elseif (isset($action) && isset($mid) && intval($mid) > 0)
{
	$mid = intval($mid);
	switch ($action)
	{
		case 'quite':
			$db->query("DELETE FROM ".TABLE_MESSAGE_OUTBOX." WHERE id=$mid AND sender='$_username'");
			break;
		case 'delete':
			$db->query("UPDATE ".TABLE_MESSAGE_OUTBOX." SET forsake=1 WHERE id=$mid AND sender='$_username'");
	}
}
include(MOD_ROOT.'/include/global.inc.php');
include template('message','outbox');
?>