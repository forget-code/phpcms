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
$mod = "comment";
require "../common.php";
require_once PHPCMS_ROOT."/comment/include/tag.php";

if(!preg_match("/^[a-z]+$/i",$item)) message('非法参数！请返回！','goback');
if(!preg_match("/^[0-9]+$/",$itemid)) message('非法参数！请返回！','goback');
?>