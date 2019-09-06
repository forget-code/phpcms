<?php
defined('IN_PHPCMS') or exit('Access Denied');
$keyid = isset($keyid) && $keyid ? $keyid : 'phpcms';
$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
$action = $action ? $action : 'manage';
$submenu=array(
	array($LANG['manage_page'],'?mod='.$mod.'&file='.$file.'&action=manage&keyid='.$keyid),
	array($LANG['add_page'],'?mod='.$mod.'&file='.$file.'&action=add&keyid='.$keyid),
	array($LANG['label_invoke_manage'],'?mod=page&file=tag'),
	array($LANG['create_all'],'?mod=page&file=page&action=createhtml'),
);
$menu=adminmenu($LANG['single_page_manage'],$submenu);
include MOD_ROOT.'/admin/'.$mod.'_'.$action.'.inc.php';
?>