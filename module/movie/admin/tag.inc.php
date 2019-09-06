<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$action = $action ? $action : 'manage';
$actions = array('add','edit','copy','delete','manage','save', 'preview', 'checkname');
if(!in_array($action, $actions)) showmessage($LANG['illegal_action'],'goback');

$function = isset($function) ? $function : 'movie_list';
$functions = array('movie_list'=>$LANG['movie_list'],'movie_thumb'=>$LANG['image_movie'],'movie_slide'=>$LANG['slides_movie'],'movie_related'=>$LANG['related_movie']);
if(!array_key_exists($function, $functions)) showmessage($LANG['not_exist'].$function.$LANG['function_labels'], "goback");

$referer = isset($referer) ? $referer : "?mod=$mod&file=$file";

$tag_funcs = array(
	'movie_list'=>'$templateid,$channelid,$catid,$child,$specialid,$page,$movienum,$titlelen,$introducelen,$typeid,$posid,$datenum,$ordertype,$datetype,$showcatname,$showauthor,$showmovies,$target,$cols,$username,$letter',
	'movie_thumb'=>'$templateid,$channelid,$catid,$child,$specialid,$page,$movienum,$titlelen,$introducelen,$typeid,$posid,$datenum,$ordertype,$datetype,$showalt,$target,$imgwidth,$imgheight,$cols,$username,$onlythumb',
	'movie_slide'=>'$templateid,$channelid,$catid,$child,$specialid,$movienum,$titlelen,$typeid,$posid,$datenum,$ordertype,$imgwidth,$imgheight,$timeout,$effectid,$username,$thumbtype',
	'movie_related'=>'$templateid,$channelid,$keywords,$movieid,$movienum,$titlelen,$datetype',
);

$submenu = array();
foreach($functions as $func=>$name)
{
	$tab = $function == $func ? '<font color="red">'.$name.$LANG['labels'].'</font>' : $name.$LANG['labels'];
	$submenu[] = array($tab, "?mod=$mod&file=$file&action=manage&function=$func&channelid=$channelid");
}
	$submenu[] = array($LANG['label_list_of_topics'], "?mod=phpcms&file=tag&action=manage&function=phpcms_special_list&channelid=$channelid&keyid=$channelid");
	$submenu[] = array($LANG['category_labels'], "?mod=phpcms&file=tag&action=manage&function=phpcms_cat&channelid=$channelid&keyid=$channelid");
	$submenu[] = array($LANG['class_labels'], "?mod=phpcms&file=tag&action=manage&function=phpcms_type&channelid=$channelid&keyid=$channelid");
$menu = adminmenu($LANG['movie_label_manage'], $submenu);

require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();

require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
$tag = new tag($mod);

if(!$tag->writeable()) showmessage($LANG['action'],'goback');

$filename = ($action == 'add' || $action == 'edit' || $action == 'copy') ? MOD_ROOT.'/admin/'.$file.'_'.$action.'.inc.php' : PHPCMS_ROOT.'/admin/tag.inc.php';
include $filename;
?>