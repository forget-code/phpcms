<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$head['title'] = "新楼盘信息搜索";
$head['keywords'] = "新楼盘信息搜索,".$MOD['seo_keywords'];
$head['description'] = "新楼盘信息搜索,".$MOD['seo_description'];

if(isset($keywords) && $keywords)
{
	$keywords = strip_tags(trim($keywords));
	if(strlen($keywords)>50) showmessage($LANG['keyword_num_not_greater_than_50'], 'goback');
    $head['title'] = $keywords."-".$head['title'];
    $head['keywords'] .= ",".$keywords;
    $head['description'] .= ",".$keywords;
}
else
{
	$keywords = '';
}

$pages = '';

if($search)
{	
	if($PHPCMS['searchtime'])
	{
		$searchtime = getcookie('searchtime');
		if($PHPCMS['searchtime'] > $PHP_TIME - $searchtime  && $page<2) showmessage($LANG['search_time_not_less_than'].$PHPCMS['searchtime'].$LANG['second'] ,'goback');
		mkcookie('searchtime',$PHP_TIME);
	}
	
	$pagesize = $PHPCMS['searchperpage'];
	$maxsearchresults = $PHPCMS['maxsearchresults'];
	$page = isset($page) ? intval($page) : 1;
	$offset = ($page-1)*$pagesize;
	$offset = $maxsearchresults > ($offset + $pagesize) ? $offset : ($maxsearchresults - $pagesize);

	$startprice_from = floatval($startprice_from);
	$startprice_to = floatval($startprice_to);
	$avgprice_from = floatval($avgprice_from);
	$avgprice_to = floatval($avgprice_to);
	$areaid = intval($areaid);
	$propertytype = intval($propertytype);
	$ordertype = intval($ordertype);
	$ordertypes = array('listorder DESC, displayid DESC', 'avgprice DESC', 'avgprice ASC','area DESC','area ASC','addtime DESC','addtime ASC', 'hits DESC', 'hits ASC');
	if($ordertype < 0 || $ordertype > 9) $ordertype = 0;

	$sql = '';
	if($keywords)
	{
		$keyword = str_replace(array(' ','*'), array('%','%'), $keywords);
        if(!in_array($searchtype, array('0', 'name', 'address', 'develop'))) $searchtype = 'name';
		$sql.= $searchtype ? " and $searchtype like '%$keyword%' " : " and name like '%$keyword%' or address like '%$keyword%' or develop like '%$keyword%'";
	}
	if($startprice_from) $sql .= " and startprice>$startprice_from";
	if($startprice_to) $sql .= " and startprice<$startprice_to";
	if($avgprice_from) $sql .= " and avgprice>$avgprice_from";
	if($avgprice_to) $sql .= " and avgprice<$avgprice_to";	
	if($areaid) $sql .= " and areaid=$areaid";
    if($develop) $sql .= " and develop='$develop'";
	$r = $db->get_one("select count(displayid) as number from ".TABLE_HOUSE_DISPLAY." where status=1 $sql");	
	$number = $r['number'];
	$searchs = array();
	if($number)
	{
		$pages = phppages($number, $page, $pagesize);		
		$result = $db->query("select * from ".TABLE_HOUSE_DISPLAY." where status=1 $sql order by $ordertypes[$ordertype] limit $offset,$pagesize");
		while($r = $db->fetch_array($result))
		{
			$r['addtime'] = date('Y-m-d', $r['addtime']);
			$r['areaname'] = $AREA[$r['areaid']]['areaname'];
			$r['linkurl'] = linkurl($r['linkurl']);
			if($keywords)
			{
				$r['name'] = preg_replace('/'.$keywords.'/i','<span class="searchhighlight">'.$keywords.'</span>', $r['name']);
				$r['address'] = preg_replace('/'.$keywords.'/i','<span class="searchhighlight">'.$keywords.'</span>', $r['address']);
			}
			$searchs[] = $r;
		}
	}	
}

if($startprice_from == 0) $startprice_from = '';
if($startprice_to == 0) $startprice_to = '';
if($avgprice_from == 0) $avgprice_from = '';
if($avgprice_to == 0) $avgprice_to = '';

include template($mod, 'search_building');
?>