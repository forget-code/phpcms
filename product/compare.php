<?php 
require './include/common.inc.php';
if(empty($pids)) showmessage($LANG['no_product_compare'],"close");
$pcount = count($pids);
if($pcount>8) showmessage($LANG['product_greater_than8'],"close");
if(!$MOD['showcompare']) showmessage($LANG['no_promission_to_compare'],"close");

$head['title'] = $LANG['product_compare'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];

$pdts = array();
$att_names = array();
for($i=0;$i<$pcount;$i++)
{
	$productid = $pids[$i];
	if(!intval($productid)) continue;
	$product = $db->get_one("SELECT * FROM ".TABLE_PRODUCT." WHERE productid=$productid limit 1");
	if(!$product) $product['pdt_name'] = $LANG['product_not_exist'];
	if(!$product['pdt_img']) $product['pdt_img'] = "images/nopic.gif";
	$product['pdt_img'] = imgurl($product['pdt_img']);
	if(!$product['onsale']) 
	{
		$product = array();
		$product['pdt_name'] = $LANG['product_no_sale'];
	}
	$CAT = cache_read('category_'.$catid.'.php');
	
	
	$query = "SELECT pa.pdtatt_id,pa.productid,pa.att_id,pa.att_value,a.att_id,a.att_name   FROM ".TABLE_PRODUCT_PDTATT." pa,".TABLE_PRODUCT_ATT." a ".
			 "WHERE pa.productid = $productid AND pa.att_id = a.att_id ORDER BY pa.pdtatt_id ASC";
	$result = $db->query($query);
	$pdt_atts = array();
	$flag = empty($att_names)? true : false;
	while($r = $db->fetch_array($result))
	{
		if($flag) $att_names[] = $r['att_name'];
		$pdt_atts[] = $r;
	}
	
	$pdts[$productid] = $product;
	$pdts[$productid]['att_value'] = $pdt_atts;

}
include template($mod,"compare");
?>
