<?php
defined('IN_PHPCMS') or exit('Access Denied');
$submenu=array(
	array($LANG['product_property_manage'],'?mod='.$mod.'&file=property&action=manage'),
	array('<font color="red">'.$LANG['add_product_attribute'].'</font>','?mod='.$mod.'&file='.$file.'&action=add')
	);
$menu=adminmenu($LANG['product_attribute_list'],$submenu);
$referer= isset($referer) ? $referer : $PHP_REFERER;
$action = isset($action) ? $action : 'manage';
$filearray = array('add','edit','delete','manage','listorder','list');
in_array($action,$filearray) or showmessage($LANG['illegal_action'],$referer);
require $file."_".$action.".inc.php";
?>