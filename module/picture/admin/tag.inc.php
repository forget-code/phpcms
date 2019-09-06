<?php 
defined('IN_PHPCMS') or exit('Access Denied');


$action = $action ? $action : 'manage';
$actions = array('add','edit','copy','delete','manage','save', 'preview', 'checkname');
if(!in_array($action, $actions)) showmessage($LANG['illegal_action'],'goback');

$function = isset($function) ? $function : 'picture_list';
$functions = array('picture_list'=>$LANG['picture_list'],'picture_thumb'=>$LANG['photo_picture'],'picture_slide'=>$LANG['slide_picture'],'picture_related'=>$LANG['relative_picture']);
if(!array_key_exists($function, $functions)) showmessage($LANG['not_exist']." $function ".$LANG['function_label'], "goback");

$referer = isset($referer) ? $referer : "?mod=$mod&file=$file";

$tag_funcs = array(	'picture_list'=>'$templateid,$channelid,$catid,$child,$specialid,$page,$picturenum,$titlelen,$introducelen,$typeid,$posid,$datenum,$ordertype,$datetype,$showcatname,$showauthor,$hits,$target,$cols,$username',
	'picture_thumb'=>'$templateid,$channelid,$catid,$child,$specialid,$page,$picturenum,$titlelen,$introducelen,$typeid,$posid,$datenum,$ordertype,$datetype,$showalt,$target,$imgwidth,$imgheight,$cols,$username',
	'picture_slide'=>'$templateid,$channelid,$catid,$child,$specialid,$picturenum,$titlelen,$typeid,$posid,$datenum,$ordertype,$imgwidth,$imgheight,$timeout,$effectid,$username',
	'picture_related'=>'$templateid,$channelid,$keywords,$pictureid,$picturenum,$titlelen,$datetype',
);

$submenu = array();

foreach($functions as $func=>$name)
{
	$tab = $function == $func ? '<font color="red">'.$name.$LANG['label'].'</font>' : $name.$LANG['label'];
	$submenu[] = array($tab, "?mod=$mod&file=$file&action=manage&function=$func&channelid=$channelid");
}
	$submenu[] = array($LANG['specail_list_label'], "?mod=phpcms&file=tag&action=manage&function=phpcms_special_list&channelid=$channelid&keyid=$channelid");
	$submenu[] = array($LANG['category_label'], "?mod=phpcms&file=tag&action=manage&function=phpcms_cat&channelid=$channelid&keyid=$channelid");
	$submenu[] = array($LANG['type_label'], "?mod=phpcms&file=tag&action=manage&function=phpcms_type&channelid=$channelid&keyid=$channelid");
$menu = adminmenu($LANG['picture_label_manage'], $submenu);

require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();

require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
$tag = new tag($mod);

if(!$tag->writeable()) showmessage($LANG['template_dir_not_writeable'],'goback');

$filename = ($action == 'add' || $action == 'edit' || $action == 'copy') ? MOD_ROOT.'/admin/'.$file.'_'.$action.'.inc.php' : PHPCMS_ROOT.'/admin/tag.inc.php';
include $filename;
?>