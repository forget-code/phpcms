<?php
require './include/common.inc.php';
if(!isset($forward) || !$forward) $forward = HTTP_REFERER;
if(!$_userid) showmessage($LANG['please_login'], $M['url'].'login.php?forward='.urlencode(URL));
if($_groupid == 1 && !$member->is_alloweditpassword($_userid))
{
	showmessage('系统管理员已禁止您修改密码');
}
if($dosubmit)
{
	$result = $member->set_password($old_password, $new_password);
	if(!$result) showmessage($member->msg());
    if($PHPCMS['uc'])
	{
		$username = $_username;
		$email = $_email;
		$action = 'editpwd';
		require MOD_ROOT.'api/passport_server_ucenter.php';
	}
	$member->login($username, $new_password);
	showmessage($LANG['operation_success'], $forward);
}
else
{
	$head['title'] = $LANG['member_profile_edit'];
	$head['keywords'] = $LANG['member_profile_edit'];
	$head['description'] = $LANG['member_profile_edit'];
	$memberinfo = $member->get($_userid, $fields = '*', 1);
	$memberinfo['avatar'] = avatar($_userid);
	extract($memberinfo); 
    include template('member', 'editpwd');
}
?>