<?php
require './include/common.inc.php';
$searchtype = isset($searchtype) ? trim($searchtype) : 'article';
$arraytypes = array("article", "company", "product", "buy","sales");
if (!in_array($searchtype, $arraytypes))	showmessage($LANG['illegal_operation']);
$head['title'] = $LANG['search'].'-'.$MOD['seo_title'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];
require PHPCMS_ROOT."/include/formselect.func.php";
require_once PHPCMS_ROOT."/include/tree.class.php";
$tree = new tree();
require_once PHPCMS_ROOT.'/yp/include/trade.func.php';
if(isset($keyword))
{
	$keyword = strip_tags(trim($keyword));
	if(strlen($keyword)>50) showmessage($LANG['keyword_num_not_greater_than_50'], 'goback');
    if($keyword !='') $head['title'] = $keyword."-".$head['title'];
    $head['keywords'] .= ",".$keyword;
    $head['description'] .= ",".$keyword;
}
else
{
	$keyword = '';
}
$search = isset($search) ? intval($search) : 0;
$catid = isset($catid) ? intval($catid) : 0;
$tradeid = isset($tradeid) ? intval($tradeid) : 0;
$searchfrom = isset($searchfrom) ? intval($searchfrom) : 0;
$before = isset($before) ? intval($before) : 0;
$ordertype = isset($ordertype) ? intval($ordertype) : 0;

$fromprice = isset($fromprice) ? $fromprice : '';
$toprice = isset($toprice) ? $toprice : '';


$pages = '';
switch($searchtype)
{
	case 'article':
		$TRADE = cache_read('trades_article.php');
		$article_selected = trade_select('articlecatid',$LANG['select_category'],$articlecatid);
	break;
	case 'product':
		$category_select = category_select('catid', $LANG['select_category'], $catid);

	break;
	case 'company':
		$type_selected = "<select name='typeid' ><option value='0'>".$LANG['please_choose_company_type']."</option>";
		$types = explode("\n",$MOD['type']);
		foreach($types AS $t)
		{
			$selected = '';
			if($typeid==$t) $selected = 'selected';
			$type_selected .= "<option value='$t' $selected>$t</option>";
		}
		$type_selected .= "</select>";
		$AREA = cache_read('areas_'.$mod.'.php');
		require_once PHPCMS_ROOT.'/include/area.func.php';
		$TRADE = cache_read('trades_trade.php');
		$trade_selected = trade_select('tradeid',$LANG['please_choose_company_trade'],$tradeid);
	break;
	case 'buy':
		$TRADE = cache_read('trades_buy.php');
		$buy_selected = trade_select('tradeid',$LANG['select_category'],$tradeid);
	break;
	case 'sales':
		$TRADE = cache_read('trades_sales.php');
		$sales_selected = trade_select('tradeid',$LANG['select_category'],$tradeid);
	break;
}
if($search)
{
	if($PHPCMS['searchtime'])
	{
		$searchtime = getcookie('searchtime');
		if($PHPCMS['searchtime'] > $PHP_TIME - $searchtime) showmessage($LANG['search_time_not_less_than'].$PHPCMS['searchtime'].$LANG['second'] ,'goback');
		mkcookie('searchtime',$PHP_TIME);
	}
	if($ordertype<0 || $ordertype>5) $ordertype = 0;
	$pagesize = $PHPCMS['searchperpage'];
	$maxsearchresults = $PHPCMS['maxsearchresults'];
	$page = isset($page) ? intval($page) : 1;
	$offset = ($page-1)*$pagesize;
	$offset = $maxsearchresults > ($offset + $pagesize) ? $offset : ($maxsearchresults - $pagesize);

	$sql = '';
	
	if($searchfrom)
	{
		$addtime = $PHP_TIME-$searchfrom*86400;
		$sql .= $before ? " and addtime<$addtime " : " and addtime>$addtime " ;
	}

	switch($searchtype)
	{
		case 'article':
			if($keyword)
			{
				$keyword = str_replace(array(' ','*'),array('%','%'),$keyword);
				$sql .= " and title like '%$keyword%' " ;
			}
			$sql .= $articlecatid ? " AND catid='$articlecatid'" : '';
			$ordertypes = array('listorder DESC, articleid DESC', 'articleid DESC', 'articleid ASC', 'hits DESC', 'hits ASC');
			$query = "SELECT count(*) as number FROM ".TABLE_YP_ARTICLE." WHERE status>=3 $sql";
			$r = $db->get_one($query);	
			$number = $r['number'];
			
			$searchs = array();
			if($number)
			{
				$pages = phppages($number, $page, $pagesize);		
				$query = "SELECT articleid,title,addtime,content,linkurl,thumb FROM ".TABLE_YP_ARTICLE." WHERE status>=3 $sql order by $ordertypes[$ordertype] limit $offset,$pagesize";
				$result = $db->query($query);
				while($r = $db->fetch_array($result))
				{
					$r['addtime'] = date('Y-m-d', $r['addtime']);
					$r['introduce'] = str_cut(strip_tags($r['content']),200);
					if($keyword)
					{
						$r['title'] = preg_replace('/'.$keyword.'/i','<font color="#ff0000">'.$keyword.'</font>', $r['title']);
						$r['introduce'] = preg_replace('/'.$keyword.'/i','<font color="#ff0000">'.$keyword.'</font>', $r['introduce']);
					}
					$searchs[] = $r;
				}
			}	

		break;

		case 'product':
			if($keyword)
			{
				$keyword = str_replace(array(' ','*'),array('%','%'),$keyword);
				$sql .= " and title like '%$keyword%' " ;
			}
			$sql = $catid ? " AND catid='$catid'" : '';
			if($fromprice!='') $sql .= " and price>".floatval($fromprice);
			if($toprice!='') $sql .= " and price<".floatval($toprice);
			$ordertypes = array('listorder DESC, productid DESC', 'productid DESC', 'productid ASC', 'hits DESC', 'hits ASC');
			$query = "SELECT count(*) as number FROM ".TABLE_YP_PRODUCT." WHERE status>=3 $sql";
			$r = $db->get_one($query);	
			$number = $r['number'];
			
			$searchs = array();
			if($number)
			{
				$pages = phppages($number, $page, $pagesize);		
				$query = "SELECT productid,title,price,addtime,introduce,linkurl,thumb FROM ".TABLE_YP_PRODUCT." WHERE status>=3 $sql order by $ordertypes[$ordertype] limit $offset,$pagesize";
				$result = $db->query($query);
				while($r = $db->fetch_array($result))
				{
					$r['addtime'] = date('Y-m-d', $r['addtime']);
					$r['introduce'] = str_cut(strip_tags($r['introduce']),200);
					if($keyword)
					{
						$r['title'] = preg_replace('/'.$keyword.'/i','<font color="#ff0000">'.$keyword.'</font>', $r['title']);
						$r['introduce'] = preg_replace('/'.$keyword.'/i','<font color="#ff0000">'.$keyword.'</font>', $r['introduce']);
					}
					$searchs[] = $r;
				}
			}	

		break;

		case 'company':
			if($keyword)
			{
				$keyword = str_replace(array(' ','*'),array('%','%'),$keyword);
				$sql .= " and companyname like '%$keyword%' " ;
			}
			$sql .= $trade ? " AND trade='$trade'" :'';
			$areaid = intval($areaid);
			if($areaid) $sql .= " AND areaid='$areaid'";
			$ordertypes = array('listorder DESC, companyid DESC', 'companyid DESC', 'companyid ASC', 'hits DESC', 'hits ASC');
			$r = $db->get_one("SELECT count(*) as number FROM ".TABLE_MEMBER_COMPANY." WHERE status>=3 $sql");	
			$number = $r['number'];
			$searchs = array();
			if($number)
			{
				$pages = phppages($number, $page, $pagesize);		
				$query = "select companyid,companyname,addtime,introduce,linkurl from ".TABLE_MEMBER_COMPANY." where status>=3 $sql order by $ordertypes[$ordertype] limit $offset,$pagesize";
				$result = $db->query($query);
				while($r = $db->fetch_array($result))
				{
					$r['addtime'] = date('Y-m-d', $r['addtime']);
					$r['introduce'] = str_cut(strip_tags($r['content']),200);
					if($keyword)
					{

						$r['title'] = preg_replace('/'.$keyword.'/i','<font color="#ff0000">'.$keyword.'</font>', $r['companyname']);
						$r['introduce'] = preg_replace('/'.$keyword.'/i','<font color="#ff0000">'.$keyword.'</font>', $r['introduce']);
					}
					$searchs[] = $r;
				}
			}	

		break;
		case 'buy':
			if($keyword)
			{
				$keyword = str_replace(array(' ','*'),array('%','%'),$keyword);
				$sql .= " AND title LIKE '%$keyword%' " ;
			}
			$sql .= $trade ? " AND catid='$tradeid'" :'';
			$ordertypes = array('listorder DESC, productid DESC', 'productid DESC', 'productid ASC', 'hits DESC', 'hits ASC');
			$r = $db->get_one("SELECT count(*) as number FROM ".TABLE_YP_BUY." WHERE status>=3 $sql");	
			$number = $r['number'];
			$searchs = array();
			if($number)
			{
				$pages = phppages($number, $page, $pagesize);		
				$query = "SELECT productid,title,addtime,introduce,linkurl FROM ".TABLE_YP_BUY." WHERE status>=3 $sql ORDER BY $ordertypes[$ordertype] LIMIT $offset,$pagesize";
				$result = $db->query($query);
				while($r = $db->fetch_array($result))
				{
					$r['addtime'] = date('Y-m-d', $r['addtime']);
					$r['introduce'] = str_cut(strip_tags($r['introduce']),200);
					if($keyword)
					{

						$r['title'] = preg_replace('/'.$keyword.'/i','<font color="#ff0000">'.$keyword.'</font>', $r['title']);
						$r['introduce'] = preg_replace('/'.$keyword.'/i','<font color="#ff0000">'.$keyword.'</font>', $r['introduce']);
					}
					$searchs[] = $r;
				}
			}
		break;
		case 'sales':
			if($keyword)
			{
				$keyword = str_replace(array(' ','*'),array('%','%'),$keyword);
				$sql .= " AND title LIKE '%$keyword%' " ;
			}
			$sql .= $trade ? " AND catid='$tradeid'" :'';
			$ordertypes = array('listorder DESC, productid DESC', 'productid DESC', 'productid ASC', 'hits DESC', 'hits ASC');
			$r = $db->get_one("SELECT count(*) as number FROM ".TABLE_YP_SALES." WHERE status>=3 $sql");	
			$number = $r['number'];
			$searchs = array();
			if($number)
			{
				$pages = phppages($number, $page, $pagesize);		
				$query = "SELECT productid,title,addtime,introduce,linkurl FROM ".TABLE_YP_SALES." WHERE status>=3 $sql ORDER BY $ordertypes[$ordertype] LIMIT $offset,$pagesize";
				$result = $db->query($query);
				while($r = $db->fetch_array($result))
				{
					$r['addtime'] = date('Y-m-d', $r['addtime']);
					$r['introduce'] = str_cut(strip_tags($r['introduce']),200);
					if($keyword)
					{

						$r['title'] = preg_replace('/'.$keyword.'/i','<font color="#ff0000">'.$keyword.'</font>', $r['title']);
						$r['introduce'] = preg_replace('/'.$keyword.'/i','<font color="#ff0000">'.$keyword.'</font>', $r['introduce']);
					}
					$searchs[] = $r;
				}
			}	

		break;
	}
}
include template($mod, 'search_'.$searchtype);

?>