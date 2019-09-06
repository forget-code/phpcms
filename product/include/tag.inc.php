<?php 
defined('IN_PHPCMS') or exit('Access Denied');


$action = $action ? $action : 'manage';
$actions = array('add','edit','delete','manage','save', 'preview', 'checkname');
if(!in_array($action, $actions)) showmessage($LANG['illegal_action'],'goback');

$function = isset($function) ? $function : 'product_list';
$functions = array('product_list'=>$LANG['product_list'],'product_thumb'=>$LANG['picture_product'],'product_slide'=>$LANG['product_slides']);
if(!array_key_exists($function, $functions)) showmessage($LANG['not_exist'].$function.$LANG['function_label'], "goback");

$referer = isset($referer) ? $referer : "?mod=$mod&file=$file";

$tag_funcs = array(
	'product_list'=>'$templateid, $catid, $brand_id, $child, $page, $productnum, $titlelen, $descriptionlen, $typeid,$posid, $datenum, $ordertype, $datetype,$showcatname, $showbrand,$showhits,$showprice,$showmarketprice,$showcartlink,$showviewlink,$target, $cols,$fromprice,$toprice',
	'product_thumb'=>'$templateid,$catid,$brand_id, $child, $page, $productnum, $titlelen, $descriptionlen, $typeid, $posid, $datenum, $ordertype, $datetype, $showalt, $showprice,$showmarketprice, $showcatname,$showbrand,$showcartlink,$showviewlink,$target, $imgwidth, $imgheight, $cols,$fromprice,$toprice,$showtitle',
	'product_slide'=>'$templateid,$catid,$brand_id, $child, $productnum, $titlelen, $typeid, $posid, $datenum, $ordertype, $imgwidth, $imgheight, $timeout, $effectid',
);

$submenu = array();
foreach($functions as $func=>$name)
{
	$submenu[] = array($name.$LANG['label'], "?mod=$mod&file=$file&action=manage&function=$func");
}
$menu = adminmenu($LANG['product_label_manage'], $submenu);

require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();

require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
$tag = new tag($mod);

if(!$tag->writeable()) showmessage($LANG['template_dir_not_writeable'],'goback');

include MOD_ROOT.'/admin/'.$file.'_'.$action.'.inc.php';
?>