<?php 
require_once './include/common.inc.php';
$productid = isset($itemid) ? intval($itemid) : 0;
if(!$productid) exit;
$r = $db->get_one("select productid,catid,hits,comments from ".TABLE_PRODUCT." where productid=$productid ", "CACHE");
if($r['productid'])
{
	$db->query("update ".TABLE_PRODUCT." set hits=hits+1 where productid=$productid");
	echo "try {setidval('commentnumber','".$r['comments']."');}catch(e){};\n";
}
?>