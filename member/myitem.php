<?php
/**
* 会员信息管理
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage member
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
require_once "common.php";

if(!$_userid) message("请登录！","login.php?referer=index.php");

require_once PHPCMS_ROOT."/class/tree.php";
require_once PHPCMS_ROOT."/include/form_select.php";

$meta_title = "我发布的信息管理";
$skindir = PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$defaultskin;

if(!@include(PHPCMS_ROOT."/module/".$module."/myitem.php")) message("非法参数！");
?>