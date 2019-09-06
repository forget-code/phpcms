<?php 
require_once './include/common.inc.php';
if($key=='houseid')
{
	$houseid = isset($itemid) ? intval($itemid) : 0;
	if(!$houseid) exit;
	$r = $db->get_one("select houseid,hits,comments from ".TABLE_HOUSE." where houseid=$houseid ", "CACHE");
	if($r['houseid'])
	{
		$db->query("update ".TABLE_HOUSE." set hits=hits+1 where houseid=$houseid");
		echo "try {setidval('commentnumber','".$r['comments']."');}catch(e){};\n";
		echo "try {setidval('hits','".$r['hits']."');}catch(e){};\n";
	}
}
else if($key=='displayid')
{
	$displayid = isset($itemid) ? intval($itemid) : 0;
	if(!$displayid) exit;
	$r = $db->get_one("select displayid,hits,comments from ".TABLE_HOUSE_DISPLAY." where displayid=$displayid ", "CACHE");
	if($r['displayid'])
	{
		$db->query("update ".TABLE_HOUSE_DISPLAY." set hits=hits+1 where displayid=$displayid");
		echo "try {setidval('commentnumber','".$r['comments']."');}catch(e){};\n";
		echo "try {setidval('hits','".$r['hits']."');}catch(e){};\n";
	}
}
?>