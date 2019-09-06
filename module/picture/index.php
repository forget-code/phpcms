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

if($_CHA['htmlcreatetype']>0 && file_exists("index.".$_CHA['fileext']))
{
	header("location:index.".$_CHA['fileext']);
	exit;
}

include PHPCMS_ROOT."/module/picture/common.php";

$childcats = get_childcatlist($channelid);

$meta_title = $_CHA['channelname'];
$meta_keywords = $_CHA['meta_keywords'];
$meta_description = $_CHA['meta_description'];

$templateid = $_CHA['templateid'] ? $_CHA['templateid'] : "index";
$filecaching = 1;

include template($mod,$templateid);
?>