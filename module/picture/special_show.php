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

$specialid = intval($specialid);
if(!$specialid)	message('非法参数！请返回！','goback');

$special = $db->get_one("SELECT * FROM ".TABLE_SPECIAL." WHERE specialid=$specialid and channelid=$channelid ");
@extract($special);

$templateid = $templateid ? $templateid : "special_show";
$skindir = $skinid ? PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$skinid : $skindir;

$adddate=date('Y-m-d',$addtime);
$specialpic = get_imgurl($specialpic);
$specialbanner = get_imgurl($specialbanner);

$position = "<a href='".$channelurl."'>".$channelname."首页</a> >> <a href='".$channelurl."special/'>专题</a>";

$meta_title = $specialname;
$meta_keywords = $meta_keywords ? $meta_keywords : strip_tags($_CHA['meta_keywords']);
$meta_description = $meta_description ? $meta_description : strip_tags($introduce);

$filecaching = 1;

include template($mod,$templateid);
?>
