<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT."/module/".$mod."/include/common.inc.php";
require PHPCMS_ROOT."/include/formselect.func.php";
require_once PHPCMS_ROOT."/include/tree.class.php";
require PHPCMS_ROOT.'/include/field.class.php';

$tree = new tree();
$head['title'] = $LANG['site'].$channelname.$LANG['search'];
$head['keywords'] = $channelname.",".$PHPCMS['seo_keywords'];
$head['description'] = $channelname.",".$PHPCMS['seo_description'];
$TYPE = cache_read('type_'.$channelid.'.php');
if(isset($keywords) && !empty($keywords))
{
	$keywords = str_safe(strip_tags(trim($keywords)));
	if(!$keywords) showmessage($LANG['empty_keywords'], 'goback');
	if(strlen($keywords)>50) showmessage($LANG['keywords_too_long'], 'goback');
    $head['title'] = $keywords."-".$head['title'];
    $head['keywords'] .= ",".$keywords;
    $head['description'] .= ",".$keywords;
}
else
{
	$keywords = '';
}

$search = isset($search) ? 1 : 0;
$catid = isset($catid) ? intval($catid) : 0;
$typeid = isset($typeid) ? intval($typeid) : 0;
$fromdate = isset($fromdate) && preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $fromdate) ? $fromdate : '';
$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
$todate = isset($todate) && preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $todate) ? $todate : '';
$totime = $todate ? strtotime($todate.' 23:59:59') : 0;

$ordertype = isset($ordertype) ? intval($ordertype) : 0;
$searchtype = isset($searchtype) ? trim($searchtype) : 'title';
if($MOD['storage_mode'] == 3 && $searchtype == 'content') $searchtype = 'introduce';
$page = isset($page) ? intval($page) : 1;
$category_select = category_select('catid', $LANG['please_select'], $catid);
$special_select = '';
$keyword = '';
$pages = '';
$tablename = channel_table('article', $channelid);
$tablename_data = channel_table('article_data', $channelid);
$field = new field($tablename);

if($search)
{
	if($PHPCMS['searchtime'])
	{
		$searchtime = getcookie('searchtime');
		if($PHPCMS['searchtime'] > $PHP_TIME - $searchtime && $page == 1) showmessage($LANG['search_refuse'].$PHPCMS['searchtime'].$LANG['seconds'] ,'goback');
		mkcookie('searchtime',$PHP_TIME);
	}
	if(!$PHPCMS['searchcontent'] && $searchtype=='content') showmessage($LANG['full_index_closed'],'goback'); 

	$ordertypes = array('listorder DESC, articleid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
	$searchtypes = array('title', 'keywords', 'introduce', 'content', 'username', 'author');
	if($catid && !array_key_exists($catid, $CATEGORY)) $catid = 0;
	if($ordertype<0 || $ordertype>6) $ordertype = 0;
	$searchtype = in_array($searchtype, $searchtypes) ? $searchtype : 'title';

	$pagesize = $PHPCMS['searchperpage'];
	$maxsearchresults = $PHPCMS['maxsearchresults'];
	$offset = ($page-1)*$pagesize;
	$offset = $maxsearchresults > ($offset + $pagesize) ? $offset : ($maxsearchresults - $pagesize);

	$sql = '';
	if($keywords)
	{
		$keyword = str_replace(array(' ','*'),array('%','%'),$keywords);
		$sql .= " and $searchtype like '%$keyword%' " ;
	}
	
	if($catid)
	{
		$sql .=  $CATEGORY[$catid]['child'] ? " and catid in({$CATEGORY[$catid]['arrchildid']}) " : " and catid = $catid ";
	}
	if($typeid) $sql .= " and typeid=$typeid ";
	if($fromtime) $sql .= " and addtime>$fromtime ";
	if($totime) $sql .= " and addtime<$totime ";
	$sql .= $field->get_searchsql();
	if($searchtype == 'content')
	{
		$sql = str_replace('and ', 'and a.', $sql);
		$sql = str_replace('a.content', 'd.content', $sql);
		$query = "select count(*) as number from ".$tablename." a, $tablename_data d where a.articleid=d.articleid and a.status=3 $sql";
		$result = $db->query($query);
		$r = $db->fetch_array($result);
	}
	else
	{
		$query = "select count(*) as number from $tablename where status=3 $sql";
		$r = $db->get_one($query);
	}
	$number = $r['number'];
	$searchs = array();
	if($number)
	{
		$pages = phppages($number, $page, $pagesize);
		if($searchtype == 'content')
		{
			$ordertypes = array('a.listorder DESC, a.articleid DESC', 'a.articleid DESC', 'a.articleid ASC', 'a.hits DESC', 'a.hits ASC');
			$query = "select a.articleid,a.title,a.addtime,a.introduce,a.linkurl,a.typeid,d.content from $tablename a, $tablename_data d where a.articleid=d.articleid and a.status=3 $sql order by $ordertypes[$ordertype] limit $offset,$pagesize";
		}
		else
		{
			$query = "select articleid,title,addtime,introduce,linkurl,typeid from $tablename where status=3 $sql order by $ordertypes[$ordertype] limit $offset,$pagesize";
		}
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$r['adddate'] = date('Y-m-d', $r['addtime']);
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['introduce'] = str_cut(strip_tags($r['introduce']), 300, '...');
			$r['type'] = show_type($channelid, $r['typeid']);
			if($keyword)
			{
				$r['title'] = preg_replace('/'.$keyword.'/i','<span class="searchhighlight">'.$keyword.'</span>', $r['title']);
				$r['introduce'] = preg_replace('/'.$keyword.'/i','<span class="searchhighlight">'.$keyword.'</span>', $r['introduce']);
			}
			$searchs[] = $r;
		}
	}
}
$searchform = $field->get_searchform('<tr><td class="search_l">$title</td><td class="search_r">$input</td></tr>');
include template($mod, 'search');
?>