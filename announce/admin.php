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
define('MOD_ROOT',PHPCMS_ROOT.'/'.$mod);

if(!@include_once(MOD_ROOT."/admin/".$file.".php")) showmessage("非法操作！");
?>