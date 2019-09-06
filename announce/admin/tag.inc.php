<?php
defined('IN_PHPCMS') or exit('Access Denied');
include(PHPCMS_ROOT."/{$mod}/admin/menu.inc.php");
$action = $action ? $action : 'manage';
$actions = array('add','edit','copy','delete','manage','save','preview','checkname');
if(!in_array($action, $actions)) showmessage($LANG['illegal_operation'],'goback');
$function = isset($function) ? $function : "{$mod}_list";
$functions = array("{$mod}_list" => $LANG['announce_list']);
if(!array_key_exists($function, $functions)) showmessage($LANG['no_exists'] . $function . $LANG['function_tag'], "goback");
$tag_funcs = array("{$mod}_list" => '$templateid,$keyid,$page,$announcenum,$width, $height,$subjectlen,$datetype,$showauthor,$target');
$submenu = $menu[$mod];
$menu = adminmenu($modtitle[$mod], $submenu);
require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
require_once MOD_ROOT.'/include/tag.func.php';
$tag = new tag($mod);
$filename = ($action == 'add' || $action == 'edit' || $action == 'copy') ? MOD_ROOT.'/admin/'.$file.'_'.$action.'.inc.php' :PHPCMS_ROOT.'/admin/tag.inc.php';
include $filename;
?>