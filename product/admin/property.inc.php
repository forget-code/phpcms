<?php
defined('IN_PHPCMS') or exit('Access Denied');
$submenu=array(
	array($LANG['product_property_manage'],'?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['add_product_property'],"javascript:\$(\"pro_name\").value=\"add your type name here...\";\$(\"pro_name\").style.color=\"#999999\"; \$(\"pro_name\").focus();"),
	array('<font color="red">'.$LANG['add_product_attribute'].'</font>','?mod='.$mod.'&file=attribute&action=add')
	);
$menu=adminmenu($LANG['product_property_attribute_manage'],$submenu);
$referer= isset($referer) ? $referer : $PHP_REFERER;
$action = isset($action) ? $action : 'manage';
$filearray = array('add','edit','delete','manage');
in_array($action,$filearray) or showmessage($LANG['illegal_action'],$referer);
require $file."_".$action.".inc.php";
?>