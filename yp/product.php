<?php
require './include/common.inc.php';
require_once MOD_ROOT.'/include/company.class.php';
$readproid = get_cookie('readproid');
if(intval($readproid)) $prowhere = intval($readproid);
$template = 'product';
$where = '';
$catid = intval($catid);
if($head['title'])$head['title'] .= '_';
if($catid)
{
	$CSEO = cache_read('category_'.$catid.'.php');
	extract($CSEO);
	$head['title'] .= $meta_title.'_';
	$head['keywords'] = $meta_keywords.'_';
	$head['description'] = $meta_description.'_';	
}
switch($action)
{
	case 'show':
		require_once MOD_ROOT.'include/yp.class.php';
		require_once MOD_ROOT.'include/company.class.php';
		$company = new company();
		$yp = new yp();
		$productid = intval($id);
		if(!$productid) exit('非法参数');
		$yp->set_model('product');
		$yp->hits($id);
		cache_page_start();
		$rs = $yp->get($productid);
		if($rs['status'] != 99) showmessage('信息正在审核中...');
		$head['keywords'] .= $rs['keywords'].'_产品';
		$head['description'] .= $rs['title'].'_产品'.'_'.$PHPCMS['sitename'];
		$head['title'] .= $rs['title'].'_产品'.'_'.$PHPCMS['sitename'];
		$c = $company->get($rs['userid']);
		if(intval($readproid))
		{
			$readproid = $productid.','.$readproid;
			$tmp = explode(",",$readproid);
			$tmp = array_unique($tmp);
			while(count($tmp) > 10)array_pop($tmp);
			$readproid = implode(",",$tmp);
		}
		else $readproid = $productid;
		set_cookie('readproid',$readproid,time()+3600*365*24);
		$templateid = 'product_show';
	break;
	
	case 'search':
		$head['keywords'] .= '产品搜索';
		$head['description'] .= '产品搜索'.'_'.$PHPCMS['sitename'];
		$head['title'] .= '产品搜索'.'_'.$PHPCMS['sitename'];
		$CAT = subcat('yp', 0);
		$templateid = 'product_search';
	break;
	
	case 'searchlist':
		$head['keywords'] .= '产品搜索结果';
		$head['description'] .= '产品搜索结果'.'_'.$PHPCMS['sitename'];
		$head['title'] .= '产品搜索结果'.'_'.$PHPCMS['sitename'];
		$page = $page?$page:1;
		$catid = intval($catid);
		$q = addslashes(htmlspecialchars($q));
		$areaname = addslashes(htmlspecialchars($areaname));
		$lprice = intval($lprice);
		$hprice = intval($hprice);
		if($catid)
		{
			$c= new company();
			$r = $c->get_yp_arrchildid($catid);
			if($r['arrchildid'])$r['arrchildid'] = $catid.','.$r['arrchildid'];
			else $r['arrchildid'] = $catid;
			$where .= "p.catid IN ($catid) AND ";
		}
		if($lprice)$where .= "p.price >= '{$lprice}' AND ";
		if($hprice)$where .= "p.price <= '{$hprice}' AND ";
		if($areaname)$where .= "c.areaname = '{$areaname}' AND ";
		if($q)$where .= "p.title LIKE '%{$q}%' AND ";
		$where .= "c.userid = p.userid";
		$templateid = 'product_searchlist';
	break;
	
	default:
		$catid = intval($catid);
		$head['keywords'] .= '产品';
		$head['description'] .= '产品'.'_'.$PHPCMS['sitename'];
		$head['title'] .= '产品'.'_'.$PHPCMS['sitename'];
		$CAT = subcat('yp', 0);
		if($catid)
		{
			if($child == 1) $arrchildid = subcat('yp', $catid);
		}
		$view_type = max(intval($view_type), 1);
		$page = $page ? $page : 1;
		$pagesize = $pagesize ? intval($pagesize) : 20;
		$where = " WHERE p.userid=c.userid AND p.status=99";
		if($catid)
		{
			if($CATEGORY[$catid]['arrchildid'])
				$where .= " AND p.catid IN (".$CATEGORY[$catid]['arrchildid'].")";
			else
				$where .= " AND p.catid='$catid'";
		}
		if($areaname)
		{
			$areaname = htmlspecialchars(filter_xss($areaname));
			if(strpos(',',$areaname)===false)
			{
				$where .= " AND c.areaname='$areaname'";
			}
			else
			{
				$where .= " AND c.areaname IN ($areaname)";
			}
			$areaname = urlencode($areaname);
		}
		else
		{
			$areaname = 0;
		}
		if(isset($order))
		{
			$order = intval($order);
			$orderby = $order ? 'ASC' : 'DESC';
			$sql = "SELECT * FROM `".DB_PRE."yp_product` p,`".DB_PRE."member_company` c $where ORDER BY p.price {$orderby}";
		}
		else
		{
			$sql = "SELECT * FROM `".DB_PRE."yp_product` p,`".DB_PRE."member_company` c $where ORDER BY p.id DESC";
		}
		$templateid = 'product';
		if($M['enable_rewrite'])
		{
			$urlrule = "$M[url]product-list-$view_type-$catid-$pagesize--$areaname--$order.html|$M[url]product-list-$view_type-$catid-$pagesize--$areaname--$order-\$page.html";
		}
		else
		{
			$urlrule = "$M[url]product.php?view_type=$view_type&catid=$catid&pagesize=$pagesize&areaname=$areaname&order=$order|$M[url]product.php?view_type=$view_type&catid=$catid&pagesize=$pagesize&areaname=$areaname&order=$order&page=\$page";
		}
	break;
}

include template('yp', $templateid);
cache_page(intval($M['cache_list']));
?>