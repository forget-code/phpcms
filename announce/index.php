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
require_once "common.php";

$page = intval($page);
$page = $page ? $page : 1;

$channelid = intval($channelid);

if($channelid)
{
	$meta_title = $channelname."公告";
	$position = "<a href='".$channelurl."'>".$channelname."</a> >> <a href='?channelid=".$channelid."'>公告</a>";
}
else
{
	$meta_title = "公告";
	$position = "<a href='".PHPCMS_PATH."'>网站首页</a> >> <a href='?channelid=".$channelid."'>公告</a>";
}

include template('announce','index');
?>
