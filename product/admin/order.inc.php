<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();
$module = $mod;
$submenu=array(
	array($LANG['order_list'],'?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['order_search'],'?mod='.$mod.'&file='.$file.'&action=manage#advancedsearch')
	);
$menu=adminmenu($LANG['order_manage'],$submenu);
$referer = isset($referer) ? $referer : $PHP_REFERER;
$action = $action ? $action : 'manage';
$filearray = array('add','edit','delete','manage','view','changestatus','print');
in_array($action,$filearray) or showmessage($LANG['illegal_action'],$referer);
$BRANDS = cache_read('product_brands.php');
require $file."_".$action.".inc.php";
?>