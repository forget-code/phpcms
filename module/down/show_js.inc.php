<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
$downid = isset($itemid) ? intval($itemid) : 0;
if(!$downid) exit;
$r = $db->get_one("select downid,hits,totaldowns,todaydowns,weekdowns,monthdowns,comments from ".channel_table('down', $channelid)." where downid=$downid ", "CACHE");
if($r['downid'])
{
	$db->query("update ".channel_table('down', $channelid)." set hits=hits+1 where downid=$downid ");
	echo "try {setidval('hits','".$r['hits']."');}catch(e){}\n";
	echo "try {setidval('totaldowns','".$r['totaldowns']."');}catch(e){}\n";
	echo "try {setidval('todaydowns','".$r['todaydowns']."');}catch(e){}\n";
	echo "try {setidval('weekdowns','".$r['weekdowns']."');}catch(e){}\n";
	echo "try {setidval('monthdowns','".$r['monthdowns']."');}catch(e){}";
	echo "try {setidval('commentnumber','".$r['comments']."');}catch(e){}\n";
}
?>