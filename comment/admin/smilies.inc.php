<?php
defined('IN_PHPCMS') or exit('Access Denied');
$submenu = array(
	array($LANG['system_mail_option'],'?mod=phpcms&file=setting&tab=5')
	
	);
$menu = adminmenu($LANG['comment_smile_manage'],$submenu);

$referer= isset($referer) ? $referer : $PHP_REFERER;
$action = $action ? $action : 'manage';
$filearray = array('add','verify','delete','manage');
in_array($action,$filearray) or showmessage($LANG['illegal_action'],$referer);
require $file."_".$action.".inc.php";
?>