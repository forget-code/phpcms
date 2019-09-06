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

include PHPCMS_ROOT."/module/article/common.php";

if($_CHA['htmlcreatetype']) exit;

$itemid = intval($itemid);
$page = intval($page);
$page = $page>0 ? $page : 1;

$article = $db->get_one("SELECT * FROM ".TABLE_ARTICLE." WHERE articleid='$itemid'");
@extract($article);
unset($article);

$cat = $_CAT[$catid];

if($linkurl)
{
	header("location:".$linkurl);
	exit;
}

$templateid = $templateid ? $templateid : $cat['defaultitemtemplate'];
$templateid = $templateid ? $templateid : "content";

$skinid = $skinid ? $skinid : $cat['defaultitemskin'];
$skindir = $skinid ? PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$skinid : $skindir;

$position = cat_posurl($catid);
$title = $titleintact ? $titleintact : $title;
$adddate = date('Y-m-d H:i:s',$addtime);
$stars = stars($stars,"★");

$cat_arrgroupid_view = $cat['arrgroupid_view'] ? $cat['arrgroupid_view'] : $_CHA['arrgroupid_view'];
$groupview = $groupview ? $groupview : $cat_arrgroupid_view;

$p->set_type("url");
$p->set_catid($catid);

$itemurl = ($_CHA[channeldomain] ? "" : "http://".$PHP_DOMAIN).$p->get_itemurl($articleid,$addtime);

if(check_purview($groupview))
{
	if($paginationtype==1)
	{
		$charnumber = strlen($content);
		$pagenumber = ceil($charnumber/$maxcharperpage);
		if($pagenumber>1)
		{
			$start = ($page-1)*$maxcharperpage;
			$content = get_substr($content,$start,$maxcharperpage);
			$pages = articlepage($articleid,$addtime,$pagenumber,$page);
		}
	}
	elseif($paginationtype==2)
	{
		$content = explode('[next]',$content);
		$pagenumber = count($content);
		if($pagenumber>1) 
		{
			$i = $page-1;
			$content = $content[$i];
			$pages = articlepage($articleid,$addtime,$pagenumber,$page);
		}
	}
	if($readpoint>0)
	{
		if(!$_userid) message("阅读本文需要点数！请登录！",PHPCMS_PATH."member/login.php?referer=".$PHP_URL);
		if($_chargetype)
		{
			charge_time();
		}
		elseif(!getcookie("article_".$articleid))
        {
			if($read==1)
			{
				charge_point($readpoint,$title."(articleid=".$articleid.")");
				$readtime = $cat['defaultchargetype'] ? 0 : $timestamp+3600*24*365;
				mkcookie("article_".$articleid,1,$readtime);
			}
			else
			{
				$addurl = array('read=1&','read-1/','read=1&');
				$readurl = "?".$addurl[$_CHA['urltype']].$PHP_QUERYSTRING;
				$point_message = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie","\\1",$_CHA['point_message']);
				$content = wordscut(strip_tags($content),200);
				$content = $content.$point_message;
			}
		}
	}
	$content = keylink(reword($content));
}
else
{
    $purview_message = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie","\\1",$_CHA['purview_message']);
	$content = $purview_message;
}

if($specialid)
{
    $special = $db->get_one("SELECT specialname,addtime FROM ".TABLE_SPECIAL." WHERE specialid=$specialid");
    $special['specialurl'] = $p->get_specialitemurl($specialid,$special['addtime']);
}

$meta_title = $title."-".$_CHA['channelname'];
$meta_keywords = $keywords.",".$cat['meta_keywords'].",".$_CHA['meta_keywords'].",".$_CHA['channelname'];
$meta_description = $cat['meta_description']."-".$_CHA['meta_description']."-".$_CHA['channelname'];

if(!$groupview && !$readpoint) $filecaching = 1;

include template("article",$templateid);
?>