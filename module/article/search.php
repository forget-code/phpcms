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

require_once PHPCMS_ROOT."/module/article/common.php";
require_once PHPCMS_ROOT."/class/tree.php";
require_once PHPCMS_ROOT."/include/form_select.php";

$tree = new tree;

$meta_title = "站内".$channelname."搜索";
$meta_keywords = $channelname.",".$_PHPCMS['sitename'];
$meta_description = $channelname.",".$_PHPCMS['sitename'];

if(isset($keywords))
{
	$keywords = strip_tags($keywords);
    $meta_title = $keywords."-".$meta_title;
    $meta_keywords .= ",".$keywords;
    $meta_description .= ",".$keywords;
}

$cat_select = cat_select('catid','不限栏目',$catid);
$special_select = special_select($channelid,'specialid','不属于任何专题',$specialid);

$srchtypes = array("title","content","username","author");
$srchtype = in_array($srchtype,$srchtypes) ? $srchtype : "title";
$srchtypecheck[$srchtype] = "checked";

if($search)
{
	if($_PHPCMS['searchtime'])
	{
		$searchtime = getcookie('searchtime');
		if($_PHPCMS['searchtime'] > $timestamp - $searchtime) message('两次搜索时间间隔不得小于'.$_PHPCMS['searchtime'].'秒' ,'goback');
		mkcookie('searchtime',$timestamp);
	}
	if(strlen($keywords)>50) message('关键词不得超过50个字符！','goback');
	if(!$_PHPCMS['searchcontent'] && $srchtype=="content") message('抱歉，管理员关闭了全文搜索！','goback'); 

	$catid = intval($catid);
	$specialid = intval($specialid);
	$page = intval($page);
	$srchfrom = intval($srchfrom);
	$before = intval($before);

	$pagesize = $_PHPCMS['searchperpage'];
	$maxsearchresults = $_PHPCMS['maxsearchresults'];
	$page = $page ? $page : 1;
	$offset = ($page-1)*$pagesize;
	$offset = $maxsearchresults > ($offset + $pagesize) ? $offset : ($maxsearchresults - $pagesize);
    
	$sql = "";
	if($keywords)
	{
		$keyword = str_replace(array(' ','*'),array('%','%'),$keywords);
		$sql .= " and $srchtype like '%$keyword%' " ;
	}
	if($catid>0 && is_array($_CAT[$catid]))
	{
		$arrchildid = $_CAT[$catid]['arrchildid'];
		$sql .= $_CAT[$catid]['child'] ? " and catid in ($arrchildid) " : " and catid=$catid ";
	}
	$sql .= $specialid>0 ? " and specialid=$specialid " : "";
	if($srchfrom)
	{
		$sql .= $before ? " and addtime<($timestamp-$srchfrom*86400) " : " and addtime>($timestamp-$srchfrom*86400) " ;
	}
	$sql .= $elite ? " and elite=1 " : "";
	$sql .= $ontop ? " and ontop=1 " : "";
    $sql .= $date ? sql_time($date) : "";

	$ordertypes = array(" order by articleid desc "," order by articleid desc "," order by articleid "," order by hits desc "," order by hits ");
    $ordertype = intval($ordertype);
	$ordertype = ($ordertype >= 0 && $ordertype <= 4) ? $ordertype : 0;
    $sql .= $ordertypes[$ordertype];

	$r = $db->get_one("select count(*) as num from ".TABLE_ARTICLE." where status=3 and recycle=0 and channelid=$channelid","CACHE",86400);
	$totalnumber = $r["num"];
	$r = $db->get_one("select count(*) as num from ".TABLE_ARTICLE." where status=3 and recycle=0 and channelid=$channelid $sql");
	$number = $r["num"];

	$url = "?search=1&keywords=".urlencode($keywords)."&srchtype=".$srchtype."&catid=".$catid."&srchfrom=".$srchfrom."&before=".$before."&specialid=".$specialid."&elite=".$elite."&ontop=".$ontop."&ordertype=".$ordertype;
	$pages = phppages($number,$page,$pagesize,$url);

	if($number)
	{
		$k = $offset+1;
		$p->set_type('url');
		$result = $db->query("select articleid,catid,title,description,addtime,content from ".TABLE_ARTICLE." where status=3 and recycle=0 and channelid=$channelid $sql limit $offset,$pagesize");
		while($r = $db->fetch_array($result))
		{
			$r[title] = $k."、".$r[title];
			$r[description] = $r[description] ? wordscut(strip_tags($r[description]),500,1) : wordscut(strip_tags($r[content]),500,1);
			$p->set_catid($r[catid]);
			$r[url] = $p->get_itemurl($r[articleid],$r[addtime]);
			$r[adddate] = date("Y-m-d",$r[addtime]);
			if($keyword)
			{
				$r[title] = preg_replace('/'.$keyword.'/i','<span style="color:red">'.$keyword.'</span>',$r[title]);
				$r[description] = preg_replace('/'.$keyword.'/i','<span style="color:red">'.$keyword.'</span>',$r[description]);
			}
			$searchs[] = $r;
			$k++;
		}
	}
}

include template('article','search');
?>