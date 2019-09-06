<?php 

include_once './include/common.inc.php';

if(!$productid) showmessage($LANG['illegal_id']);
$productid = intval($productid);

$pdt = $db->get_one("SELECT pdt_name,pdt_img FROM ".TABLE_PRODUCT." WHERE productid=".$productid);
if(!$pdt) showmessage($LANG['product_not_exist']);
if(!$pdt['pdt_img']) $pdt['pdt_img'] = "images/nopic.gif";

$query = "SELECT * FROM ".TABLE_PRODUCT_IMAGES." WHERE productid=".$productid;
$result = $db->query($query);
$gallerys = array();
while ($r = $db->fetch_array($result))
{
	$gallerys[] = $r;
}
include template($mod,'gallery');
?>