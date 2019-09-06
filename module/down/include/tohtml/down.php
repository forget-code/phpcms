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

if(!$_CHA['htmlcreatetype']) return false;

$downid = intval($downid);
if(!$downid) return FALSE;

$r = $db->get_one("select * from ".TABLE_DOWN." where downid='$downid' and status='3' and channelid='$channelid'");
if(!$r['downid']) return FALSE;
@extract($r);
unset($r);

$cat = $_CAT[$catid];

if($linkurl)
{
	$p->set_type("path");
	$filepath = $p->get_itemurl($downid,$addtime);
	$f->create(dirname($filepath));
	file_write($filepath,"<script language='javascript'>location.href='".$linkurl."';</script>");
	return true;
}

$templateid = $templateid ? $templateid : $cat['defaultitemtemplate'];
$templateid = $templateid ? $templateid : "content";

$skinid = $skinid ? $skinid : $cat['defaultitemskin'];
$skindir = $skinid ? PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$skinid : $skindir;

$meta_title = $title."-".$_CHA['channelname'];
$meta_keywords = $keywords.",".$cat['meta_keywords'].",".$_CHA['meta_keywords'].",".$_CHA['channelname'];
$meta_description = $cat['meta_description']."-".$_CHA['meta_description']."-".$_CHA['channelname'];

$position = cat_posurl($catid);
$adddate=date('Y-m-d',$addtime);
$introduce=keylink(reword($introduce));
$edittime=date('Y-m-d H:i:s',$edittime);
$username=$username ? $username:'未知';
$ontop=$ontop ? '<font color="red">顶</font> ':'';
$elite=$elite ? '<font color="blue">荐</font>':'';
$thumb = get_imgurl($thumb);
$stars = stars($stars,"★");
$filesize = $filesize>1000 ? round($filesize/1000,2)." M" : $filesize." K";

$urls = explode("\n",$downurls);
$urls = array_map("trim",$urls);
$downurls = array();
foreach($urls as $k=>$v)
{
	$downurl = explode("|",$v);
	$downurl['id'] = $k;
	$downurl['name'] = $downurl[0];
	$downurl['type'] = preg_match("/^(http|https|ftp|mms|rstp|rtsp):\/\//i",$downurl[1]) ? "" : "（本地下载）";
	$downurl['url'] = $downurl[1];
	$downurls[] = $downurl;
}

$p->set_type("url");
$p->set_catid($catid);

$itemurl = ($_CHA[channeldomain] ? "" : "http://".$PHP_DOMAIN).$p->get_itemurl($downid,$addtime);

if($specialid)
{
    $special = $db->get_one("SELECT specialname,addtime FROM ".TABLE_SPECIAL." WHERE specialid=$specialid");
    $special['specialurl'] = $p->get_specialitemurl($specialid,$special['addtime']);
}

ob_start();
include template("down",$templateid);
$data = ob_get_contents();
ob_clean();

$p->set_type("path");
$p->set_catid($catid);
$filepath = $p->get_itemurl($downid,$addtime);
$f->create(dirname($filepath));
file_write($filepath,$data);

return TRUE;
?>