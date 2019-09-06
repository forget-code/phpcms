<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$head['title'] = "合租信息搜索";
$head['keywords'] ="合租信息搜索,".$MOD['seo_keywords'];
$head['description'] = "合租信息搜索,".$MOD['seo_description'];

if(isset($keywords) && $keywords)
{
	$keywords = strip_tags(trim($keywords));
	if(strlen($keywords)>50) showmessage($LANG['keyword_num_not_greater_than_50'], 'goback');
    $head['title'] = $keywords."-".$head['title'];
    $head['keywords'] .= ",".$keywords;
    $head['description'] .= ",".$keywords;
}

$searchtype = isset($searchtype) ? intval($searchtype) : 1;
$areaid = isset($areaid) ? intval($areaid) : 0;
$propertytype = isset($propertytype) ? intval($propertytype) : 0;
$fromprice = isset($fromprice) ? floatval($fromprice) : 0;
$toprice = isset($toprice) ? floatval($toprice) : 0;
$isinter = isset($isinter) ? intval($isinter) : 0;
$ordertype = isset($ordertype) ? intval($ordertype) : 0;
$notshow = isset($notshow) ? intval($notshow) : 0;
$search = isset($search) ? intval($search) : 0;
$page = isset($page) ? intval($page) : 1;
$publishtime = isset($publishtime) ? intval($publishtime) : 0;
$havehouse = isset($havehouse) ? intval($havehouse) : -1;
$yourgender = isset($yourgender) ? intval($yourgender) : 0;
$pages = '';
$yesnumber = $nonumber = 0;

if($search)
{
	if($PHPCMS['searchtime'])
	{
		$searchtime = getcookie('searchtime');
		if($PHPCMS['searchtime'] > $PHP_TIME - $searchtime && ($yespage<2||$nopage<2)) showmessage($LANG['search_time_not_less_than'].$PHPCMS['searchtime'].$LANG['second'] ,'goback');
		mkcookie('searchtime',$PHP_TIME);
	}
	$ordertypes = array('listorder DESC, h.houseid DESC', 'price DESC', 'price ASC','buildarea DESC','buildarea ASC','addtime DESC','addtime ASC', 'hits DESC', 'hits ASC');
	if($ordertype<0 || $ordertype>9) $ordertype = 0;
	
	$pagesize = $PHPCMS['searchperpage'];
	$maxsearchresults = $PHPCMS['maxsearchresults'];
	$yespage = isset($yespage) ? intval($yespage) : 1;
	$yesoffset = ($yespage-1)*$pagesize;
	$yesoffset = $maxsearchresults > ($yesoffset + $pagesize) ? $yesoffset : ($maxsearchresults - $pagesize);

	$nopage = isset($nopage) ? intval($nopage) : 1;
	$nooffset = ($nopage-1)*$pagesize;
	$nooffset = $maxsearchresults > ($nooffset + $pagesize) ? $nooffset : ($maxsearchresults - $pagesize);

	$sql = '';
	if($keywords)
	{
		$keyword = str_replace(array(' ','*'),array('%','%'),$keywords);
		$sql.= " and name like '%$keyword%' or address like '%$keyword%' ";
	}
	if($publishtime)
	{
		$addtime = $PHP_TIME - $publishtime*86400;
		$sql .= " and addtime>$addtime " ;
	}

	if($fromprice) $sql .= " and price>$fromprice";
	if($toprice) $sql .= " and price<$toprice";
	$sql .= " and infocat=3";
	if($yourgender) $sql .= " and yourgender=$yourgender";
	if($isinter) $sql .= " and isinter=$isinter";
	if($areaid) $sql .= " and areaid=$areaid";	
	$yessearchs = array();
	$nosearchs = array();
	$yespages = $nopages = '';
	if($havehouse == 0 || $havehouse == -1)
	{
		$r = $db->get_one("SELECT count(h.houseid) as number FROM ".TABLE_HOUSE." h,".TABLE_HOUSE_COOP." c WHERE h.houseid=c.houseid AND h.status=1 AND c.havehouse=1 $sql");	
		$yesnumber = $r['number'];
		if($yesnumber)
		{
			$yespages = phppages($yesnumber, $yespage, $pagesize);		
			$result = $db->query("SELECT * FROM ".TABLE_HOUSE." h,".TABLE_HOUSE_COOP." c WHERE h.houseid=c.houseid AND h.status=1 AND c.havehouse=1 $sql ORDER BY $ordertypes[$ordertype] LIMIT $yesoffset,$pagesize");
			while($r = $db->fetch_array($result))
			{
				$r['addtime'] = date('Y-m-d', $r['addtime']);
				$r['areaname'] = $AREA[$r['areaid']]['areaname'];
				$r['linkurl'] = linkurl($r['linkurl']);
				$r['decorate'] = $DECORATES[$r['decorate']];
				$housetypearr = explode(",",$r['housetype']);
				$r['housetype'] = '';
				$stw = array('室','厅','卫','阳台');
				foreach ($housetypearr as $k=>$v)
				{
					$r['housetype'] .= $v=='不限' ? '' : $v.$stw[$k];
				}
				if($keywords)
				{
					$r['name'] = preg_replace('/'.$keywords.'/i','<span class="searchhighlight">'.$keywords.'</span>', $r['name']);
					$r['address'] = preg_replace('/'.$keywords.'/i','<span class="searchhighlight">'.$keywords.'</span>', $r['address']);
				}
				$yessearchs[] = $r;
			}
		}
	}

	if($havehouse == 1 || $havehouse == -1)
	{
		$r = $db->get_one("SELECT count(h.houseid) AS number FROM ".TABLE_HOUSE." h,".TABLE_HOUSE_COOP." c WHERE h.houseid=c.houseid AND h.status=1 $sql AND c.havehouse=0");	
		$nonumber = $r['number'];
		if($nonumber)
		{
			$nopages = phppages($nonumber, $nopage, $pagesize);		
			$query = "SELECT * from ".TABLE_HOUSE." h,".TABLE_HOUSE_COOP." c WHERE h.houseid=c.houseid AND h.status=1 $sql AND c.havehouse=0 ORDER BY $ordertypes[$ordertype] LIMIT $nooffset,$pagesize";
			$result = $db->query($query);
			while($r = $db->fetch_array($result))
			{
				$r['addtime'] = date('Y-m-d', $r['addtime']);
				$r['areaname'] = $AREA[$r['areaid']]['areaname'];
				$r['linkurl'] = linkurl($r['linkurl']);
				$housetypearr = explode(",",$r['housetype']);
				$r['housetype'] = '';
				$stw = array('室','厅','卫','阳台');
				foreach ($housetypearr as $k=>$v)
				{
					$r['housetype'] .= $v=='不限' ? '' : $v.$stw[$k];
				}
				if($keywords)
				{
					$r['name'] = preg_replace('/'.$keywords.'/i','<span class="searchhighlight">'.$keywords.'</span>', $r['name']);
					$r['address'] = preg_replace('/'.$keywords.'/i','<span class="searchhighlight">'.$keywords.'</span>', $r['address']);
				}
				$nosearchs[] = $r;
			}
		}	
	}
}
$number = $yesnumber+$nonumber;
if($fromprice == 0) $fromprice = '';
if($toprice == 0) $toprice = '';

include template($mod, 'search_coop');
?>