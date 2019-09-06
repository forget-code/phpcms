<?php
defined('IN_PHPCMS') or exit('Access Denied');

$result = $db->query("select * from ".$CONFIG['tablepre']."channel where module='picture' ");
while($r = $db->fetch_array($result))
{
	if($r['islink']) continue;
	$table = $CONFIG['tablepre']."picture_".$r['channelid'];
	$db->query("DROP TABLE IF EXISTS $table ");
	dir_delete(PHPCMS_ROOT.'/'.$r['channeldir'].'/');
}
$db->query("DELETE FROM ".$CONFIG['tablepre']."channel WHERE module='picture'");
$db->query("DELETE FROM ".$CONFIG['tablepre']."module WHERE module='picture'");

dir_delete(PHPCMS_ROOT.'/module/picture/');
?>