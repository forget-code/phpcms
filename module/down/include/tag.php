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
function downlist($templateid=0,$channelid,$catid=0,$child=1,$specialid=0,$page=0,$downnum=10,$titlelen=30,$descriptionlen=0,$iselite=0,$datenum=0,$ordertype=0,$datetype=0,$showcatname=0,$showauthor=0,$showdowns=0,$showsize=0,$showstars=0,$target=0,$cols=1)
{
	global $db,$p,$timestamp,$_CAT,$_CHA,$js_path;
	if($channelid != $_CHA['channelid'])
	{
		@include PHPCMS_CACHEDIR."channel_".$channelid.".php";
		@include PHPCMS_CACHEDIR."category_".$channelid.".php";
		$_CHA = $_MYCHANNEL[$channelid];
		$_CAT = $_CATEGORY[$channelid];
		$p->urlpath($_CHA,$_CAT);
		$channelid = $_CHA['channelid'];
	}
	$p->set_type('url');
	$ordertypes = array('1'=>' downid desc ','2'=>' downid asc','3'=>' edittime desc ','4'=>' edittime asc ','5'=>' downs desc ','6'=>' downs asc ');
	$datetypes = array('1'=>'Y-m-d','2'=>'m-d','3'=>'Y/m/d','4'=>'Y.m.d');
	$condition = '';
	$downs = array();
	$target = $target ? "_blank" : "_self";
	$page = isset($page) ? $page : 1;
	$offset = $page ? ($page-1)*$downnum : 0;
	$limit = $downnum ? ' LIMIT '.$offset.','.$downnum : '';
	$catids = $catid;
	if($child && $catid && is_numeric($catid)) 
	{
		$catids = $_CAT[$catid]['arrchildid'];
	}
	$condition .= $catids ? (is_numeric($catids) ? " and catid='$catid' " : " and catid IN ($catids) ") : "";
	$condition .= $specialid ? (is_numeric($specialid) ? " and specialid='$specialid' " : " and specialid IN ($specialid) ") : "";
	$condition .= $iselite ? " and elite=1 " : "";
	$condition .= $datenum ? " and addtime>$timestamp-86400*$datenum " : "";
	$ordertype  = $ordertype ? $ordertype : 1;
	$ordertype	= $ordertypes[$ordertype];
	if($page && $downnum)
	{
		$r = $db->get_one("select count(*) as number from ".TABLE_DOWN." WHERE channelid=$channelid and status=3 and recycle=0 $condition ");
        if(is_numeric($catid) && $catid>0)
		{
		    $p->set_catid($catid);
            $pages = listpages($r[number], $page, $downnum);
		}
		else
		{
            $pages = phppages($r[number], $page, $downnum);
		}
	}
	$introduce = $descriptionlen ? ",introduce" : "";
	$result = $db->query("select downid,catid,title,includepic,titlefontcolor,titlefonttype,downs,filesize,stars,addtime,ontop,elite $introduce from ".TABLE_DOWN." WHERE channelid=$channelid and status=3 and recycle=0 $condition order by ontop DESC, $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$down = $r;
		$p->set_catid($r[catid]);
		$down['adddate']	= $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$down['url']		= $down[linkurl] ? $down[linkurl] : $js_path.$p->get_itemurl($r['downid'],$r['addtime']);
		$down['title']			= $titlelen ? wordscut($r['title'],$titlelen,0) : '';
		$down['title']		= titleformat($down['title'],$r['titlefontcolor'],$r['titlefonttype'],'');
		$down['introduce']	= $descriptionlen ? wordscut(strip_tags($r['introduce']),$descriptionlen,1) : '';
		$down['filesize']	= $down['filesize']>1000 ? round($down['filesize']/1000,2)." MB" : $down['filesize']." KB";
		$down['stars'] = stars($down['stars']);
		$down[catname] = $showcatname ? "[<a href=\"".$js_path.$p->get_listurl(0)."\" target=\"_blank\" class=\"tag_cat_link\">".$_CAT[$r[catid]][catname]."</a>]" : "";
		$downtype			= $r['elite'] ? 'elite' : ($r['ontop'] ? 'ontop' : 'common');
		$down[img]			= "<img src=\"".$js_path.PHPCMS_PATH."images/down_".$downtype.".gif\" border=\"0\"  alt=\"\" />";
		$down['alt']		= $r['title'];
		$downs[]=$down;
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_downlist";
	include template('down',$templateid);
}

//图片缩略图列表
function picdown($templateid=0,$channelid,$catid=0,$child=1,$specialid=0,$page=0,$downnum=10,$titlelen=30,$descriptionlen=100,$iselite=0,$datenum=0,$ordertype=1,$showtype=1,$showalt=1,$imgwidth=100,$imgheight=100,$cols=1)
{
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
	$ordertypes = array('1'=>' downid desc ','2'=>' downid asc','3'=>' edittime desc ','4'=>' edittime asc ','5'=>' downs desc ','6'=>' downs asc ');
	$datetypes = array('1'=>'Y-m-d','2'=>'m-d','3'=>'Y/m/d','4'=>'Y.m.d');
	$condition = '';
	$downs = array();
	$page = isset($page) ? $page : 1;
	$offset = $page ? ($page-1)*$downnum : 0;
	$limit = $downnum ? ' LIMIT '.$offset.','.$downnum : '';
	$catids = $catid ;
	$channelid=$_CHA['channelid'];
	if($child && $catid && is_numeric($catid)) 
	{
		$catids = $_CAT[$catid][arrchildid];
	}
	$condition .= $catids ? (is_numeric($catids) ? " and catid='$catid' " : " and catid IN ($catids) ") : "";
	$condition .= $specialid ? (is_numeric($specialid) ? " and specialid='$specialid' " : " and specialid IN ($specialid) ") : "";
	$condition .= $iselite ? " AND elite=1 " : "";
	$condition .= $datenum ? " AND addtime>$timestamp-86400*$datenum " : "";
	$ordertype	= $ordertypes[$ordertype];
	if($page && $downnum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_DOWN." WHERE channelid=$channelid and status=3 and recycle=0 and thumb<>'' $condition ");
        if(is_numeric($catid) && $catid>0)
		{
		    $p->set_catid($catid);
            $pages = listpages($r[number], $page, $downnum);
		}
		else
		{
            $pages = phppages($r[number], $page, $downnum);
		}
	}
	$introduce = $descriptionlen ? ",introduce" : "";
	$result = $db->query("select downid,catid,title,includepic,titlefontcolor,titlefonttype,thumb,hits,addtime,edittime,ontop,elite $introduce from ".TABLE_DOWN." WHERE channelid=$channelid AND status=3 AND recycle=0 AND thumb!='' $condition order by ontop DESC,$ordertype $limit ","CACHE");
	while($r=$db->fetch_array($result))
	{
		$down = $r;
		$p->set_catid($r[catid]);
		$down[url] = $down[linkurl] ? $down[linkurl] : $js_path.$p->get_itemurl($r[downid],$r[addtime]);
		$down['title'] = $titlelen ? wordscut($r['title'],$titlelen,1) : '';
		$down['title'] = titleformat($down['title'],$r[titlefontcolor],$r[titlefonttype],'');
		$down['introduce'] = $descriptionlen ? wordscut(strip_tags($r['introduce']),$descriptionlen,1) : '';
		$downtype = $r[elite] ? 'elite' : ($r[ontop] ? 'ontop' : 'common');
		$down['img'] = "<img src=\"".$js_path.PHPCMS_PATH."images/down_".$downtype.".gif\" border=\"0\" />";
		$down[thumb] = get_imgurl($r[thumb]);
		$down[alt] = "标 题:".$r['title']."&#10;作 者：".$r[author]."&#10;日 期:".date('Y-m-d H:i:s',$r[addtime])."&#10;点 击:".$r[hits];
		$downs[]=$down;
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_picdown";
	include template('down',$templateid);
}

//图片列表幻灯片
function slidepicdown($templateid,$channelid,$catid=0,$child=1,$specialid=0,$downnum=10,$titlelen=30,$iselite=0,$datenum=0,$ordertype=1,$imgwidth=100,$imgheight=100,$timeout=5000,$effectid=-1) {
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
	$ordertypes = array('1'=>' downid desc ','2'=>' downid asc','3'=>' edittime desc ','4'=>' edittime asc ','5'=>' downs desc ','6'=>' downs asc ');
	$condition = '';
	$downs = array();
	$limit = $downnum ? " LIMIT 0,$downnum " : "";
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
	$condition .= $iselite ? " AND elite=1 " : "";
	$condition .= $datenum ? " AND addtime>$timestamp-86400*$datenum " : "";
	$condition .= " ORDER BY ".$ordertypes[$ordertype];
	$result = $db->query("SELECT downid,catid,title,includepic,titlefontcolor,titlefonttype,thumb,hits,addtime,edittime,ontop,elite FROM ".TABLE_DOWN." WHERE channelid=$channelid AND status=3 AND recycle=0 AND thumb!='' $condition $limit ","CACHE");
	while($r=$db->fetch_array($result))
	{
		$down = $r;
		$p->set_catid($r[catid]);
		$down['url'] = $down[linkurl] ? $down[linkurl] : $js_path.$p->get_itemurl($r['downid'],$r['addtime']);
		$down['title'] = $titlelen ? wordscut($r['title'],$titlelen) : $r['title'];
		$down['title'] = addslashes($down['title']);
		$down['thumb'] = get_imgurl($r['thumb']);
		$down['flashpic'] = preg_match("/\.(jpg|jpeg)$/i",$r[thumb]) ? $down['thumb'] : PHPCMS_PATH.'images/focus.jpg';
		if($k)
		{
			$flash_pics.="+\"|\"+imgUrl".$k;
			$flash_links.="+\"|\"+imgLink".$k;
			$flash_texts.="+\"|\"+imgtext".$k;
		}
		$k++;
		$downs[]=$down;
	}
	if(!count($downs))
	{
		$downs[0][thumb] = $js_path.PHPCMS_PATH.'images/nopic.gif';
		$downs[0][url]= '#';
		$downs[0]['title'] = '';
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_slidepicdown";
	include template('down',$templateid);
}

function relateddown($templateid,$channelid,$keywords,$downid=0,$downnum=10,$titlelen=50,$datetype=1)
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
	$result=$db->query("SELECT downid,catid,title,titlefontcolor,titlefonttype,linkurl,author,downs,thumb,username,addtime,edittime,ontop,elite FROM ".TABLE_DOWN." WHERE channelid=$channelid and status=3 and recycle=0 and downid!='$downid' and ($sql) ORDER BY ontop DESC,downid DESC limit 0,$downnum ","CACHE");
	while($r=$db->fetch_array($result))
	{
		$down = $r;
		$p->set_catid($r[catid]);
		$down[adddate] = $datetype ? date($datetypes[$datetype],$r[addtime]) : '';
		$down[url] = $down[linkurl] ? $down[linkurl] : $js_path.$p->get_itemurl($r[downid],$r[addtime]);
		$down[title] = wordscut($r[title],$titlelen,1);
		$down[title] = titleformat($down[title],$r[titlefontcolor],$r[titlefonttype],'');
		$down[catname] = "[<a href=\"".$js_path.$p->get_listurl(0)."\" target=\"_blank\" class=\"tag_cat_link\">".$_CAT[$r[catid]][catname]."</a>]";
		$downtype = $r[elite] ? 'elite' : ($r[ontop] ? 'ontop' : 'common');
		$down[img] = "<img src=\"".$js_path.PHPCMS_PATH."images/down_".$downtype.".gif\" border=\"0\"  alt=\"\" />";
		$down[alt] = $r[title];
		$downs[]=$down;
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_relateddown";
	include template('down',$templateid);
}
?>