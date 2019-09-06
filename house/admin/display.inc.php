<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();
$module = $mod;
$submenu = array(
	array("已审核楼盘信息",'?mod='.$mod.'&file='.$file.'&action=manage'),
	array("待审核楼盘信息",'?mod='.$mod.'&file='.$file.'&action=manage&status=0'),	
	);
$extramenu = array(
	array("添加新楼市",PHPCMS_PATH.'house/displaymgr.php?action=add'),	
	);
$menu=adminmenu("新楼市管理",$submenu,$extramenu);
$referer = isset($referer) ? $referer : $PHP_REFERER;
$action = $action ? $action : 'manage';
$filearray = array('add','edit','delete','manage','view','changestatus','print');
in_array($action,$filearray) or showmessage($LANG['illegal_action'],$referer);
require $file."_".$action.".inc.php";
?>