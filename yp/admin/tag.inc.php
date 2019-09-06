<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once PHPCMS_ROOT.'/include/formselect.func.php';
require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();
$function = isset($function) ? $function : 'yp_article_list';
require_once MOD_ROOT.'/include/trade.func.php';
if($function=='yp_buy_list')
{
	$TRADE = cache_read('trades_buy.php');
}
elseif($function=='yp_company_list')
{
	$TRADE = cache_read('trades_trade.php');
}
elseif($function=='yp_sales_list' || $function=='yp_sales_thumb')
{
	$TRADE = cache_read('trades_sales.php');
}
else
{
	$TRADE = cache_read('trades_article.php');
}
$keyid = isset($keyid) ? $keyid : 'phpcms';
$action = $action ? $action : 'manage';
$actions = array('add','edit','delete','manage','save', 'preview', 'checkname','copy');
if(!in_array($action, $actions)) showmessage($LANG['illegal_operation'],'goback');
$functions = array('yp_article_list'=>$LANG['article_list'],'yp_article_thumb'=>$LANG['article_thumb'],'yp_article_slide'=>$LANG['article_slide'],'yp_product_list'=>$LANG['product_list'],'yp_product_thumb'=>$LANG['product_thumb'],'yp_product_slide'=>$LANG['product_slide'],'yp_job_list'=>$LANG['job_list'],'yp_apply_list'=>$LANG['apply_list'],'yp_company_list'=>$LANG['company_list'],'yp_buy_list'=>$LANG['buy_list'],'yp_sales_list'=>$LANG['sales_list'],'yp_sales_thumb'=>$LANG['sales_thumb']);
if(!array_key_exists($function, $functions)) showmessage($LANG['not_exist']." $function ".$LANG['function_label'], "goback");
$forward = isset($forward) ? $forward : "?mod=$mod&file=$file";

$tag_funcs = array(
	'yp_article_list'=>'$templateid,$catid,$child,$page,$articlenum,$titlelen,$introducelen,$posid,$datenum,$ordertype,$datetype,$showcatname,$showauthor,$showhits,$target,$cols,$username,$elite',
	'yp_article_thumb'=>'$templateid,$catid,$child,$page,$articlenum,$titlelen,$introducelen,$posid,$datenum,$ordertype,$datetype,$showalt,$target,$imgwidth,$imgheight,$cols,$username,$elite',
	'yp_article_slide'=>'$templateid,$catid,$child,$articlenum,$titlelen,$posid,$datenum,$ordertype,$imgwidth,$imgheight,$timeout,$effectid,$username,$elite',
	'yp_product_list'=>'$templateid,$catid,$child,$page,$productnum,$titlelen,$introducelen,$posid,$datenum,$ordertype,$datetype,$showcatname,$showauthor,$showhits,$target,$cols,$username,$elite',
	'yp_product_thumb'=>'$templateid,$catid,$child,$page,$number,$titlelen,$introducelen,$posid,$datenum,$ordertype,$datetype,$showalt,$target,$imgwidth,$imgheight,$cols,$username,$elite',
	'yp_product_slide'=>'$templateid,$catid,$child,$number,$titlelen,$posid,$datenum,$ordertype,$imgwidth,$imgheight,$timeout,$effectid,$username,$elite',
	'yp_job_list'=>'$templateid,$station,$page,$jobnum,$titlelen,$introducelen,$posid,$datenum,$ordertype,$datetype,$showstationname,$showauthor,$showhits,$target,$cols,$username,$elite',
	'yp_apply_list'=>'$templateid,$station,$page,$applynum,$posid,$datenum,$ordertype,$datetype,$showexperience,$showschool,$showspecialty,$showhits,$target,$cols,$elite',
	'yp_company_list'=>'$templateid,$tradeid,$child,$page,$elite,$vip,$number,$length,$posid,$datenum,$ordertype,$datetype,$showcontact,$showhits,$target,$cols,$pattern',
	'yp_buy_list'=>'$templateid,$tradeid,$child,$page,$productnum,$titlelen,$introducelen,$posid,$datenum,$ordertype,$datetype,$showcatname,$showauthor,$showhits,$target,$cols,$username,$elite',
	'yp_sales_list'=>'$templateid,$tradeid,$child,$page,$productnum,$titlelen,$introducelen,$posid,$datenum,$ordertype,$datetype,$showcatname,$showauthor,$showhits,$target,$cols,$username,$elite',
	'yp_sales_thumb'=>'$templateid,$tradeid,$child,$page,$number,$titlelen,$introducelen,$posid,$datenum,$ordertype,$datetype,$showalt,$target,$imgwidth,$imgheight,$cols,$username,$elite',
);
$submenu = array();
foreach($functions as $func=>$name)
{
	$submenu[] = array($name.$LANG['label'], "?mod=$mod&file=$file&action=manage&function=$func&keyid=$keyid");
}
$submenu[] = array($LANG['category'].$LANG['label'], "?mod=phpcms&file=tag&action=manage&function=phpcms_cat&channelid=0&keyid=article");

$menu = adminmenu($LANG['yp_label_manage'], $submenu);
require_once MOD_ROOT.'/include/tag.func.php';
require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
$tag = new tag($mod);
if(!$tag->writeable()) showmessage($LANG['template_dir_not_writeable'],'goback');
$filename = ($action == 'add' || $action == 'edit' || $action == 'copy') ? MOD_ROOT.'/admin/'.$file.'_'.$action.'.inc.php' : PHPCMS_ROOT.'/admin/tag.inc.php';
include $filename;
?>