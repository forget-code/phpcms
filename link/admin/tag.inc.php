<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$action = $action ? $action : 'manage';
$actions = array('add','edit','copy','delete','manage','save','preview','checkname');
if(!in_array($action, $actions)) showmessage($LANG['illegal_operation'],'goback');
$function = isset($function) ? $function : 'link_list';
$functions = array('link_list'=>$LANG['link_list']);
if(!array_key_exists($function, $functions)) showmessage($LANG['not_exist']." $function ".$LANG['function_label'], "goback");
$tag_funcs = array(
'link_list'=>'$templateid,$typeid,$linktype,$linknum,$cols,$showhits'
);
$submenu = array();
foreach($functions as $func=>$name)
{
	$submenu[] = array($name.$LANG['label'], "?mod=".$mod."&file=".$file."&action=manage&function=".$func);
}
$menu = adminmenu($LANG['label_manage'], $submenu);
require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
require_once MOD_ROOT.'/include/tag.func.php';
$tag = new tag($mod);
if(!$tag->writeable()) showmessage($LANG['template_dir_not_writeable'],'goback');
$filename = ($action == 'add' || $action == 'edit' || $action == 'copy') ? MOD_ROOT.'/admin/'.$file.'_'.$action.'.inc.php' :
PHPCMS_ROOT.'/admin/tag.inc.php';
include $filename;
?>