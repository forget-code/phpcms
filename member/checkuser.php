<?php
/**
* 会员注册
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage member
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
require_once("common.php");

if(!is_username($username,2,30)) message("用户名不符合规范！请返回！");

if(user_exists($username))
{
	message('该用户名已经存在！');
}
else
{
	message('该用户名不存在！');
}
?>