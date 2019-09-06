<?php
defined('IN_PHPCMS') or exit('Access Denied');

$action = $action ? $action : 'config';

//目录参数设置
$mail_setdir = "data/mail/";
$mail_datadir = "data/mail/data/";

dir_create(PHPCMS_ROOT."/".$mail_setdir);
dir_create(PHPCMS_ROOT."/".$mail_datadir);

//临时邮件参数设置
$tmpname = PHPCMS_ROOT."/data/mail/mailing.php";
$separator='|||';
$url="?mod=".$mod."&file=mail&action=send2";

//头部菜单
$submenu=array(
	array('<font color="red">'.$LANG['obtain_maillist'].'</font>',"?mod=".$mod."&file=maillist&action=get"),
	array($LANG['maillist_manage'],"?mod=".$mod."&file=maillist&action=manage"),
	array($LANG['manual_send_mail'],"?mod=".$mod."&file=send")
);
$menu=adminmenu($LANG['maillist'],$submenu);


$referer= isset($referer) ? $referer : $PHP_REFERER;
$action = $action ? $action : 'manage';
$filearray = array('get','config','manage','delete','getlist','down','upload');
in_array($action,$filearray) or showmessage($LANG['illegal_action'],$referer);
require $file."_".$action.".inc.php";
?>