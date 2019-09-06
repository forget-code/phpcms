<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$keyid = isset($keyid) ? $keyid : 'phpcms';
$action = $action ? $action : 'manage';
$actions = array('add','edit','copy','delete','manage','save', 'preview', 'checkname');
if(!in_array($action, $actions)) showmessage($LANG['illegal_operation'],'goback');
$function = isset($function) ? $function : 'guestbook_list';
$functions = array('guestbook_list'=>$LANG['guestbook_list']);
if(!array_key_exists($function, $functions)) showmessage($LANG['not_exist']." $function ".$LANG['function_label'], "goback");
$forward = isset($forward) ? $forward : "?mod=$mod&file=$file";
$tag_funcs = array(
	'guestbook_list'=>'$templateid,$keyid,$guestbooknum,$subjectlen,$datetype,$showusername,$target,$cols',
);
$submenu = array();
foreach($functions as $func=>$name)
{
	$submenu[] = array($name.$LANG['label'], "?mod=$mod&file=$file&action=manage&function=$func&keyid=$keyid");
}
$menu = adminmenu($LANG['guestbook_label_manage'], $submenu);
require_once MOD_ROOT.'/include/tag.func.php';
require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
$tag = new tag($mod);
if(!$tag->writeable()) showmessage($LANG['template_dir_not_writeable'],'goback');
$filename = ($action == 'add' || $action == 'edit' || $action == 'copy') ? MOD_ROOT.'/admin/'.$file.'_'.$action.'.inc.php' : PHPCMS_ROOT.'/admin/tag.inc.php';
include $filename;
?>