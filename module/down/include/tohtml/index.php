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

if(!$_CHA[htmlcreatetype]) return FALSE;

$templateid = $_CHA['templateid'] ? $_CHA['templateid'] : "index";

$meta_title = $_CHA['channelname'];
$meta_keywords = $_CHA['meta_keywords'];
$meta_description = $_CHA['meta_description'];

$childcats = get_childcatlist($channelid);

ob_start();
include template($mod,$templateid);
$data = ob_get_contents();
ob_clean();

$p->set_type('path');
$filename = $p->get_indexurl(1);
file_write($filename,$data);
?>