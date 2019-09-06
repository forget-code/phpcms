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

require_once MOD_ROOT."/include/tag.php";

$meta_title = "调查列表-".($channelid ? $channelname : "");

$page = intval($page);
$page = $page ? $page : 1;

include template('vote','list');
?>
