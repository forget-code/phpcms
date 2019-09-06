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
if($_CHA[htmlcreatetype]==0 || $_CHA[htmlcreatetype]==2) return FALSE;

$position = "<a href='".PHPCMS_PATH."'>首页</a> >> <a href='".$channelurl."'>".$channelname."</a> >> <a href='".$channelurl."special/'>专题</a>";

$speciallisturl = $p->get_speciallisturl(1);

$meta_title = $_CHA['channelname']."频道-专题";
$meta_keywords = $_CHA['meta_keywords'];
$meta_description = $_CHA['meta_keywords'];

ob_start();
include template($_CHA['module'],"special");
$data = ob_get_contents();
ob_clean();
$p->set_type('path');
$filename = $p->get_specialindexurl();
file_write($filename,$data);
return TRUE;
?>