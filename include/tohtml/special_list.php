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
if($_CHA[htmlcreatetype]!=1) return FALSE;

$position = "<a href='".PHPCMS_PATH."'>首页</a> >> <a href='".$channelurl."'>".$channelname."</a> >> <a href='".$channelurl."special/'>专题</a>";

$meta_title = $_CHA['channelname']."频道-专题";
$meta_keywords = $_CHA['meta_keywords'];
$meta_description = $_CHA['meta_keywords'];

$r = $db->get_one("select count(*) as number from ".TABLE_SPECIAL." where channelid='$channelid'");
$number = $r['number'];
$pagesize = $_PHPCMS['pagesize'];
$pagenumber = ceil($number/$pagesize)+1;
for($listpage=0; $listpage<=$pagenumber; $listpage++) 
{
	if($listpage==0) continue;
    $page = $listpage==0 ? 1 : $listpage;
	$p->set_type("url");
	ob_start();
	include template($_CHA['module'],"special_list");
	copyright();
	$data = ob_get_contents();
	ob_clean();
	$p->set_type("path");
	$filename = $p->get_speciallisturl($listpage);
	file_write($filename,$data);
}

return TRUE;
?>