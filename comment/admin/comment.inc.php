<?php
defined('IN_PHPCMS') or exit('Access Denied');
$submenu = array(
	array($LANG['all_comment'],'?mod=phpcms&file=setting&tab=5'),
	);
$menu = adminmenu($LANG['comment_content_manage'],$submenu);

$forward = $forward ? $forward : $PHP_REFERER;
$action = $action ? $action : 'manage';
$filearray = array('add','check','delete','manage','pass');
in_array($action,$filearray) or showmessage($LANG['illegal_action'],$referer);
require $file."_".$action.".inc.php";
?>