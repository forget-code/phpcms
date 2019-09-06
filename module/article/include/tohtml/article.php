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

if(!$_CHA[htmlcreatetype]) return false;

$articleid = intval($articleid);
if(!$articleid) return false;

$r = $db->get_one("SELECT * FROM ".TABLE_ARTICLE." WHERE articleid=$articleid and channelid=$channelid");
if(!$r['articleid']) return false;
@extract($r);
unset($r);

$cat = $_CAT[$catid];

if($linkurl)
{
	$p->set_type("path");
	$filepath = $p->get_itemurl($articleid,$addtime);
	$f->create(dirname($filepath));
	file_write($filepath,"<script language='javascript'>location.href='".$linkurl."';</script>");
	return true;
}

$templateid = $templateid ? $templateid : $cat['defaultitemtemplate'];
$templateid = $templateid ? $templateid : "content";

$skinid = $skinid ? $skinid : $cat['defaultitemskin'];
$skindir = $skinid ? PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$skinid : $skindir;

$adddate = date('Y-m-d H:i:s',$addtime);
$position = cat_posurl($catid);

$p->set_type("url");
$p->set_catid($catid);

$itemurl = ($_CHA[channeldomain] ? "" : "http://".$PHP_DOMAIN).$p->get_itemurl($articleid,$addtime);

$meta_title = $title."-".$_CHA['channelname'];
$meta_keywords = $keywords.",".$cat['meta_keywords'].",".$_CHA['meta_keywords'].",".$_CHA['channelname'];
$meta_description = $cat['meta_description']."-".$_CHA['meta_description']."-".$_CHA['channelname'];

if($specialid)
{
    $special = $db->get_one("SELECT specialname,addtime FROM ".TABLE_SPECIAL." WHERE specialid=$specialid");
    $special['specialurl'] = $p->get_specialitemurl($specialid,$special['addtime']);
}

if($paginationtype==1)
{
	$charnumber = strlen($content);
	$pagenumber = ceil($charnumber/$maxcharperpage);
	$contents = $content;
}
elseif($paginationtype==2)
{
	$contents = explode('[next]',$content);
	$pagenumber = count($contents);
}

if($pagenumber>1)
{
	for($i=0;$i<$pagenumber;$i++)
	{
		$page = $i+1;
		if($paginationtype==1)
		{
			$start = $i*$maxcharperpage;
			$content = get_substr($contents,$start,$maxcharperpage);
		}
		elseif($paginationtype==2)
		{
			$content = $contents[$i];
		}
		$content = keylink(reword($content));
		ob_start();
		$p->set_type("url");
		$p->set_catid($catid);
		$pages = articlepage($articleid,$addtime,$pagenumber,$page);
		include template("article",$templateid);
		$data = ob_get_contents();
		ob_clean();
		$p->set_type("path");
		$p->set_catid($catid);
		$filepath = $p->get_itemurl($articleid,$addtime,$page);
		$f->create(dirname($filepath));
		file_write($filepath,$data);
	}
}
else
{
	$content = keylink(reword($content));
	ob_start();
	$p->set_type("url");
	include template("article",$templateid);
	$data = ob_get_contents();
	ob_clean();
	$p->set_type("path");
    $p->set_catid($catid);
	$filepath = $p->get_itemurl($articleid,$addtime);
	$f->create(dirname($filepath));
	file_write($filepath,$data);
}

return TRUE;
?>