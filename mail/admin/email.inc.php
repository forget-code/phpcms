<?php
defined('IN_PHPCMS') or exit('Access Denied');
$submenu = array(
	array('系统邮件配置','?mod=phpcms&file=setting&tab=5'),
	array('邮件内容管理','?mod='.$mod.'&file=subscription&action=list'),
	array('清空30天未激活E-mail',"?mod=".$mod."&file=email&action=clear"),
	array('<font color="red">批量发送订阅邮件</font>','?mod='.$mod.'&file=subscription&action=send')
	);
$menu = admin_menu($LANG['subscription_email_list'],$submenu);
require_once MOD_ROOT.'admin/include/mail.class.php';
$mails = new mail();
$referer= isset($referer) ? $referer : HTTP_REFERER;
$action = $action ? $action : 'list';
$filearray = array('verify','delete','list','clear');
in_array($action,$filearray) or showmessage($LANG['illegal_action'],$referer);
switch($action){
	case 'list':
		if (!empty($searchemail) && is_email($searchemail)) $condition[] = " `email` LIKE '%$searchemail%' ";
		if($starttime)	{$starttime = strtotime($starttime); $condition[] = " `addtime` <= '$starttime'";}
		if($endtime)	{$endtime = strtotime($endtime); $condition[] = " `addtime` <= '$endtime'";}
		if($typeid) $condition[] = " `typeid` = '$typeid'";
        $page       = isset($page) ? intval($page) : 1;
		$pagesize   = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 10;
		$emails     = $mails->get_list($condition, $page, $pagesize, $typeid);
        $pages      = $emails['pages'];
		include admin_tpl('email_manage');
	break;
	case 'delete':
		if( $mails->drop($email) ) showmessage('删除成功！', "?mod=$mod&file=$file&action=list");
	break;
	case 'clear':
		if($mails->clear()) showmessage('清除成功！',"?mod=$mod&file=$file&action=list");
	break;
	case 'verify':
		if(!isset($email)) showmessage($LANG['illegal_parameters'],'goback');
		if($mails->verify($email))	showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=list");
	break;
}
?>