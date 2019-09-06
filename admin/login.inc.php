<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($_userid && $_groupid == 1 && $_SESSION['is_admin'] == 1) showmessage($LANG['you_are_logined'], '?mod=phpcms&file=index&action=index');

if($PHPCMS['adminaccessip'] && ip_access(IP, $PHPCMS['adminaccessip'])) showmessage($LANG['visit_banned']);

$code = new times();
$code->set('checkcode', 3600, 1);

if($PHPCMS['maxloginfailedtimes'])
{
	$times = new times();
	$times->set('login', $PHPCMS['maxiplockedtime']*3600, $PHPCMS['maxloginfailedtimes']);
	if($times->check()) showmessage('登录失败超过'.$PHPCMS['maxloginfailedtimes'].'次！<br />您的IP已经被系统锁定，'.$PHPCMS['maxiplockedtime'].'小时后将自动解除锁定。', SITE_URL);
}

if($dosubmit)
{
	require PHPCMS_ROOT.'languages/'.LANG.'/member.lang.php';
	require PHPCMS_ROOT.'member/include/member.class.php';
	$member = new member();
	if(!isset($forward)) $forward = URL;
	if(!isset($checkcodestr)) $checkcodestr = '';
	if($code->check()) checkcode($checkcodestr, 1, HTTP_REFERER);
	$result = $member->login($username, $password);
	if(!$result)
	{
		if($PHPCMS['maxloginfailedtimes']) $times->add();
		$code->add();
		showmessage($member->msg(), HTTP_REFERER);
	}
    if($PHPCMS['maxloginfailedtimes']) $times->clear();
	$code->clear();
	if($result['groupid'] > 1)
	{
        $member->logout();
		showmessage('您不是管理员，不能登录网站后台！', SITE_URL);
	}
	$userid = $result['userid'];
	require_once 'admin/admin.class.php';
	$a = new admin();
	$admin = $a->get($userid);
	if($admin['disabled'] == 1)
	{
        $member->logout();
        showmessage('您的账号没有权限访问网站后台，请联系管理员！');
	}
	if($admin['allowmultilogin'] == 0 && $a->is_multilogin($userid))
	{
        $member->logout();
        showmessage('您的帐号已经在别的IP下登录了，请联系管理员！');
	}

	$a->update_admin_role($userid);
	if($admin['editpasswordnextlogin'])
	{
		$a->update($userid, 'editpasswordnextlogin', 0);
		showmessage('第一次登录后台必须修改密码！', $MODULE['member']['url'].'editpwd.php?forward='.urlencode(URL));
	}
	$_SESSION['is_admin'] = 1;
	showmessage($LANG['login_success'], $forward,10,1);
}
else
{
    if(!$forward) $forward = SCRIPT_NAME;
	if(!isset($username)) $username = $_username;
	if(!isset($password)) $password = '';

	include admin_tpl('login');
}
?>