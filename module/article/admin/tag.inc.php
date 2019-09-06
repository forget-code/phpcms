<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$action = $action ? $action : 'manage';
$actions = array('add','edit','copy','delete','manage','save', 'preview', 'checkname');
if(!in_array($action, $actions)) showmessage($LANG['access_denied'],'goback');

$function = isset($function) ? $function : 'article_list';
$functions = array('article_list'=>$LANG['article_list'],'article_thumb'=>$LANG['article_thumb'],'article_slide'=>$LANG['article_slide'],'article_related'=>$LANG['article_related']);
if(!array_key_exists($function, $functions)) showmessage($LANG['not_exists'] .$function .$LANG['tag'], "goback");

$referer = isset($referer) ? $referer : "?mod=$mod&file=$file";

$tag_funcs = array(
	'article_list'=>'$templateid,$channelid,$catid,$child,$specialid,$page,$articlenum,$titlelen,$introducelen,$typeid,$posid,$datenum,$ordertype,$datetype,$showcatname,$showauthor,$showhits,$target,$cols,$username',
	'article_thumb'=>'$templateid,$channelid,$catid,$child,$specialid,$page,$articlenum,$titlelen,$introducelen,$typeid,$posid,$datenum,$ordertype,$datetype,$showalt,$target,$imgwidth,$imgheight,$cols,$username',
	'article_slide'=>'$templateid,$channelid,$catid,$child,$specialid,$articlenum,$titlelen,$typeid,$posid,$datenum,$ordertype,$imgwidth,$imgheight,$timeout,$effectid,$username',
	'article_related'=>'$templateid,$channelid,$keywords,$articleid,$articlenum,$titlelen,$datetype'
);

$submenu = array();
foreach($functions as $func=>$name)
{
	$tab = $function == $func ? '<font color="red">'.$name.$LANG['label'].'</font>' : $name.$LANG['label'];
	$submenu[] = array($tab, "?mod=$mod&file=$file&action=manage&function=$func&channelid=$channelid");
}
	$submenu[] = array($LANG['special_list_tag'], "?mod=phpcms&file=tag&action=manage&function=phpcms_special_list&channelid=$channelid&keyid=$channelid");
	$submenu[] = array($LANG['category_tag'], "?mod=phpcms&file=tag&action=manage&function=phpcms_cat&channelid=$channelid&keyid=$channelid");
	$submenu[] = array($LANG['sort_tag'], "?mod=phpcms&file=tag&action=manage&function=phpcms_type&channelid=$channelid&keyid=$channelid");


$menu = adminmenu($LANG['manage_article_tag'], $submenu);

require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();

require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
$tag = new tag($mod);

if(!$tag->writeable()) showmessage($LANG['to_user_editer_chomd_templates'],'goback');

$filename = ($action == 'add' || $action == 'edit' || $action == 'copy') ? MOD_ROOT.'/admin/'.$file.'_'.$action.'.inc.php' : PHPCMS_ROOT.'/admin/tag.inc.php';
include $filename;
?>