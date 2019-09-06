<?php
defined('IN_PHPCMS') or exit('Access Denied');

$submenu = array(
	array('<font color="red">'.$LANG['new_form'].'</font>','?mod='.$mod.'&file=form&action=add'),
	array($LANG['form_manage'],'?mod='.$mod.'&file=form&action=manage')
	);
$menu = adminmenu($LANG['form_post_content_manage'],$submenu);

$referer= isset($referer) ? $referer : $PHP_REFERER;
$action = $action ? $action : 'manage';
$filearray = array('add','edit','delete','manage','show');
in_array($action,$filearray) or showmessage($LANG['illegal_action'],$referer);

require $file."_".$action.".inc.php";
?>