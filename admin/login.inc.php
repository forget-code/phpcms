<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($_grade > -1 && $_groupid == 1) showmessage($LANG['you_are_logined'], "?mod=phpcms&file=index&action=index");

if($PHPCMS['adminaccessip'] && !ip_access($PHP_IP, $PHPCMS['adminaccessip'])) showmessage($LANG['visit_banned']);

if($dosubmit)
{
	require PHPCMS_ROOT.'/languages/'.$CONFIG['language'].'/member.lang.php';
	require PHPCMS_ROOT.'/member/include/member.class.php';
	$member = new member($username);

	if(!isset($forward)) $forward = $PHP_SCHEME.$PHP_DOMAIN.$PHP_PORT.$PHP_SELF;
	if(!isset($checkcodestr)) $checkcodestr = '';

	checkcode($checkcodestr, $PHPCMS['enableadmincheckcode'], $PHP_REFERER);

	if(empty($username) || $member->is_badword($username)) showmessage($LANG['username_non_compliant'], $PHP_REFERER);
	if(strlen($password)<2 || strlen($password)>20) showmessage($LANG['password_not_less_than_2char_greater_than_20char'], $PHP_REFERER);

	if(!$_userid || $_username != $username)
	{
		$result = $member->login($password);
		if(!$result) showmessage($member->errormsg(), $PHP_REFERER);
	}

    $memberinfo = $db->get_one("SELECT m.userid,m.password,m.answer,m.groupid,a.* FROM ".TABLE_MEMBER." m ,".TABLE_ADMIN." a WHERE m.userid=a.userid AND m.username='$username' LIMIT 0,1");
	if(!$memberinfo)
	{
		if($PHPCMS['maxfailedtimes']) 
        {
			$failedtimes = $_SESSION['failedtimes'];
			$failedtimes ++;
			$overtime = $PHP_TIME+$PHPCMS['maxlockedtime']*3600;
			if($PHPCMS['maxfailedtimes']<=$failedtimes)
			{
				$db->query("INSERT INTO ".TABLE_BANIP."(ip,ifban,overtime) VALUES('$PHP_IP',1,$overtime)");
				cache_banip();
				showmessage($LANG['fail_num_over_ip_locked']);
			}
			$_SESSION['failedtimes'] = $failedtimes;
		}
		showmessage($LANG['not_existe_user'], $PHP_REFERER);
	}
	if($memberinfo['password'] != md5($password)) showmessage($LANG['wrong_password'], $PHP_REFERER);
	if($memberinfo['groupid'] != 1) showmessage($LANG['you_are_not_admin'], $PHP_REFERER);

	$_SESSION['admin_grade'] = $memberinfo['grade'];
	if($memberinfo['grade'] > 0)
	{
		$_SESSION['admin_modules'] = $memberinfo['modules'] ? array_filter(explode(',', $memberinfo['modules'])) : array();
		$_SESSION['admin_channelids'] = $memberinfo['channelids'] ? array_filter(explode(',', $memberinfo['channelids'])) : array();
		$_SESSION['admin_purviewids'] = $memberinfo['purviewids'] ? array_filter(explode(',', $memberinfo['purviewids'])) : array();
		$_SESSION['admin_catids'] = $memberinfo['catids'] ? array_filter(explode(',', $memberinfo['catids'])) : array();
		$_SESSION['admin_specialids'] = $memberinfo['specialids'] ? array_filter(explode(',', $memberinfo['specialids'])) : array();
	}
	showmessage($LANG['login_success'], $forward);
}
else
{
    if(!$forward) $forward = '?mod=phpcms&file=index&action=index';
	$username = isset($username) ? $username : $_username;
	$password = isset($password) ? $password : '';

    include admintpl('login');
}
?>