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
$item = $item ? $item: '';
$itemid = $itemid ? $itemid: '';
if( empty($item) || empty($itemid) ) 
   message("参数错误！");

$_PHPCMS['announce_show'] = $_PHPCMS['announce_show'] ? $_PHPCMS['announce_show'] : 0;
$templateid = $templateid ? $templateid : 0;
$showpage = $showpage ? $showpage : 0;
$listnum = $listnum ? $listnum : 10;
include template($_PHPCMS['announce_show'],'announce','index');
?>
