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

$referer = $referer ? $referer : ($forward ? $forward : $PHP_REFERER);

if($loginsubmit)
{
	$referer = $referer ? $referer : $PHP_SITEURL."member/";
	$password = isset($password) ? $password : getcookie('password');

	include_once PHPCMS_ROOT."/include/cmd.php";
	member_login($username,$password,$referer);
}
else
{
	$meta_title = "会员登录";
	$cookietime = getcookie('cookietime');
	if($cookietime) $cookietimeselect[$cookietime] = "selected"; 
	$referer = $referer ? $referer : $PHP_REFERER;

    include template("member","login");
}

function quescrypt($questionid, $answer) {
	 return $questionid > 0 && $answer != '' ? substr(md5($answer.md5($questionid)), 16, 8) : '';
}
?>