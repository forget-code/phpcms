<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!class_exists('member'))
{
	require PHPCMS_ROOT.'member/include/member.class.php';
}
if(!class_exists(sendmail))
{
	$mail = load('sendmail.class.php');
}
$member = new member();
require 'admin/admin.class.php';
$admin = new admin();

if(!$forward) $forward = HTTP_REFERER;

if ($dosubmit)
{
	if(!$pagesize) $pagesize = $sendnumber ? $sendnumber: $PHPCMS['pagesize'];
	$page = max(intval($page), 1);
	$offset = $pagesize*($page-1);
	if($type == 'group')
	{
		if(!$groupid) showmessage('请选择用户组');
		if($groupid == 'all' && !$total)
		{
			$total = $member->count_member();
		}
		elseif(!$total && $groupid != 'all')
		{
			$total = $member->count_member(" groupid='$groupid'");
		}
		$pages = ceil($total/$pagesize);
		$arr_user = ($groupid == 'all') ? $member->get_all($order, $page, $pagesize) : $member->get_by_groupid($groupid, $order, $page, $pagesize);
		if(!$arr_user) showmessage('该用户组没有会员');
		foreach ($arr_user as $touser)
		{
			$touserid = $touser['userid'];
			if(!$message_admin->send_new($touserid, $_userid, $subject, $content))
			{
				showmessage($message_admin->msg(), $forward);
			}
			if($send) $mail->send($touser['email'], $subject, $content, $_email);
			$memberinfo = array('userid'=>$touserid, 'message'=>1);
			$member->edit($memberinfo);
		}	
		if($pages > $page)
		{
			$page++;
			$forward = "?mod=$mod&file=$file&action=$action&name=$name&groupid=$groupid&dosubmit=1&subject=$subject&content=$content&&page=$page&total=$total&pagesize=$pagesize&type=group";
			showmessage('开始发送短消息', $forward);
		}
		else
		{
			$forward = "?mod=$mod&file=$file&action=manage";
			showmessage($LANG['message_send_successful'], $forward);
		}
	}
	elseif($type == 'role')
	{
		$total = $admin->count_admin(" roleid='$roleid'");
		$pages = ceil($total/$pagesize);
		$arr_user = $admin->listadmin(" roleid='$roleid'", $order = 'userid', $page, $pagesize);
		if(!$arr_user) showmessage('该管理角色没有会员');
		foreach ($arr_user as $touser)
		{
			$touserid = $touser['userid'];
			if(!$message_admin->send_new($touserid, $_userid, $subject, $content))
			{
				showmessage($message_admin->msg(), $forward);
			}
			$memberinfo = array('userid'=>$touserid, 'message'=>1);
			$member->edit($memberinfo);
			if($send) $mail->send($touser['email'], $subject, $content, $_email);
		}
		
		if($pages > $page)
		{
			$page++;
			$forward = "?mod=$mod&file=$file&action=$action&name=$name&roleid=$roleid&dosubmit=1&subject=$subject&content=$content&&page=$page&total=$total&type=role";
			showmessage('开始发送短消息', $forward);
		}
		else
		{
			$forward = "?mod=$mod&file=$file&action=manage";
			showmessage($LANG['message_send_successful'], $forward);
		}
	}
}
else
{
	$GROUP[0] = '请选择';
	$GROUP['all'] = '所有用户';		
	ksort($GROUP);
	$role_group = cache_read('role.php');
	if(!isset($type)) $type = 'group';
	include admin_tpl('sendmessage');
}
?>