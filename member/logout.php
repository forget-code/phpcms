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
include_once PHPCMS_ROOT."/include/cmd.php";

$referer = $referer ? $referer : ($forward ? $forward : PHPCMS_PATH);

member_logout($referer);
?>