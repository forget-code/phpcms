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
if($_CHA[htmlcreatetype]==0 || $_CHA[htmlcreatetype]==2) return FALSE;

$specialid = intval($specialid);
if(!$specialid) return FALSE;

$special = $db->get_one("SELECT * FROM ".TABLE_SPECIAL." WHERE specialid=$specialid");
@extract($special);

$templateid = $templateid ? $templateid : "special_show";
$skindir = $skinid ? PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$skinid : $skindir;

$adddate=date('Y-m-d',$addtime);
$specialpic = get_imgurl($specialpic);
$specialbanner = get_imgurl($specialbanner);
$position = "<a href='".PHPCMS_PATH."'>首页</a> >> <a href='".$channelurl."'>".$channelname."</a> >> <a href='".$channelurl."special/'>专题</a>";

$meta_title = $specialname;
$meta_keywords = $meta_keywords ? $meta_keywords : strip_tags($_CHA['meta_keywords']);
$meta_description = $meta_description ? $meta_description : strip_tags($introduce);

ob_start();
include template($_CHA['module'],$templateid);
$data = ob_get_contents();
ob_clean();
$p->set_type("path");
$filepath = $p->get_specialitemurl($specialid,$addtime);
$f->create(dirname($filepath));
file_write($filepath,$data);
return TRUE;
?>