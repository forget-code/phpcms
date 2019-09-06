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

//栏目调用标签
function catlist($templateid,$channelid,$catid=0,$child=1,$showtype=0,$open=1)
{
	$display = $open ? '' : 'none';
	$templateid = $templateid ? $templateid : "tag_catlist";
	include template('phpcms',$templateid);
}

//专题列表调用标签
function speciallist($templateid,$channelid=1,$specialid=0,$page=0,$specialnum=50,$specialnamelen=50,$descriptionlen=100,$elite=0,$datenum=0,$showtype=0,$imgwidth=150,$imgheight=150,$cols=1)
{
	global $db,$p,$timestamp,$_CHA,$_CAT;
	if($channelid != $_CHA['channelid'])
	{
		@include PHPCMS_CACHEDIR."channel_".$channelid.".php";
		@include PHPCMS_CACHEDIR."category_".$channelid.".php";
		$_CHA = $_MYCHANNEL[$channelid];
		$_CAT = $_CATEGORY[$channelid];
		$p->urlpath($_CHA,$_CAT);
	}
	$width = ceil(100/$cols).'%';
	$p->set_type('url');
	$condition = '';
	$condition .= $specialid ? " AND specialid IN($specialid) " : "";
	$condition .= $elite ? " AND elite=1 " : "";
	$condition .= $datenum ? " AND addtime>$timestamp-86400*$datenum " : "";
	$offset = $page ? ($page-1)*$specialnum : 0;
	$limit = $specialnum ? ' LIMIT '.$offset.','.$specialnum : '';
	if($page && $specialnum)
	{
		$r=$db->get_one("SELECT count(*) AS number FROM ".TABLE_SPECIAL." WHERE closed=0 and channelid='$channelid' $condition ","CACHE");
		$dir= $p->get_specialurl()."/";
		$pages = specialpages($r[number],$page,$specialnum,$dir);//BUG
	}
	$result=$db->query("SELECT * FROM ".TABLE_SPECIAL." WHERE closed=0 and channelid='$channelid' $condition ORDER BY specialid DESC $limit ","CACHE");
	while($r=$db->fetch_array($result)){
		$r[adddate] = date('Y-m-d',$r[addtime]);
		$r[url] = (defined('JS_PATH') ? JS_PATH : "").$p->get_specialitemurl($r[specialid],$r[addtime]);
		$r[alt] = $r[specialname];
		$r[specialname] = $specialnamelen ? wordscut($r[specialname],$specialnamelen,1) : '';
		$r[introduce] = $descriptionlen ? wordscut($r[introduce],$descriptionlen,1) : '';
		$r[specialpic] = get_imgurl($r[specialpic]);
		$r[specialbanner] = get_imgurl($r[specialbanner]);
		$specials[] = $r;
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_speciallist";
	include template('phpcms',$templateid);
}

//专题幻灯片效果调用标签
function slidespecial($templateid,$channelid=1,$specialid=0,$specialnum=2,$specialnamelen=30,$elite=0,$datenum=0,$imgwidth=150,$imgheight=150,$timeout=5000,$effectid=-1)
{
	global $db,$p,$timestamp,$_CHA,$_CAT;
	if($channelid != $_CHA['channelid'])
	{
		@include PHPCMS_CACHEDIR."channel_".$channelid.".php";
		@include PHPCMS_CACHEDIR."category_".$channelid.".php";
		$_CHA = $_MYCHANNEL[$channelid];
		$_CAT = $_CATEGORY[$channelid];
		$p->urlpath($_CHA,$_CAT);
	}
	$condition = '';
	$condition .= $specialid ? " AND specialid IN($specialid) " : "";
	$condition .= $elite ? " AND elite=1 " : "";
	$condition .= $datenum ? " AND addtime>$timestamp-86400*$datenum " : "";
	$limit = $specialnum ? ' LIMIT 0,'.$specialnum : '';
	$result=$db->query("SELECT * FROM ".TABLE_SPECIAL." WHERE closed=0 and channelid='$channelid' $condition ORDER BY specialid DESC $limit","CACHE");
	$k=0;
	$flash_pics="imgUrl0";
	$flash_links="imgLink0";
	$flash_texts="imgtext0";
	while($r=$db->fetch_array($result))
	{
		$r[adddate] = date('Y-m-d',$r[addtime]);
		$p->set_type('url');
		$r[url] = (defined('JS_PATH') ? JS_PATH : "").$p->get_specialitemurl($r[specialid],$r[addtime]);
		$r[alt] = $r[specialname];
		$r[specialname] = wordscut($r[specialname],$specialnamelen,1);
		$r[specialpic] = get_imgurl($r[specialpic]);
		$r[flashpic] = preg_match("/\.(jpg|jpeg)$/i",$r['specialpic']) ? $r['specialpic'] : PHPCMS_PATH.'images/focus.jpg';
		if($k)
		{
			$flash_pics.="+\"|\"+imgUrl".$k;
			$flash_links.="+\"|\"+imgLink".$k;
			$flash_texts.="+\"|\"+imgtext".$k;
		}
		$k++;
		$specials[] = $r;
	}
	if(!count($specials))
	{
		$specials[0][specialpic] = PHPCMS_PATH.'images/nopic.gif';
		$specials[0][url]= '#';
		$specials[0][specialname] ='';
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_slidespecial";
	include template('phpcms',$templateid);
}

//友情链接调用标签
function linklist($templateid,$channelid,$linktype=0,$page=0,$sitenum=5,$cols=1) //友情链接
{
	global $db,$timestamp;
	$sites = array();
	$offset = $page ? ($page-1)*$sitenum : 0;
	$limit = $sitenum ? ' LIMIT '.$offset.','.$sitenum : '';
	if($page && $sitenum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_LINK." WHERE linktype=$linktype and passed=1 and channelid='$channelid' ","CACHE");
		$pages = phppages($r[number],$page,$sitenum,'?');
	}
	$result=$db->query("SELECT * FROM ".TABLE_LINK." WHERE linktype=$linktype AND passed=1 AND channelid='$channelid' ORDER BY elite DESC,`orderid` $limit","CACHE");
	while($r=$db->fetch_array($result))
	{
		$r[link] = $linktype ? "<img src=\"".$r[logo]."\"  width=\"88\" height=\"31\" border=\"0\" alt=\"网站名称：".$r[name]."&#10;网站介绍：".wordscut($r[introduction],100,1)."\" />" : $r[name] ;
		$sites[]=$r;
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_linklist";
	include template('link',$templateid);
}

//投票调用标签
function voteshow($templateid,$voteid=0,$channelid=0)
{
	global $db,$timestamp;
	$today = date("Y-m-d");
	if($voteid)
	{
	    $r = $db->get_one("select * from ".TABLE_VOTESUBJECT." where voteid=$voteid ");
	}
	else
	{
	    $r = $db->get_one("select * from ".TABLE_VOTESUBJECT." where channelid=$channelid and passed=1 order by voteid desc limit 0,1");
	}
	if(!$r[voteid]) return "";
	@extract($r);
	$voteoption = $type=="radio" ? "voteoption" : "voteoption[]";
	$result = $db->query("select * from ".TABLE_VOTEOPTION." where voteid=$voteid ");
	while($r = $db->fetch_array($result))
	{
		$ops[]=$r;
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_voteshow";
	include template('vote',$templateid);
}

//公告列表调用标签
function announcelist($templateid=0,$channelid=0,$page=0,$announcenum=10,$titlelen=30,$datetype=0,$showauthor=0,$target=0,$width=180,$height=100) {
	global $db,$timestamp;
	$datetypes = array('1'=>'Y-m-d','2'=>'m-d','3'=>'Y/m/d','4'=>'Y.m.d');
	$announces = array();
	$target = $target ? "_blank" : "_self";
	$offset = $page ? ($page-1)*$announcenum : 0;
	$limit = $announcenum ? ' LIMIT '.$offset.','.$announcenum : '';
	$today = date("Y-m-d");
	if($page)
	{
		$page = intval($page);
		$page = $page>0 ? $page : 1;
		$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_ANNOUNCEMENT." WHERE channelid=$channelid AND passed=1 AND (todate>='$today' OR todate='0000-00-00')");
		$url = "?channelid=".$channelid;
		$pages = phppages($r[number],$page,$announcenum,$url);
	}
	$result = $db->query("SELECT * FROM ".TABLE_ANNOUNCEMENT." WHERE channelid=$channelid AND passed=1 AND (todate>='$today' OR todate='0000-00-00') ORDER BY announceid DESC $limit ");
	while($r=$db->fetch_array($result))
	{
		$announce = $r;
		$announce[addtime] = $datetype ? date($datetypes[$datetype],$r[addtime]) : '';
		$announce[url] = (defined('JS_PATH') ? JS_PATH : "").PHPCMS_PATH."announce/show.php?announceid=".$r[announceid];
		$announce[alt] = $r[title];
		$announce[title] = $titlelen ? wordscut($r[title],$titlelen,1) : '';
		$announce[username] = $showauthor ? $r[username] : '';
		$announces[]=$announce;
	}
	unset($r);
	$db->free_result($result);
	$templateid = $templateid ? $templateid : "tag_announcelist";
	include template('announce',$templateid);
}

//单网页调用标签
function showdefinedpage($channelid=0)
{
	if(defined("IN_ADMIN"))
	{
		global $definedpage;
		$definedpage = $definedpage ? $definedpage : file_read(PHPCMS_CACHEDIR."definedpage_".$channelid.".php");
		return $definedpage;
	}
	else
	{
		@include PHPCMS_CACHEDIR."definedpage_".$channelid.".php";
	}
}

function user_itemstop($rowsnum=10)
{
	global $db;
	$i = 1;
	$result = $db->query("SELECT username,additems FROM  ".TABLE_MEMBER." ORDER BY additems DESC LIMIT 0,$rowsnum","CACHE",86400);
    while($r = $db->fetch_array($result))
    {
		$info .= "<li style=\"height:21px;border-bottom:#EEEEEE 1px solid;overflow:hidden;\"><span style=\"float:right;\">".$r['additems']."</span>".$i.".<a href=\"".PHPCMS_PATH."member/member.php?username=".urlencode($r['username'])."\">".$r['username']."</a></li>";
		$i++;
    }
	return $info;
}
?>