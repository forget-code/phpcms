<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require_once PHPCMS_ROOT."/$mod/include/tag.func.php";

$action = $action ? $action : 'manage';
$actions = array('add','edit','delete','manage','save', 'preview', 'checkname','changetemplate');
if(!in_array($action, $actions)) showmessage($LANG['illegal_action'],'goback');

$function = isset($function) ? $function : 'formguide';
$functions = array('formguide'=>$LANG['invoke_form']);
if(!array_key_exists($function, $functions)) showmessage($LANG['not_exist']." $function ".$LANG['function_label'], "goback");

$referer = isset($referer) ? $referer : "?mod=$mod&file=$file";

$tag_funcs = array(
	'formguide'=>'$templateid,$formid'
	);

$submenu = array();
foreach($functions as $func=>$name)
{
	$submenu[] = array($name.$LANG['label'], "?mod=$mod&file=$file&action=manage&function=$func");
}
$menu = adminmenu($LANG['form_label_manage'], $submenu);

require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();

require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
$tag = new tag($mod);

if(!$tag->writeable()) showmessage($LANG['template_dir_not_writeable'],'goback');

$filename = ($action == 'add' || $action == 'edit' || $action == 'changetemplate') ? MOD_ROOT.'/admin/'.$file.'_'.$action.'.inc.php' : PHPCMS_ROOT.'/admin/tag.inc.php';
include $filename;
?>