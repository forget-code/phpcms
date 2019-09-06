<?php
defined('IN_PHPCMS') or exit('Access Denied');
$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
$action = $action ? $action : 'manage';
$submenu=array(
	array($LANG['user_defined_page_manage'],'?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['add_user_defined_page'],'?mod='.$mod.'&file='.$file.'&action=add'),
	array($LANG['template_manage'], "?mod=phpcms&file=template&action=manage&module=mypage&projectid=default"),
	array($LANG['add_template'],"?mod=phpcms&file=template&action=add&module=mypage&project=default&templatename=%C4%AC%C8%CF&templatetype=mypage")
);
$menu=adminmenu($LANG['page_manage'],$submenu);
include MOD_ROOT.'/admin/'.$mod.'_'.$action.'.inc.php';
?>