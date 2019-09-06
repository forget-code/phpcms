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
		$db->query("DELETE FROM ".TABLE_MESSAGE_INBOX." WHERE id IN ($mids) AND sender='$_username'");
	}
}
elseif (isset($action) && $action == 'delete' && isset($mid) && intval($mid) > 0)
{
	$mid = intval($mid);
	$db->query("DELETE FROM ".TABLE_MESSAGE_INBOX." WHERE id=$mid AND sender='$_username'");
}
$res = $db->query("SELECT id,receiver,title,sight,sendtime FROM ".TABLE_MESSAGE_INBOX." where sender='$_username' ORDER BY id DESC");
if ($db->num_rows($res) > 0)
{
	$track = array();
	while ($row = $db->fetch_row($res))
	{
		$track[] = $row;
	}
}
include(MOD_ROOT.'/include/global.inc.php');
include template('message','track');
?>