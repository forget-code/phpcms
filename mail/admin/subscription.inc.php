<?php
defined('IN_PHPCMS') or exit('Access Denied');
$submenu=array(
	array($LANG['system_sendmail_setting'],'?mod=phpcms&file=setting&tab=5'),
	array($LANG['mail_content_manage'],'?mod='.$mod.'&file=subscription&action=manage'),
	array('<font color="red">'.$LANG['batch_send_mail'].'</font>','?mod='.$mod.'&file='.$file.'&action=send')
	
	);
$menu=adminmenu($LANG['batch_send_mail'],$submenu);

$referer= isset($referer) ? $referer : $PHP_REFERER;
$action = $action ? $action : 'manage';
$filearray = array('add','edit','delete','manage','send');
in_array($action,$filearray) or showmessage($LANG['illegal_action'],$referer);
$TYPE = cache_read('type_'.$mod.'.php');
require $file."_".$action.".inc.php";
?>