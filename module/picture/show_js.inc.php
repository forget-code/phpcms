<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
$pictureid = isset($itemid) ? intval($itemid) : 0;
if(!$pictureid) exit;
$r = $db->get_one("select pictureid,hits,comments from ".channel_table('picture', $channelid)." where pictureid=$pictureid ", "CACHE");
if($r['pictureid'])
{
	$db->query("update ".channel_table('picture', $channelid)." set hits=hits+1 where pictureid=$pictureid ");
	echo "try {setidval('hits','".$r['hits']."');}catch(e){}\n";
	echo "try {setidval('commentnumber','".$r['comments']."');}catch(e){}\n";
}
?>