<?php
/**
* 会员模块函数库
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage member
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
defined('IN_PHPCMS') or exit(FORBIDDEN);

function user_exists($username)
{
	global $db;
	$r = $db->get_one("SELECT * FROM ".TABLE_MEMBER." WHERE username='$username' limit 0,1");
	return $r['userid']>0 ? $r : false;
}

function member_login($username,$password,$referer='')
{
	global $db,$phpcms_user,$timestamp,$_PHPCMS,$PHP_IP,$PHP_REFERER;

	if(!is_username($username,2,30)) message("用户名不符合规范！","goback");
	if(strlen($password)<4 || strlen($password)>20) message("密码不得少于4个字符超过20个字符！","goback");
    
	$referer = $referer ? $referer : $PHP_REFERER;
	$password = md5($password);

    $r = $db->get_one("SELECT * FROM ".TABLE_MEMBER." m,".TABLE_MEMBERINFO." i WHERE m.userid=i.userid AND m.username='$username' AND m.password='$password' LIMIT 0,1");
	if(!$r['userid']) message("帐号和密码不匹配！","goback");
	if($r['groupid'] < 4) message("您的帐号还未批准，请等待！","goback");
	if($r['locked'] != 0) message("您的帐号已被管理员锁定！","goback");

	$_cookietime = isset($_POST['cookietime']) ? $_POST['cookietime'] : (getcookie('cookietime') ? getcookie('cookietime') : 0);
	$cookietime = empty($_cookietime) ? 0 : $timestamp + $_cookietime;
    $phpcms_auth_key = md5($_PHPCMS['authkey'].$_SERVER['HTTP_USER_AGENT']);
	$phpcms_auth = phpcms_auth($r['userid']."\t".$r['password']."\t".$r['answer'], 'encode', $phpcms_auth_key);
	mkcookie('phpcms_auth', $phpcms_auth, $cookietime);
	mkcookie('cookietime', $_cookietime, $cookietime);
	mkcookie('phpcms_user',$phpcms_user, $cookietime);
	mkcookie('password','', $timestamp-3600);

    $db->query("update ".TABLE_MEMBER." set lastloginip='$PHP_IP',lastlogintime=$timestamp,logintimes=logintimes+1 where username='$username'");
	if($_PHPCMS['enablepassport'])
	{
		@extract($r);
		if($isadmin)
		{
			$a = $db->get_one("SELECT userid,grade FROM ".TABLE_ADMIN." WHERE userid=$userid limit 0,1");
			if(!$a['userid'] || $a['grade']>0) $isadmin = 0;
		}
		$txt = "cookietime=".$_cookietime."&username=".$username."&password=".$password."&secques=".quescrypt(1,'phpcms')."&gender=".$gender."&email=".$email."&isadmin=".$isadmin."&regip=".$regip."&regdate=".$regtime."&oicq=".$qq."&msn=".$msn."&showemail=".$showemail."&bday=".$birthday."&site=".$homepage."&location=".substr($address, 0, 30);
		cmd_send($_PHPCMS['passport_url'],"login",$referer,$txt,$_PHPCMS['passport_key']);
	}
	else
	{
		header("location:".$referer);
	}
}

function member_logout($referer='')
{
	global $_PHPCMS,$PHP_SITEURL;

	$referer = $referer ? $referer : $PHP_SITEURL;

	mkcookie('phpcms_auth','');
	mkcookie('phpcms_admin','');
	mkcookie('phpcms_user','');

	if($_PHPCMS['enablepassport'])
	{
	   cmd_send($_PHPCMS['passport_url'],"logout",$referer,$txt,$_PHPCMS['passport_key']);
	}
	else
	{
		message("您已经成功退出！",$referer);
	}
}
?>