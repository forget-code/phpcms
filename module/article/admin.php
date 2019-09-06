<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/
defined('IN_PHPCMS') or exit('Access Denied');

if($_grade>1 && $file!=$mod && $file!='index') showmessage("您没有管理权限！");

define('MOD_ROOT',PHPCMS_ROOT.'/module/'.$mod);

require_once PHPCMS_ROOT."/comment/include/tag.php";
require_once MOD_ROOT."/include/tag.php";
require MOD_ROOT."/extension.php";

if(!@include_once(MOD_ROOT."/admin/".$file.".php")) showmessage("非法操作！");
?>