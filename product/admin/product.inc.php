<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT."/$mod/include/product.class.php";
require_once PHPCMS_ROOT."/$mod/include/urlrule.inc.php";
require_once PHPCMS_ROOT."/include/tree.class.php";
require_once(PHPCMS_ROOT."/$mod/include/cache.func.php");
$pdtcls = new product();
$productid = isset($productid) ? intval($productid) : 0 ;
if($productid)
{
	$pdtcls->productid = $productid;
}
$tree = new tree();
$BRANDS = cache_read('product_brands.php');
$module = $mod;
$catid = isset($catid) ? $catid : 0;
$submenu=array(
	array($LANG['product_list'],'?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['recycle_manage'],'?mod='.$mod.'&file='.$file.'&action=manage&job=recycle'),
	array('<font color="blue">'.$LANG['generate_product_html'].'</a>','?mod='.$mod.'&file=createhtml')
	);
$menu=adminmenu($LANG['product_manage_index'],$submenu);
$referer = isset($referer) ? $referer : $PHP_REFERER;
$action = isset($action) ? $action : 'manage';
$filearray = array('add','edit','delete','manage','listorder','checktitle','action','recycle','move','main');
in_array($action,$filearray) or showmessage($LANG['illegal_action'],$referer);
require $file."_".$action.".inc.php";
?>