<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$searchtype = isset($searchtype) ? $searchtype : 1;
if(!in_array($searchtype,array(1,2,4,5,6))) showmessage("非法类别参数，请重新选择！");

$areaid = isset($areaid) ? $areaid : 0;
$type1p = isset($type1p) ? $type1p : 0;
$type2p = isset($type2p) ? $type2p : 0;
$type3p = isset($type3p) ? $type3p : 0;
$isinter = isset($isinter) ? $isinter : 0;
$propertytype = isset ($propertytype) ? $propertytype : 0;
$decorate = isset($decorate) ? $decorate : 0;
$towards = isset($towards) ? $towards : 0;
$fromprice = isset($fromprice) ? $fromprice : 0;
$toprice = isset($toprice) ? $toprice : 0;
if(isset($keywords))
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

if(isset($keywords))
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
$ordertype = isset($ordertype) ? intval($ordertype) : 0;
$search = isset($search) ? intval($search) : 0;
$page = isset($page) ? intval($page) : 1;
$publishtime = isset($publishtime) ? $publishtime:0;
$pages = '';

if($search)
{	
	if($PHPCMS['searchtime'])
	{
		$searchtime = getcookie('searchtime');
		if($PHPCMS['searchtime'] > $PHP_TIME - $searchtime && $page<2) showmessage($LANG['search_time_not_less_than'].$PHPCMS['searchtime'].$LANG['second'] ,'goback');
		mkcookie('searchtime',$PHP_TIME);
	}
	$ordertypes = array('listorder DESC, houseid DESC', 'price DESC', 'price ASC','area DESC','area ASC','addtime DESC','addtime ASC', 'hits DESC', 'hits ASC');
	if($ordertype < 0 || $ordertype > 9) $ordertype = 0;
	
	$pagesize = $PHPCMS['searchperpage'];
	$maxsearchresults = $PHPCMS['maxsearchresults'];
	
	$offset = ($page-1)*$pagesize;
	$offset = $maxsearchresults > ($offset + $pagesize) ? $offset : ($maxsearchresults - $pagesize);

    $fromprice = floatval($fromprice);
	$toprice = floatval($toprice);
    $infocat = intval($infocat);
	$isinter = intval($isinter);
    $areaid = intval($areaid);
	$propertytype = intval($propertytype);
    $decorate = intval($decorate);
	$towards = intval($towards);
	$publishtime = intval($publishtime);
    if($infocat<1 || $infocat>6) $infocat = 1;
	$sql = '';
	if($keywords)
	{
		$keyword = str_replace(array(' ','*'),array('%','%'),$keywords);
		$sql .= " and name like '%$keyword%' or address like '%$keyword%' ";
	}
	if($publishtime)
	{
		$addtime = $PHP_TIME-$publishtime*86400;
		$sql .= " and addtime>$addtime " ;
	}
	if($fromprice) $sql .= " and price>$fromprice";
	if($toprice) $sql .= " and price<$toprice";	
	if($infocat) $sql .= " and infocat=$infocat";	
	if($isinter) $sql .= " and isinter=$isinter";
	if($areaid) $sql .= " and areaid=$areaid";
	if($propertytype) $sql .= " and propertytype=$propertytype";
	if($decorate) $sql .= " and decorate=$decorate";
	if($towards) $sql .= " and towards=$towards";
	$housetype = $type1p ? $type1p.',' : '%,';
	$housetype .= $type2p ? $type2p.',' : '%,';
	$housetype .= $type3p ? $type3p.',' : '%,';
	$housetype .= $type4p ? $type4p : '%';
	$sql .= $housetype == '%,%,%,%' ? '' : " AND housetype LIKE '$housetype'";
	$r = $db->get_one("SELECT count(houseid) AS number FROM ".TABLE_HOUSE." WHERE status=1 $sql");	
	$number = $r['number'];
	$searchs = array();
	if($number)
	{
		$pages = phppages($number, $page, $pagesize);		
		$decorates = array_flip($PARS['decorate']);
		$result = $db->query("select * from ".TABLE_HOUSE." where status=1 $sql order by $ordertypes[$ordertype] limit $offset,$pagesize");
		while($r = $db->fetch_array($result))
		{
			$r['addtime'] = date('Y-m-d', $r['addtime']);
			$r['decoratename'] = $r['decorate'] ? $decorates[$r['decorate']] : '';
			$r['areaname'] = $r['areaid']?$AREA[$r['areaid']]['areaname']:'';
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['infocatname'] = $PARS['infotype']['type_'.$r['infocat']];
			$housetypearr = explode(',', $r['housetype']);
			$r['housetype'] = '';
			$stw = array('室','厅','卫','阳台');
			foreach($housetypearr as $k=>$v)
			{
				$r['housetype'] .= $v=='不限' ? '' : $v.$stw[$k];
			}
			if($keywords)
			{
				$r['name'] = preg_replace('/'.$keywords.'/i','<span class="searchhighlight">'.$keywords.'</span>', $r['name']);
				$r['address'] = preg_replace('/'.$keywords.'/i','<span class="searchhighlight">'.$keywords.'</span>', $r['address']);
			}
			$searchs[] = $r;
		}
	}	
}

if($fromprice == 0) $fromprice = '';
if($toprice == 0) $toprice = '';

$head['title'] = "房产信息搜索";
$head['keywords'] ="房产信息搜索,".$MOD['seo_keywords'];
$head['description'] = "房产信息搜索,".$MOD['seo_description'];

include template($mod, 'search_house');
?>