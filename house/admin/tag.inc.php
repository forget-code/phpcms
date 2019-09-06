<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT."/$mod/include/tag.func.php";
require_once PHPCMS_ROOT."/$mod/include/formselect.func.php";

$action = $action ? $action : 'manage';
$actions = array('add','edit','delete','manage','save', 'preview', 'checkname');
if(!in_array($action, $actions)) showmessage($LANG['illegal_action'],'goback');

$function = isset($function) ? $function : 'display_list';
$iftype = '';
foreach ($PARS['infotype'] as $k=>$v)
{
	if(strpos($k,'type_')>-1)
	{
		$iftype.= $v.",";
	}
}
$functions = array('display_list'=>'楼盘列表','house_list'=>'房产信息列表（'.$iftype.'等）','member_list'=>'会员（中介，房地产商）列表');
if(!array_key_exists($function, $functions)) showmessage($LANG['not_exist']." $function ".$LANG['function_label'], "goback");

$referer = isset($referer) ? $referer : "?mod=$mod&file=$file";

$tag_funcs = array(
	'display_list'=>'$templateid,$areaid,$develop,$startpricestart,$startpriceend,$avgpricestart,$avgpriceend,$page, $displaynum,$titlelen, $descriptionlen, $typeid,$posid, $datenum, $ordertype, $datetype, $showhits,$showareaidname,$showprice,$target, $cols',
	'house_list'=>'$templateid,$infocat,$areaid,$pricestart,$priceend,$page, $housenum, $titlelen, $descriptionlen, $typeid,$posid, $datenum , $ordertype, $datetype, $showhits,$showareaidname,$showprice,$target, $cols, $username',
	'member_list'=>'$templateid,$membertype,$membernum,$page,$ordertype,$target', 	
);


$submenu = array();
foreach($functions as $func=>$name)
{
	$submenu[] = array($name.$LANG['label'], "?mod=$mod&file=$file&action=manage&function=$func");
}
$menu = adminmenu('楼盘标签管理', $submenu);

require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
$tag = new tag($mod);

if(!$tag->writeable()) showmessage($LANG['template_dir_not_writeable'],'goback');

$filename = ($action == 'add' || $action == 'edit') ? MOD_ROOT.'/admin/'.$file.'_'.$action.'.inc.php' : PHPCMS_ROOT.'/admin/tag.inc.php';
include $filename;
?>