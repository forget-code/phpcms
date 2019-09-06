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
function articlelist($templateid,$channelid,$catid=0,$child=1,$specialid=0,$page=0,$articlenum=10,$titlelen=30,$descriptionlen=0,$iselite=0,$datenum=0,$ordertype=1,$datetype=0,$showcatname=0,$showauthor=0,$showhits=0,$target=0,$cols=1) {
	global $db,$p,$timestamp,$_CAT,$_CHA,$temp,$js_path;
	if($channelid != $_CHA['channelid'])
	{
		@include PHPCMS_CACHEDIR."channel_".$channelid.".php";
		@include PHPCMS_CACHEDIR."category_".$channelid.".php";
		$_CHA = $_MYCHANNEL[$channelid];
		$_CAT = $_CATEGORY[$channelid];
		$p->urlpath($_CHA,$_CAT);
	}
	$p->set_type('url');
	$ordertypes = array('1'=>' articleid DESC ','2'=>' articleid ','3'=>' edittime DESC ','4'=>' edittime ','5'=>' hits DESC ','6'=>' hits ');
	$datetypes = array('1'=>'Y-m-d','2'=>'m-d','3'=>'Y/m/d','4'=>'Y.m.d');
	$condition = '';
	$articles = array();
	$target = $target ? "_blank" : "_self";
	$page = isset($page) ? $page : 1;
	$offset = $page ? ($page-1)*$articlenum : 0;
	$limit = $articlenum ? ' LIMIT '.$offset.','.$articlenum : '';
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
	if($page && $articlenum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_ARTICLE." WHERE channelid=$channelid and status=3 and recycle=0 $condition ","CACHE");
        if(is_numeric($catid))
		{
		    $p->set_catid($catid);
            $pages = listpages($r[number], $page, $articlenum);
		}
		else
		{
            $pages = phppages($r[number], $page, $articlenum);
		}
	}
	$result = $db->query("SELECT articleid,catid,title,includepic,titlefontcolor,titlefonttype,showcommentlink,linkurl,author,hits,thumb,username,addtime,edittime,ontop,elite,description FROM ".TABLE_ARTICLE." WHERE channelid=$channelid and status=3 and recycle=0 $condition ORDER BY ontop DESC,$ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$article = $r;
		$p->set_catid($r[catid]);
		$article[adddate] = $datetype ? date($datetypes[$datetype],$r[addtime]) : '';
		$article[url] = $article[linkurl] ? $article[linkurl] : $js_path.$p->get_itemurl($r[articleid],$r[addtime]);
		$length = ($titlelen && $r[includepic]) ? $titlelen-6 : $titlelen;
		$article[title] = wordscut($r[title],$length,1);
		$article[title] = titleformat($article[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
		$article[description] = $descriptionlen ? wordscut(strip_tags($r[description]),$descriptionlen,1) : '';
		$article[catname] = "[<a href=\"".$js_path.$p->get_listurl(0)."\" target=\"_blank\" class=\"tag_cat_link\">".$_CAT[$r[catid]][catname]."</a>]";
		$articletype = $r[elite] ? 'elite' : ($r[ontop] ? 'ontop' : 'common');
		$article[img] = "<img src=\"".$js_path.PHPCMS_PATH."images/article_".$articletype.".gif\" border=\"0\" alt=\"\" />";
		$article[alt] = $r[title];
		$articles[]=$article;
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_articlelist";
	include template('article',$templateid);
}

function picarticle($templateid,$channelid,$catid=0,$child=1,$specialid=0,$page=0,$articlenum=10,$titlelen=30,$descriptionlen=100,$iselite=0,$datenum=0,$ordertype=1,$showtype=1,$showalt=1,$imgwidth=100,$imgheight=100,$cols=1) {
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
	$ordertypes = array('1'=>' articleid DESC ','2'=>' articleid ','3'=>' edittime DESC ','4'=>' edittime ','5'=>' hits DESC ','6'=>' hits ');
	$datetypes = array('1'=>'Y-m-d','2'=>'m-d','3'=>'Y/m/d','4'=>'Y.m.d');
	$condition = '';
	$articles = array();
	$page = isset($page) ? $page : 1;
	$offset = $page ? ($page-1)*$articlenum : 0;
	$limit = $articlenum ? ' LIMIT '.$offset.','.$articlenum : '';
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
	if($page && $articlenum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_ARTICLE." WHERE channelid=$channelid and status=3 and recycle=0 and thumb!='' $condition ","CACHE");
        if(is_numeric($catid))
		{
		    $p->set_catid($catid);
            $pages = listpages($r[number], $page, $articlenum);
		}
		else
		{
            $pages = phppages($r[number], $page, $articlenum);
		}
	}
	$result = $db->query("SELECT articleid,catid,title,includepic,titlefontcolor,titlefonttype,showcommentlink,author,hits,thumb,username,addtime,ontop,elite,description FROM ".TABLE_ARTICLE." WHERE channelid=$channelid and status=3 and recycle=0 and thumb!='' $condition $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$article = $r;
		$p->set_catid($r[catid]);
		$article[url] = $article[linkurl] ? $article[linkurl] : $js_path.$p->get_itemurl($r[articleid],$r[addtime]);
		$length = ($titlelen && $r[includepic]) ? $titlelen-6 : $titlelen;
		$article[title] = wordscut($r[title],$length,1);
		$article[title] = titleformat($article[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
		$article[description] = $descriptionlen ? wordscut(strip_tags($r[description]),$descriptionlen,1) : '';
		$articletype = $r[elite] ? 'elite' : ($r[ontop] ? 'ontop' : 'common');
		$article[img] = "<img src=\"".$js_path.PHPCMS_PATH."images/article_".$articletype.".gif\" border=\"0\"  alt=\"\" />";
		$article[alt] = "标 题:".$r[title]."&#10;作 者：".$r[author]."&#10;日 期:".date('Y-m-d H:i:s',$r[addtime])."&#10;点 击:".$r[hits];
		$article[thumb] = get_imgurl($r[thumb]);
		$articles[]=$article;
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_picarticle";
	include template('article',$templateid);
}

function slidepicarticle($templateid,$channelid,$catid=0,$child=1,$specialid=0,$articlenum=10,$titlelen=30,$iselite=0,$datenum=0,$ordertype=1,$imgwidth=100,$imgheight=100,$timeout=5000,$effectid=-1) {
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
	$ordertypes = array('1'=>' articleid DESC ','2'=>' articleid ','3'=>' edittime DESC ','4'=>' edittime ','5'=>' hits DESC ','6'=>' hits ');
	$condition = '';
	$articles = array();
	$limit = $articlenum ? ' LIMIT 0,'.$articlenum : '';
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
	$result = $db->query("SELECT articleid,catid,title,includepic,titlefontcolor,titlefonttype,showcommentlink,author,hits,thumb,username,addtime,ontop,elite FROM ".TABLE_ARTICLE." WHERE 1 and channelid=$channelid and status=3 and recycle=0 and thumb!='' $condition $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$article = $r;
		$p->set_catid($r[catid]);
		$article[url] = $article[linkurl] ? $article[linkurl] : $js_path.$p->get_itemurl($r[articleid],$r[addtime]);
		$article[title] = $titlelen ? wordscut($r[title],$titlelen,1) : $r[title];
		$article[title] = addslashes($article[title]);
		$article[thumb] = get_imgurl($r[thumb]);
		$article[flashpic] = preg_match("/\.(jpg|jpeg)$/i",$r[thumb]) ? $article[thumb] : PHPCMS_PATH.'images/focus.jpg';
		if($k)
		{
			$flash_pics.="+\"|\"+imgUrl".$k;
			$flash_links.="+\"|\"+imgLink".$k;
			$flash_texts.="+\"|\"+imgtext".$k;
		}
		$k++;
		$articles[]=$article;
	}
	if(!count($articles))
	{
		$articles[0][thumb] = $js_path.PHPCMS_PATH.'images/nopic.gif';
		$articles[0][url]= '#';
		$articles[0][title] = '';
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_slidepicarticle";
	include template('article',$templateid);
}

function relatedarticle($templateid,$channelid,$keywords,$articleid=0,$articlenum=10,$titlelen=50,$datetype=1)
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
	$result=$db->query("SELECT articleid,catid,title,includepic,titlefontcolor,titlefonttype,showcommentlink,linkurl,author,hits,thumb,username,addtime,edittime,ontop,elite FROM ".TABLE_ARTICLE." WHERE channelid=$channelid and status=3 and recycle=0 and articleid!='$articleid' and ($sql) ORDER BY ontop DESC,articleid DESC limit 0,$articlenum ","CACHE");
	while($r=$db->fetch_array($result))
	{
		$article = $r;
		$p->set_catid($r[catid]);
		$article[adddate] = $datetype ? date($datetypes[$datetype],$r[addtime]) : '';
		$article[url] = $article[linkurl] ? $article[linkurl] : $js_path.$p->get_itemurl($r[articleid],$r[addtime]);
		$length = ($titlelen && $r[includepic]) ? $titlelen-6 : $titlelen;
		$article[title] = wordscut($r[title],$length,1);
		$article[title] = titleformat($article[title],$r[titlefontcolor],$r[titlefonttype],$r[includepic]);
		$article[catname] = "[<a href=\"".$js_path.$p->get_listurl(0)."\" target=\"_blank\" class=\"tag_cat_link\">".$_CAT[$r[catid]][catname]."</a>]";
		$articletype = $r[elite] ? 'elite' : ($r[ontop] ? 'ontop' : 'common');
		$article[img] = "<img src=\"".$js_path.PHPCMS_PATH."images/article_".$articletype.".gif\" border=\"0\"  alt=\"\" />";
		$article[alt] = $r[title];
		$articles[]=$article;
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_relatedarticle";
	include template('article',$templateid);
}
?>