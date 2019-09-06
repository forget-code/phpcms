<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT."/module/".$mod."/include/common.inc.php";
require PHPCMS_ROOT."/include/formselect.func.php";
require_once PHPCMS_ROOT."/include/tree.class.php";
require PHPCMS_ROOT.'/include/field.class.php';

$tree = new tree();
$head['title'] = $LANG['website'].$channelname.$LANG['search'];
$head['keywords'] = $channelname.",".$PHPCMS['seo_keywords'];
$head['description'] = $channelname.",".$PHPCMS['seo_description'];
$TYPE = cache_read('type_'.$channelid.'.php');
if(isset($keywords) && !empty($keywords))
{
	$keywords = str_safe(strip_tags(trim($keywords)));
	if(!$keywords) showmessage($LANG['keywords_not_empty'], 'goback');
	if(strlen($keywords)>50) showmessage($LANG['most_characters'], 'goback');
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
$page = isset($page) ? intval($page) : 1;
$category_select = category_select('catid', $LANG['choose_category'], $catid);
$special_select = '';
$keyword = '';
$pages = '';
$tablename = channel_table('movie', $channelid);
$field = new field($tablename);

if($search)
{
	if($PHPCMS['searchtime'])
	{
		$searchtime = getcookie('searchtime');
		if($PHPCMS['searchtime'] > $PHP_TIME - $searchtime && $page == 1) showmessage($LANG['least_time'].$PHPCMS['searchtime'].$LANG['seconds'] ,'goback');
		mkcookie('searchtime',$PHP_TIME);
	}
	if(!$PHPCMS['searchcontent'] && $searchtype=='content') showmessage($LANG['managers_closed_search'],'goback'); 

	$ordertypes = array('listorder DESC, movieid DESC', 'edittime DESC', 'edittime ASC', 'totalmovies DESC', 'totalmovies ASC', 'comments DESC', 'comments ASC');
	$searchtypes = array('title', 'introduce', 'username', 'letter');
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
	$query = "select count(*) as number from $tablename where status=3 $sql";
	$r = $db->get_one($query);
	$number = $r['number'];
	$searchs = array();
	if($number)
	{
		$pages = phppages($number, $page, $pagesize);
		$query = "select movieid,title,addtime,introduce,linkurl from $tablename where status=3 $sql order by $ordertypes[$ordertype] limit $offset,$pagesize";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$r['adddate'] = date('Y-m-d', $r['addtime']);
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['introduce'] = str_cut(strip_tags($r['introduce']), 300, '...');
			$r['type'] = show_type($channelid, $r['typeid']);
			if($keyword)
			{
				$r['title'] = preg_replace('/'.$keyword.'/i','<font color="#ff0000">'.$keyword.'</font>', $r['title']);
				$r['introduce'] = preg_replace('/'.$keyword.'/i','<font color="#ff0000">'.$keyword.'</font>', $r['introduce']);
			}
			$searchs[] = $r;
		}
	}
}
$searchform = $field->get_searchform('<tr><td class="search_l">$title</td><td class="search_r">$input</td></tr>');
include template($mod, 'search');
?>