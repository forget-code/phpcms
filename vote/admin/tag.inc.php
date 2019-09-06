<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$action = $action ? $action : 'manage';
$keyid = isset($keyid) ? $keyid : 0;
$actions = array('add','edit','copy','delete','manage','save','preview','checkname');
if(!in_array($action, $actions)) showmessage($LANG['illegal_operation'],'goback');
$function = isset($function) ? $function : 'vote_list';
$functions = array('vote_list'=>$LANG['vote_list']);
if(!array_key_exists($function, $functions)) showmessage($LANG['not_exist']." $function ".$LANG['function_label'], "goback");
$tag_funcs = array(
'vote_list'=>'$templateid,$keyid,$page,$votenum,$subjectlen,$cols'
);
$submenu=array(
	array('<font color="#0000FF">'.$LANG['add_vote'].'</font>','?mod='.$mod.'&file=vote&action=add&keyid='.$keyid),
	array('<font color="#FF0000">'.$LANG['vote_manage'].'</font>','?mod='.$mod.'&file=vote&action=manage&passed=1&keyid='.$keyid),
	array($LANG['vote_checked'],'?mod='.$mod.'&file=vote&action=manage&passed=0&keyid='.$keyid),
	array($LANG['vote_expired'],'?mod='.$mod.'&file=vote&action=manage&keyid='.$keyid.'&timeout=1'),
	array('<font color="#0000FF">'.$LANG['label_manage'].'</font>','?mod='.$mod.'&file=tag&keyid='.$keyid),
	array('<font color="#FF0000">'.$LANG['update_vote'].'</font>','?mod='.$mod.'&file=vote&action=getcode&updatejs=1&keyid='.$keyid)
);
$menu = adminmenu($LANG['label_manage'], $submenu);
require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
require_once MOD_ROOT.'/include/tag.func.php';
$tag = new tag($mod);
if(!$tag->writeable()) showmessage($LANG['template_dir_not_writeable'],'goback');
$filename = ($action == 'add' || $action == 'edit' || $action == 'copy') ? MOD_ROOT.'/admin/'.$file.'_'.$action.'.inc.php' :
PHPCMS_ROOT.'/admin/tag.inc.php';
include $filename;
?>