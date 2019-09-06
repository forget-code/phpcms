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

include PHPCMS_ROOT."/module/".$mod."/common.php";

$position = "<a href='".$channelurl."'>".$channelname."首页</a> >> <a href='".$channelurl."special/'>专题首页</a>";

$speciallisturl = $p->get_speciallisturl(1);

$meta_title = $_CHA['channelname']."频道-专题";
$meta_keywords = $_CHA['meta_keywords'];
$meta_description = $_CHA['meta_keywords'];

$filecaching = 1;

include template($mod,"special");
?>
