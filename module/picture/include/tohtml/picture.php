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

$pictureid = intval($pictureid);
if(!$pictureid) return FALSE;

$picture = $db->get_one("SELECT * FROM ".TABLE_PICTURE." WHERE pictureid='$pictureid' and channelid='$channelid' ");
if(!$picture['pictureid']) return FALSE;
@extract($picture);
unset($picture);

$cat = $_CAT[$catid];

if($linkurl)
{
	$p->set_type("path");
	$filepath = $p->get_itemurl($pictureid,$addtime);
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
$adddate = date('Y-m-d',$addtime);
$content = keylink(reword($content));
$edittime = date('Y-m-d H:i:s',$edittime);
$username = $username ? $username:'未知';
$ontop = $ontop ? ' <font color="red">顶</font>' : '';
$elite = $elite ? ' <font color="blue">荐</font>' : '';
$thumb = get_imgurl($thumb);
$stars = stars($stars,"★");

$pictureurls = trim($pictureurls);  
$urls = explode("\n",$pictureurls);
$urls = array_map("trim",$urls);
$pictureurls = array();
foreach($urls as $k=>$v)
{
	$pictureurl = explode("|",$v);
	$pictureurl['name'] = $pictureurl[0];
	$pictureurl['url'] = get_imgurl($pictureurl[1]);
	$pictureurls[] = $pictureurl;
}

$p->set_type("url");
$p->set_catid($catid);

$itemurl = ($_CHA[channeldomain] ? "" : "http://".$PHP_DOMAIN).$p->get_itemurl($pictureid,$addtime);

if($specialid)
{
    $special = $db->get_one("SELECT specialname,addtime FROM ".TABLE_SPECIAL." WHERE specialid=$specialid");
    $special['specialurl'] = $p->get_specialitemurl($specialid,$special['addtime']);
}

ob_start();
include template("picture",$templateid);
$data = ob_get_contents();
ob_clean();

$p->set_catid($catid);
$p->set_type("path");
$filepath = $p->get_itemurl($pictureid,$addtime);
$f->create(dirname($filepath));
file_write($filepath,$data);

return TRUE;
?>