<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further picturermation go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/

//图片标题列表
function picturelist($templateid,$channelid,$catid=0,$child=1,$specialid=0,$page=0,$picturenum=10,$titlelen=30,$descriptionlen=0,$iselite=0,$datenum=0,$ordertype=1,$datetype=0,$showcatname=0,$showauthor=0,$showhits=0,$target=0,$cols=1) {
	global $db,$p,$timestamp,$_CAT,$_CHA,$js_path;
	if($channelid != $_CHA['channelid'])
	{
		@include PHPCMS_CACHEDIR."channel_".$channelid.".php";
		@include PHPCMS_CACHEDIR."category_".$channelid.".php";
		$_CHA = $_MYCHANNEL[$channelid];
		$_CAT = $_CATEGORY[$channelid];
		$p->urlpath($_CHA,$_CAT);
	}
	$p->set_type('url');
	$ordertypes = array('1'=>' pictureid DESC ','2'=>' pictureid ','3'=>' edittime DESC ','4'=>' edittime ','5'=>' hits DESC ','6'=>' hits ');
	$datetypes = array('1'=>'Y-m-d','2'=>'m-d','3'=>'Y/m/d','4'=>'Y.m.d');
	$condition = '';
	$pictures = array();
	$target = $target ? "_blank" : "_self";
	$page = isset($page) ? $page : 1;
	$offset = $page ? ($page-1)*$picturenum : 0;
	$limit = $picturenum ? ' LIMIT '.$offset.','.$picturenum : '';
	$width = ceil(100/$cols).'%';
	$catids = $catid ;
	if($child && $catid && is_numeric($catid)) 
	{
		$catids = $_CAT[$catid][arrchildid];
	}
	$condition .= $catids ? (is_numeric($catids) ? " and catid='$catid' " : " and catid IN ($catids) ") : "";
	$condition .= $specialid ? (is_numeric($specialid) ? " and specialid='$specialid' " : " and specialid IN ($specialid) ") : "";
	$condition .= $iselite ? " and elite=1 " : "";
	$condition .= $datenum ? " and addtime>$timestamp-86400*$datenum " : "";
	$ordertype = $ordertype ? $ordertypes[$ordertype] : $ordertypes[1];
	if($page && $picturenum)
	{
		$r=$db->get_one("SELECT count(*) AS number FROM ".TABLE_PICTURE." WHERE channelid=$channelid and status=3 and recycle=0 $condition ");
        if(is_numeric($catid) && $catid>0)
		{
		    $p->set_catid($catid);
            $pages = listpages($r[number], $page, $picturenum);
		}
		else
		{
            $pages = phppages($r[number], $page, $picturenum);
		}
	}
	$content = $descriptionlen ? ",content" : "";
	$result = $db->query("SELECT pictureid,catid,title,includepic,titlefontcolor,titlefonttype,thumb,linkurl,author,hits,username,addtime,edittime,ontop,elite $content FROM ".TABLE_PICTURE." WHERE channelid=$channelid and status=3 and recycle=0 $condition ORDER BY ontop DESC, $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$picture = $r;
		$p->set_catid($r[catid]);
		$picture[adddate] = $datetype ? date($datetypes[$datetype],$r[addtime]) : '';
		$picture[url] = $picture[linkurl] ? $picture[linkurl] : $js_path.$p->get_itemurl($r[pictureid],$r[addtime]);
		$picture[alt] = $r[title];
		$picture[title] = $titlelen ? wordscut($r[title],$titlelen,0) : '';
		$picture[title] = titleformat($picture[title],$r[titlefontcolor],$r[titlefonttype],'');
		$picture[content] = $descriptionlen ? wordscut(strip_tags($r[content]),$descriptionlen,1) : '';
		$picture[author] = $showauthor ? $r[author] : '';
		$picture[hits] = $showhits ? $r[hits] : '';
		$picture[target] = $target;
		$picture[catname] = $showcatname ? "[<a href=\"".$js_path.$p->get_listurl(0)."\" target=\"_blank\" class=\"tag_cat_link\">".$_CAT[$r[catid]][catname]."</a>]" : "";
		$picturetype = $r[elite] ? 'elite' : ($r[ontop] ? 'ontop' : 'common');
		$picture[img] = "<img src=\"".$js_path.PHPCMS_PATH."images/picture_".$picturetype.".gif\" border=\"0\"  alt=\"\" />";
		$pictures[]=$picture;
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_picturelist";
	include template('picture',$templateid);
}

//图片缩略图列表
function picpicture($templateid,$channelid,$catid=0,$child=1,$specialid=0,$page=0,$picturenum=10,$titlelen=30,$descriptionlen=100,$iselite=0,$datenum=0,$ordertype=1,$showtype=1,$showalt=1,$imgwidth=100,$imgheight=100,$cols=1) {
	global $db,$p,$timestamp,$_CAT,$_CHA,$js_path;
	if($channelid != $_CHA['channelid'])
	{
		@include PHPCMS_CACHEDIR."channel_".$channelid.".php";
		@include PHPCMS_CACHEDIR."category_".$channelid.".php";
		$_CHA = $_MYCHANNEL[$channelid];
		$_CAT = $_CATEGORY[$channelid];
		$p->urlpath($_CHA,$_CAT);
	}
	$p->set_type('url');
	$ordertypes = array('1'=>' pictureid DESC ','2'=>' pictureid ','3'=>' edittime DESC ','4'=>' edittime ','5'=>' hits DESC ','6'=>' hits ');
	$datetypes = array('1'=>'Y-m-d','2'=>'m-d','3'=>'Y/m/d','4'=>'Y.m.d');
	$condition = '';
	$pictures = array();
	$page = isset($page) ? $page : 1;
	$offset = $page ? ($page-1)*$picturenum : 0;
	$limit = $picturenum ? ' LIMIT '.$offset.','.$picturenum : '';
	$catids = $catid ;
	if($child && $catid && is_numeric($catid)) 
	{
		$catids = $_CAT[$catid][arrchildid];
	}
	$condition .= $catids ? (is_numeric($catids) ? " and catid='$catid' " : " and catid IN ($catids) ") : "";
	$condition .= $specialid ? (is_numeric($specialid) ? " and specialid='$specialid' " : " and specialid IN ($specialid) ") : "";
	$condition .= $iselite ? " and elite=1 " : "";
	$condition .= $datenum ? " and addtime>$timestamp-86400*$datenum " : "";
	$condition .= " ORDER BY ".$ordertypes[$ordertype];
	if($page && $picturenum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_PICTURE." WHERE channelid=$channelid and status=3 and recycle=0 and thumb!='' $condition ");
        if(is_numeric($catid) && $catid>0)
		{
		    $p->set_catid($catid);
            $pages = listpages($r[number], $page, $picturenum);
		}
		else
		{
            $pages = phppages($r[number], $page, $picturenum);
		}
	}
	$content = $descriptionlen ? ",content" : "";
	$result = $db->query("SELECT pictureid,catid,title,includepic,titlefontcolor,titlefonttype,author,hits,thumb,linkurl,username,addtime,edittime,ontop,elite $content FROM ".TABLE_PICTURE." WHERE channelid=$channelid and status=3 and recycle=0 and thumb!='' $condition $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$picture = $r;
		$p->set_catid($r[catid]);
		$picture[url] = $picture[linkurl] ? $picture[linkurl] : $js_path.$p->get_itemurl($r[pictureid],$r[addtime]);
		$length = $titlelen ? $titlelen-6 : $titlelen;
		$picture[title] = $titlelen ? wordscut(strip_tags($r[title]),$titlelen,0) : '';
		$picture[title] = titleformat($picture[title],$r[titlefontcolor],$r[titlefonttype],'');
		$picture[content] = $descriptionlen ? wordscut(strip_tags($r[content]),$descriptionlen,1) : '';
		$picture[catname] = $showcatname ? "[<a href=\"".$js_path.$p->get_listurl(0)."\" target=\"_blank\" class=\"tag_cat_link\">".$_CAT[$r[catid]][catname]."</a>]" : "";
		$picturetype = $r[elite] ? 'elite' : ($r[ontop] ? 'ontop' : 'common');
		$picture[img] = "<img src=\"".$js_path.PHPCMS_PATH."images/picture_".$picturetype.".gif\" border=\"0\"  alt=\"\" />";
		$picture[thumb] = get_imgurl($r['thumb']);
		$picture[alt] = "标 题:".$r[title]."&#10;作 者：".$r[author]."&#10;日 期:".date('Y-m-d H:i:s',$r[addtime])."&#10;点 击:".$r[hits];
		$pictures[]=$picture;
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_picpicture";
	include template('picture',$templateid);
}

//图片列表幻灯片
function slidepicpicture($templateid,$channelid,$catid=0,$child=1,$specialid=0,$picturenum=10,$titlelen=30,$iselite=0,$datenum=0,$ordertype=1,$imgwidth=100,$imgheight=100,$timeout=5000,$effectid=-1) {
	global $db,$p,$timestamp,$_CAT,$_CHA,$js_path;
	if($channelid != $_CHA['channelid'])
	{
		@include PHPCMS_CACHEDIR."channel_".$channelid.".php";
		@include PHPCMS_CACHEDIR."category_".$channelid.".php";
		$_CHA = $_MYCHANNEL[$channelid];
		$_CAT = $_CATEGORY[$channelid];
		$p->urlpath($_CHA,$_CAT);
	}
	$p->set_type('url');
	$ordertypes = array('1'=>' pictureid DESC ','2'=>' pictureid ','3'=>' edittime DESC ','4'=>' edittime ','5'=>' hits DESC ','6'=>' hits ');
	$condition = '';
	$pictures = array();
	$limit = $picturenum ? ' LIMIT 0,'.$picturenum : '';
	$catids = $catid ;
	if($child && $catid && is_numeric($catid)) 
	{
		$catids = $_CAT[$catid][arrchildid];
	}
	
	$k=0;
	$flash_pics="imgUrl0";
	$flash_links="imgLink0";
	$flash_texts="imgtext0";

	$condition .= $catids ? (is_numeric($catids) ? " and catid='$catid' " : " and catid IN ($catids) ") : "";
	$condition .= $specialid ? (is_numeric($specialid) ? " and specialid='$specialid' " : " and specialid IN ($specialid) ") : "";
	$condition .= $iselite ? " and elite=1 " : "";
	$condition .= $datenum ? " and addtime>$timestamp-86400*$datenum " : "";
	$condition .= " ORDER BY ".$ordertypes[$ordertype];
	$result=$db->query("SELECT pictureid,catid,title,includepic,titlefontcolor,titlefonttype,author,hits,thumb,linkurl,username,addtime,edittime,ontop,elite FROM ".TABLE_PICTURE." WHERE channelid=$channelid AND status=3 AND recycle=0 AND thumb!='' $condition $limit ","CACHE");
	while($r=$db->fetch_array($result))
	{
		$picture = $r;
		$p->set_catid($r[catid]);
		$picture[url] = $picture[linkurl] ? $picture[linkurl] : $js_path.$p->get_itemurl($r[pictureid],$r[addtime]);
		$picture[title] = $titlelen ? wordscut($r[title],$titlelen) : $r[title];
		$picture[title] = addslashes($picture[title]);
		$picture[thumb] = get_imgurl($r[thumb]);
		$picture[flashpic] = preg_match("/\.(jpg|jpeg)$/i",$r[thumb]) ? $picture[thumb] : PHPCMS_PATH.'images/focus.jpg';
		if($k)
		{
			$flash_pics.="+\"|\"+imgUrl".$k;
			$flash_links.="+\"|\"+imgLink".$k;
			$flash_texts.="+\"|\"+imgtext".$k;
		}
		$k++;
		$pictures[]=$picture;
	}
	if(!count($pictures))
	{
		$pictures[0][thumb] = $js_path.PHPCMS_PATH.'images/nopic.gif';
		$pictures[0][url]= '#';
		$pictures[0][title] = '';
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_slidepicpicture";
	include template('picture',$templateid);
}

function relatedpicture($templateid,$channelid,$keywords,$pictureid=0,$picturenum=10,$titlelen=50,$datetype=1)
{
	global $db,$p,$timestamp,$_CAT,$_CHA,$js_path;
	if(!$keywords) return "";
	$dkeywords = explode(",",$keywords);
	$sql = "";
	foreach($dkeywords as $k=>$v)
	{
		if($k>2) break;
		$sql .= $k ? " or title like '%$v%' " : " title like '%$v%' ";
	}
	$datetypes = array('1'=>'Y-m-d','2'=>'m-d','3'=>'Y/m/d','4'=>'Y.m.d');
	$result=$db->query("SELECT pictureid,catid,title,includepic,titlefontcolor,titlefonttype,linkurl,author,hits,thumb,username,addtime,edittime,ontop,elite FROM ".TABLE_PICTURE." WHERE channelid=$channelid and status=3 and recycle=0 and pictureid!='$pictureid' and ($sql) ORDER BY ontop DESC,pictureid DESC limit 0,$picturenum ","CACHE");
	while($r=$db->fetch_array($result))
	{
		$picture = $r;
		$p->set_catid($r[catid]);
		$picture[adddate] = $datetype ? date($datetypes[$datetype],$r[addtime]) : '';
		$picture[url] = $picture[linkurl] ? $picture[linkurl] : $js_path.$p->get_itemurl($r[pictureid],$r[addtime]);
		$picture[title] = wordscut($r[title],$titlelen,1);
		$picture[title] = titleformat($picture[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
		$picture[catname] = "[<a href=\"".$js_path.$p->get_listurl(0)."\" target=\"_blank\" class=\"tag_cat_link\">".$_CAT[$r[catid]][catname]."</a>]";
		$picturetype = $r[elite] ? 'elite' : ($r[ontop] ? 'ontop' : 'common');
		$picture[img] = "<img src=\"".$js_path.PHPCMS_PATH."images/picture_".$picturetype.".gif\" border=\"0\"  alt=\"\" />";
		$picture[alt] = $r[title];
		$pictures[]=$picture;
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_relatedpicture";
	include template('picture',$templateid);
}
?>