<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once(PHPCMS_ROOT."/$mod/include/cache.func.php");
$submenu=array(
	array($LANG['brand_list'],'?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['add_product_brand'],"javascript:\$(\"brand_name\").value=\"add your brand here...\";\$(\"brand_name\").style.color=\"#999999\"; \$(\"brand_name\").focus();")
	);
$menu = adminmenu($LANG['brand_manage'],$submenu);
$referer = isset($referer) ? $referer : $PHP_REFERER;
$action = isset($action) ? $action : 'manage';
$filearray = array('add','edit','delete','manage','listorder');
in_array($action,$filearray) or showmessage($LANG['illegal_action'],$referer);
require $file."_".$action.".inc.php";
?>