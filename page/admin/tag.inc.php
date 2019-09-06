<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$keyid = isset($keyid) ? $keyid : 'phpcms';
$action = $action ? $action : 'manage';
$actions = array('add','edit','copy','delete','manage','save', 'preview', 'checkname');
if(!in_array($action, $actions)) showmessage($LANG['illegal_action'],'goback');

$function = isset($function) ? $function : 'page_list';
$functions = array('page_list'=>$LANG['single_page_list']);
if(!array_key_exists($function, $functions)) showmessage($LANG['not_exist']." $function ".$LANG['function_label'], "goback");

$referer = isset($referer) ? $referer : "?mod=$mod&file=$file";

$tag_funcs = array(
	'page_list'=>'$templateid,$keyid,$num',
);

$submenu = array();
foreach($functions as $func=>$name)
{
	$submenu[] = array($name.$LANG['label'], "?mod=$mod&file=$file&action=manage&function=$func&keyid=$keyid");
}
$menu = adminmenu($LANG['single_page_label_manage'], $submenu);

require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();

require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
$tag = new tag($mod);

if(!$tag->writeable()) showmessage($LANG['template_dir_not_writeable'],'goback');

$filename = ($action == 'add' || $action == 'edit' || $action == 'copy') ? MOD_ROOT.'/admin/'.$file.'_'.$action.'.inc.php' : PHPCMS_ROOT.'/admin/tag.inc.php';
include $filename;
?>