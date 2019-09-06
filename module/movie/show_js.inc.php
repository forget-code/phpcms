<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
$movieid = isset($itemid) ? intval($itemid) : 0;
if(!$movieid) exit;
$r = $db->get_one("select movieid,hits,totalview,todayview,weekview,monthview,comments from ".channel_table('movie', $channelid)." where movieid=$movieid ", "CACHE");
if($r['movieid'])
{
	$db->query("update ".channel_table('movie', $channelid)." set hits=hits+1 where movieid=$movieid ");
	echo "try {setidval('hits','".$r['hits']."');}catch(e){}\n";
	echo "try {setidval('totalview','".$r['totalview']."');}catch(e){}\n";
	echo "try {setidval('todayview','".$r['todayview']."');}catch(e){}\n";
	echo "try {setidval('weekview','".$r['weekview']."');}catch(e){}\n";
	echo "try {setidval('monthview','".$r['monthview']."');}catch(e){}";
	echo "try {setidval('commentnumber','".$r['comments']."');}catch(e){}\n";
}
?>