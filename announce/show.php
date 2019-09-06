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

$today = date("Y-m-d");
$r = $db->get_one("SELECT * FROM  ".TABLE_ANNOUNCEMENT." where announceid='$announceid' and passed=1 and (todate='0000-00-00' or todate>'$today') ");
if(!$r[announceid]) message("该公告不存在！");

extract($r);

$addtime = date('Y-m-d H:i:s',$addtime);
if($todate=='0000-00-00') $todate = "不限";

$db->query("UPDATE ".TABLE_ANNOUNCEMENT." SET hits=hits+1 where announceid='$announceid' ");

if($channelid)
{
	$meta_title = $title."-".$_CHANNEL[$channelid]['channelname']."公告";
	$position = "<a href='".$_CHANNEL[$channelid]['channelurl']."'>".$_CHANNEL[$channelid]['channelname']."</a> >> <a href='index.php?channelid=".$channelid."'>公告</a>";
}
else
{
	$meta_title = $title."-"."公告";
	$position = "<a href='".PHPCMS_PATH."'>网站首页</a> >> <a href='index.php?channelid=".$channelid."'>公告</a>";
}

$templateid = $templateid ? $templateid : "announce";
$skindir = $skinid ? PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$skinid : $skindir;

include template('announce',$templateid);
?>