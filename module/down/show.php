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

require PHPCMS_ROOT."/module/down/common.php";

$itemid = intval($itemid);
$down = $db->get_one("SELECT * FROM ".TABLE_DOWN." WHERE downid='$itemid'","CACHE",86400);
@extract($down);
unset($down);

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
$adddate=date('Y-m-d',$addtime);
$introduce=keylink(reword($introduce));
$edittime=date('Y-m-d H:i:s',$edittime);
$username=$username ? $username:'未知';
$ontop=$ontop ? '<font color="red">顶</font> ':'';
$elite=$elite ? '<font color="blue">荐</font>':'';
$thumb = get_imgurl($thumb);
$stars = stars($stars,"★");
$filesize = $filesize>1000 ? round($filesize/1000,2)." M" : $filesize." K";

$cat_arrgroupid_view = $cat['arrgroupid_view'] ? $cat['arrgroupid_view'] : $_CHA['arrgroupid_view'];
$groupview = $groupview ? $groupview : $cat_arrgroupid_view;

$p->set_type("url");
$p->set_catid($catid);

$itemurl = ($_CHA[channeldomain] ? "" : "http://".$PHP_DOMAIN).$p->get_itemurl($downid,$addtime);

if(check_purview($groupview))
{
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
	if($readpoint>0)
	{
		if(!$_userid) message("阅读本文需要点数！请登录！",PHPCMS_PATH."member/login.php?referer=".$PHP_URL);
		if($_chargetype)
		{
			charge_time();
		}
		elseif(!getcookie("down_".$downid))
        {
			if($read==1)
			{
				charge_point($readpoint,$title."(downid=".$downid.")");
				$readtime = $cat['defaultchargetype'] ? 0 : $timestamp+3600*24*365;
				mkcookie("down_".$downid,1,$readtime);
			}
			else
			{
				$addurl = array('read=1&','read-1/','read=1&');
				$readurl = "?".$addurl[$_CHA['urltype']].$PHP_QUERYSTRING;
				$readmessage = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie","\\1",$_CHA['point_message']);
				$downurls=array();
			}
		}
	}
}
else
{
	$downurls=array();
    $readmessage = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie","\\1",$_CHA['purview_message']);
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

include template("down",$templateid);
?>