<?php
/*
*######################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2004-2005 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*######################################
*/
defined('IN_PHPCMS') or exit(FORBIDDEN);

foreach($_MODULE as $module => $m)
{
    if($m['enablecopy']) @include_once PHPCMS_ROOT."/module/".$module."/include/tag.php";
}

$skindir = PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$defaultskin;
$channelid = 0;

$cha_articles = $cha_downs = $cha_pictures = $cha_infos = array();
foreach($_CHANNEL as $k=>$v)
{
	if(!$v['channeltype']) continue;
	if($v['module']=='article')
	   $cha_articles[] = $v;
	elseif($v['module']=='down')
	   $cha_downs[] = $v;
	elseif($v['module']=='picture')
	   $cha_pictures[] = $v;
	else
	   $cha_infos[] = $v;
}

$meta_title = $_PHPCMS['sitename'];
$meta_keywords = $_PHPCMS['meta_keywords'];
$meta_description = $_PHPCMS['meta_description'];

ob_start();
include template("phpcms","index");
$data = ob_get_contents();
ob_clean();
file_write(PHPCMS_ROOT."/index.html",$data);
?>