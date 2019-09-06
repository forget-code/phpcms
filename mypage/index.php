<?php 
/*
*######################################
* PHPCMS v3.00 - Advanced Content Manage System.
* Copyright (c) 2004-2005 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*######################################
*/
require "../common.php"; 

foreach($_MODULE as $module => $m)
{
    if($m['enablecopy']) @include_once PHPCMS_ROOT."/module/".$module."/include/tag.php";
}

if(!preg_match('/^[0-9a-z_]+$/i',$name)) message("对不起，参数错误！","goback");

$r = $db->get_one("select * from ".TABLE_MYPAGE." where name='$name'","CACHE",604800);
if(!$r[mypageid]) message("网页不存在！");
@extract($r);

$skindir = $skinid ? PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$skinid : $skindir;

$filecaching = 1;

include template("mypage",$templateid);
?>