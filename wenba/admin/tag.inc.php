<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$action = $action ? $action : 'manage';
$actions = array('add','edit','copy','delete','manage','save', 'preview', 'checkname');
if(!in_array($action, $actions)) showmessage($LANG['illegal_operation'],'goback');
$function = isset($function) ? $function : 'question_list';
$functions = array('question_list'=>$LANG['question'],'credit_list'=>$LANG['integral']);
if(!array_key_exists($function, $functions)) showmessage($LANG['not_exist']." $function ".$LANG['function_label'], "goback");
$forward = isset($forward) ? $forward : "?mod=$mod&file=$file";

$tag_funcs = array(
'question_list'=>'$templateid,$catid,$child,$page,$ques_num,$subjectlen,$elite,$ques_type,$showcatname,$datetype,$datenum,$ordertype,$username,$target,$cols',
'credit_list'=>'$templateid,$credit_num,$page,$datetype,$target,$cols,$credit_status',
);
$submenu = array();
foreach($functions as $func=>$name)
{
	$submenu[] = array($name.$LANG['label'], "?mod=$mod&file=$file&action=manage&function=$func");
}
$menu = adminmenu($LANG['question_label_manage'], $submenu);
$CATEGORY = cache_read('categorys_'.$mod.'.php');

require_once MOD_ROOT.'/include/tag.func.php';
require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
require_once PHPCMS_ROOT.'/include/formselect.func.php';
require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();
$tag = new tag($mod);
if(!$tag->writeable()) showmessage($LANG['template_dir_not_writeable'],'goback');
$filename = ($action == 'add' || $action == 'edit' || $action == 'copy') ? MOD_ROOT.'/admin/'.$file.'_'.$action.'.inc.php' : PHPCMS_ROOT.'/admin/tag.inc.php';
include $filename;
?>