<?php
/**
* 会员登录
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage member
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
require_once("common.php");

if($_userid) message("您已经登录了！","goback");

$meta_title = "找回密码";

$step = intval($step);
$step = $step ? $step : 1;

if($step == 1)
{
    include template("member","getpassword");
}
elseif($step == 2)
{
	if(!is_username($username,2,30)) message("用户名不符合规范！","goback");
	if(!is_email($email)) message("Email不符合规范！","goback");

    $r = $db->get_one("SELECT userid,question FROM ".TABLE_MEMBER." WHERE username='$username' AND email='$email' LIMIT 0,1");
	if(!$r['userid']) message("用户名和Email不匹配！","goback");
	@extract($r);

    include template("member","getpassword");
}
elseif($step == 3)
{
	if(!is_username($username,2,30)) message("用户名不符合规范！","goback");
	if(!is_email($email)) message("Email不符合规范！","goback");
	if(empty($answer)) message("密码提示问题答案不得为空！","goback");

	$answer = md5($answer);

    $r = $db->get_one("SELECT userid FROM ".TABLE_MEMBER." WHERE username='$username' AND email='$email' AND answer='$answer' LIMIT 0,1");
	if(!$r['userid']) message("密码提示问题答案不对！","goback");

    $authstr = random(32,"0123456789");

	$db->query("UPDATE ".TABLE_MEMBER." SET authstr='$authstr' WHERE userid=$r[userid] ");

	sendmail($email,"找回密码[".$_PHPCMS['sitename'],"<a href='http://".$PHP_DOMAIN.PHPCMS_PATH."member/getpassword.php?step=4&userid=".$r['userid']."&authstr=".$authstr."' target='_blank'>http://".$PHP_DOMAIN."/member/getpassword.php?action=editpassword&userid=".$r['userid']."&authstr=".$authstr."</a>");

    include template("member","getpassword");
}
elseif($step == 4)
{
	if(!preg_match("/^[0-9]{32}$/",$authstr))  message("验证字符串不正确！","goback");
	$userid = intval($userid);

    $r = $db->get_one("SELECT userid FROM ".TABLE_MEMBER." WHERE userid='$userid' AND authstr='$authstr' LIMIT 0,1");
	if(!$r['userid']) message("验证字符串不正确！","goback");

    include template("member","getpassword");
}
elseif($step == 5)
{
	if(!preg_match("/^[0-9]{32}$/",$authstr))  message("验证字符串不正确！","goback");
	$userid = intval($userid);
	if(strlen($password)<4 || strlen($password)>20) message("密码不得少于4个字符超过20个字符！","goback");
    $password = md5($password);
    
	$r = $db->query("UPDATE ".TABLE_MEMBER." SET password='$password',authstr='' WHERE userid=$userid AND authstr='$authstr' ");
	$db->affected_rows()==1 ? message("新密码设置成功！","login.php") : message("新密码设置失败！","login.php");
}
?>