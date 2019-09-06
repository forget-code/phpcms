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

require PHPCMS_ROOT."/module/picture/common.php";

if($_CHA[htmlcreatetype]) exit;

$itemid = intval($itemid);
$picture = $db->get_one("SELECT * FROM ".TABLE_PICTURE." WHERE pictureid='$itemid'","CACHE",86400);
@extract($picture);
unset($picture);

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
$adddate = date('Y-m-d',$addtime);
$content = keylink(reword($content));
$edittime = date('Y-m-d H:i:s',$edittime);
$username = $username ? $username:'未知';
$ontop = $ontop ? ' <font color="red">顶</font>' : '';
$elite = $elite ? ' <font color="blue">荐</font>' : '';
$thumb = get_imgurl($thumb);
$stars = stars($stars,"★");

$cat_arrgroupid_view = $cat['arrgroupid_view'] ? $cat['arrgroupid_view'] : $_CHA['arrgroupid_view'];
$groupview = $groupview ? $groupview : $cat_arrgroupid_view;

$p->set_type("url");
$p->set_catid($catid);

$itemurl = ($_CHA[channeldomain] ? "" : "http://".$PHP_DOMAIN).$p->get_itemurl($pictureid,$addtime);

if(check_purview($groupview))
{
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
	if($readpoint>0)
	{
		if(!$_userid) message("阅读本文需要点数！请登录！",PHPCMS_PATH."member/login.php?referer=".$PHP_URL);
		if($_chargetype)
		{
			charge_time();
		}
		elseif(!getcookie("picture_".$pictureid))
        {
			if($read==1)
			{
				charge_point($readpoint,$title."(pictureid=".$pictureid.")");
				$readtime = $cat['defaultchargetype'] ? 0 : $timestamp+3600*24*365;
				mkcookie("picture_".$pictureid,1,$readtime);
			}
			else
			{
				$addurl = array('read=1&','read-1/','read=1&');
				$readurl = "?".$addurl[$_CHA['urltype']].$PHP_QUERYSTRING;
				$readmessage = preg_replace("/[{]([$][a-z_][a-z_\[\]]*)[}]/ie","\\1",$_CHA['point_message']);
				$pictureurls=array();
			}
		}
	}
}
else
{
	$pictureurls=array();
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

include template($mod,$templateid);
?>