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
@extract($db->get_one("select * from ".TABLE_PAGE." where pageid=$pageid and passed=1 and channelid=$channelid"));
if(!$passed || $linkurl) return;

$templateid = $templateid ? $templateid : "page";
$skindir = $skinid ? PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$skinid : $skindir;

ob_start();
include template("page",$templateid);
$data = ob_get_contents();
ob_clean();

$filepath = PHPCMS_ROOT."/".$filepath;
$f->create(dirname($filepath));
file_write($filepath,$data);
return true;
?>