<?php
defined('IN_PHPCMS') or exit('Access Denied');

$result = $db->query("select * from ".$CONFIG['tablepre']."channel where module='info' ");
while($r = $db->fetch_array($result))
{
	if($r['islink']) continue;
	$table = $CONFIG['tablepre']."info_".$r['channelid'];
	$db->query("DROP TABLE IF EXISTS $table ");
	dir_delete(PHPCMS_ROOT.'/'.$r['channeldir'].'/');
}

$db->query("DROP TABLE IF EXISTS ".$CONFIG['tablepre']."info_area ");
$db->query("DELETE FROM ".$CONFIG['tablepre']."channel WHERE module='info'");
$db->query("DELETE FROM ".$CONFIG['tablepre']."module WHERE module='info'");

dir_delete(PHPCMS_ROOT.'/module/info/');
?>