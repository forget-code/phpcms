<?php
defined('IN_PHPCMS') or exit('Access Denied');
$result = $db->query("select * from ".$CONFIG['tablepre']."channel where module='down' ");
while($r = $db->fetch_array($result))
{
	if($r['islink']) continue;
	$table = $CONFIG['tablepre']."down_".$r['channelid'];
	$db->query("DROP TABLE IF EXISTS $table ");
	dir_delete(PHPCMS_ROOT.'/'.$r['channeldir'].'/');
}
$db->query("DELETE FROM ".$CONFIG['tablepre']."channel WHERE module='down'");
$db->query("DELETE FROM ".$CONFIG['tablepre']."module WHERE module='down'");
$db->query("DROP TABLE IF EXISTS ".$CONFIG['tablepre']."down_server ");

dir_delete(PHPCMS_ROOT.'/module/down/');
?>