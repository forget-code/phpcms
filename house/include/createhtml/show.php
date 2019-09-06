<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$BRANDS = cache_read('product_brands.php');
$productid = isset($productid) ? intval($productid) : 0;
if(!$productid) return FALSE;
$product = $db->get_one("SELECT * FROM ".TABLE_PRODUCT." WHERE productid=$productid ");
if(!$product['productid'] || !$product['ishtml']) return FALSE;
if(!$product['pdt_img']) $product['pdt_img'] = "images/nopic.gif";
if(!$product) return FALSE;
extract($product);
unset($product);
$onsale or showmessage($LANG['product_no_sale'], 'goback');
$CAT = cache_read('category_'.$catid.'.php');
$title = $pdt_name;

$query = "SELECT pa.pdtatt_id,pa.productid,pa.att_id,pa.att_value,a.att_id,a.att_name   FROM ".TABLE_PRODUCT_PDTATT." pa,".TABLE_PRODUCT_ATT." a ".
		"WHERE pa.productid = $productid AND pa.att_id = a.att_id ORDER BY pa.pdtatt_id ASC";
$result = $db->query($query);
$pdt_atts = array();
while($r = $db->fetch_array($result))
{
	$pdt_atts[] = $r;
}

$head['title'] = $pdt_name."-".$CAT['catname'];
$head['keywords'] = $pdt_keyword.",".$CAT['seo_keywords'].",".$MOD['seo_keywords'];
$head['description'] = $CAT['seo_description'].'-'.$MOD['seo_description'];

$itemurl = linkurl($linkurl);
$adddate = date('Y-m-d H:i:s',$addtime);
$position = catpos($catid);
$cat_name = $CAT['catname'];
$cat_url = linkurl($CAT['linkurl']);

$skinid = $skinid ? $skinid : $CAT['defaultitemskin'];
$skindir = $skinid ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$skinid : $skindir;
$templateid = $templateid ? $templateid : $CAT['defaultitemtemplate'];
$templateid = $templateid ? $templateid : "content";
ob_start();
include template($mod, $templateid);
$data = ob_get_contents();
ob_clean();
$filepath = item_url('path', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $productid, $addtime);		
$filepath = PHPCMS_ROOT.'/'.$filepath;
$dir = dirname($filepath);
dir_create($dir);
file_put_contents($filepath,$data);
return TRUE;
?>