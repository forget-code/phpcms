<?php 
require './include/common.inc.php';
require PHPCMS_ROOT."/include/formselect.func.php";
require PHPCMS_ROOT."/$mod/include/formselect.func.php";
require_once PHPCMS_ROOT."/include/tree.class.php";

$TYPE = cache_read('type_'.$mod.'.php');
$tree = new tree();
$head['title'] = $LANG['product_search'];
$head['keywords'] = $LANG['product_search'].",".$MOD['seo_keywords'];
$head['description'] = $LANG['product_search'].",".$MOD['seo_description'];
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
$notshow = isset($notshow) ? $notshow : 0;
$search = isset($search) ? intval($search) : 0;
$catid = isset($catid) ? intval($catid) : 0;
$searchfrom = isset($searchfrom) ? intval($searchfrom) : 0;
$before = isset($before) ? intval($before) : 0;
$typeid = isset($typeid) ? intval($typeid) : 0;
$ordertype = isset($ordertype) ? intval($ordertype) : 0;
$searchtype = isset($searchtype) ? trim($searchtype) : 'pdt_name';
$category_select = category_select('catid', $LANG['select_category'], $catid);
$subtype_select = type_select('typeid',$LANG['select_type'], $typeid);
$brand_select = brand_select('brand_id',0,0,$LANG['select_brand'],'','Id');
$fromprice = isset($fromprice) ? $fromprice : '';
$toprice = isset($toprice) ? $toprice : '';
$frommarketprice = isset($frommarketprice) ? $frommarketprice : '';
$tomarketprice = isset($tomarketprice) ? $tomarketprice : '';
$sales = isset($sales) ? $sales : '';
$keyword = '';
$pages = '';

if($search)
{
	if($PHPCMS['searchtime'])
	{
		$searchtime = getcookie('searchtime');
		if($PHPCMS['searchtime'] > $PHP_TIME - $searchtime) showmessage($LANG['search_time_not_less_than'].$PHPCMS['searchtime'].$LANG['second'] ,'goback');
		mkcookie('searchtime',$PHP_TIME);
	}
	$ordertypes = array('listorder DESC, productid DESC', 'productid DESC', 'productid ASC', 'hits DESC', 'hits ASC');
	$searchtypes = array('pdt_name','pdt_No', 'introduce');
	if($catid && !array_key_exists($catid, $CATEGORY)) $catid = 0;
	if($ordertype<0 || $ordertype>5) $ordertype = 0;
	$searchtype = in_array($searchtype, $searchtypes) ? $searchtype : 'pdt_name';

	$pagesize = $PHPCMS['searchperpage'];
	$maxsearchresults = $PHPCMS['maxsearchresults'];
	$page = isset($page) ? intval($page) : 1;
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
	if($searchfrom)
	{
		$addtime = $PHP_TIME-$searchfrom*86400;
		$sql .= $before ? " and addtime<$addtime " : " and addtime>$addtime " ;
	}
	if($typeid) $sql .= " and subtype=$typeid ";
	if(isset($brand_id) && !empty($brand_id)) $sql .= " and brand_id = '$brand_id' ";
	if($fromprice!='') $sql .= " and price>".floatval($fromprice);
	if($toprice!='') $sql .= " and price<".floatval($toprice);
	if($frommarketprice!='') $sql .= " and marketprice>".floatval($frommarketprice);
	if($tomarketprice!='') $sql .= " and marketprice<".floatval($tomarketprice);
	if($sales) $sql .= " and sales>".intval($sales);
	
	$query = "select count(*) as number from ".TABLE_PRODUCT." where disabled=0 $sql";
	$r = $db->get_one($query);	
	$number = $r['number'];
	
	$searchs = array();
	if($number)
	{
		$pages = phppages($number, $page, $pagesize);		
		$query = "select productid,pdt_name,price,addtime,introduce,linkurl,pdt_img from ".TABLE_PRODUCT." where disabled=0 $sql order by $ordertypes[$ordertype] limit $offset,$pagesize";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$r['addtime'] = date('Y-m-d', $r['addtime']);
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['introduce'] = str_cut(strip_tags($r['introduce']),$MOD['searchintroducenum']);
			if($keyword)
			{
				$r['pdt_name'] = preg_replace('/'.$keyword.'/i','<span class="searchhighlight">'.$keyword.'</span>', $r['pdt_name']);
				$r['introduce'] = preg_replace('/'.$keyword.'/i','<span class="searchhighlight">'.$keyword.'</span>', $r['introduce']);
			}
			$searchs[] = $r;
		}
	}	
}
include template($mod, 'search');
?>