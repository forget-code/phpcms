<?php
require './include/common.inc.php';
cache_page_start();
require_once MOD_ROOT.'/include/company.class.php';
$template = 'buy';
$readproid = get_cookie('readproid');
if(intval($readproid))$prowhere = $readproid;
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
	$company = new company();
	$yp = new yp();
	$buyid = intval($id);
	$yp->set_model('buy');
	$rs = $yp->get($id);
	$head['keywords'] .= $rs['title'].'_商机';
	$head['title'] .= $rs['title'].'_商机'.'_'.$PHPCMS['sitename'];
	$head['description'] .= $rs['title'].'_商机'.'_'.$PHPCMS['sitename'];
	if(!$rs || $rs['status'] != 99)showmessage('数据未通过审核或者已经被删除');
	$c = $company->get($rs['userid']);
	$templateid = 'buy_show';
	break;
	
	case 'search':
	$head['keywords'] .= '商机搜索';
	$head['description'] .= '商机搜索'.'_'.$PHPCMS['sitename'];
	$head['title'] .= '商机搜索'.'_'.$PHPCMS['sitename'];
	$CAT = subcat('yp', 0);
	$templateid = 'buy_search';
	break;
	
	case 'searchlist':
	$head['keywords'] .= '商机搜索结果';
	$head['description'] .= '商机搜索'.'_'.$PHPCMS['sitename'];
	$head['title'] .= '商机搜索结果'.'_'.$PHPCMS['sitename'];
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
		$where .= "b.catid IN ($catid) AND ";
	}
	if($lprice)$where .= "b.price >= '{$lprice}' AND ";
	if($hprice)$where .= "b.price <= '{$hprice}' AND ";
	if($areaname)
	{
		$areaname = htmlspecialchars($areaname);
		if(strpos(',',$areaname)===false)
		{
			$where .= " c.areaname='$areaname' AND";
		}
		else
		{
			$where .= " c.areaname IN ($areaname) AND";
		}
		$areaname = urlencode($areaname);
	}
	if($q)$where .= "b.title LIKE '%{$q}%' AND ";
	$where .= "c.userid = b.userid";
	$templateid = 'buy_searchlist';
	break;
	
	
	default:	
	$head['keywords'] .= '商机';
	$head['description'] .= '商机'.'_'.$PHPCMS['sitename'];
	$head['title'] .= '商机'.'_'.$PHPCMS['sitename'];
	
	$c= new company();
	$r = $c->get_yp_arrchildid($catid);
	if($r['arrchildid'])
	{
		$r['arrchildid'] = $catid.','.$r['arrchildid'];
	}
	else
	{
		$r['arrchildid'] = $catid;
	}
	if($CATEGORY[$catid])
	{
		$where .= "b.catid IN ({$r['arrchildid']})";
	}
	else
	{
		$where = 1;
	}
	$page = intval($page);
	if(!$page) $page = 1;
	if($areaname)
	{
		$areaname = addslashes(htmlspecialchars(urldecode($areaname)));
		$where .= " AND c.areaname = '{$areaname}'";
	}
	$pagesize = intval($pagesize);
	if(!$pagesize) $pagesize = 20;
	$viewtype = intval($viewtype);
	switch($view_type)
	{
		case 1:
		case 2:
		case 3:
		break;
		
		default:
		$view_type = 1;
		break;
	}

	switch($tid)
	{
		case '1':
		case '2':
		case '3':
		case '4':
		break;
		
		default:
		$tid = 0;
		break;
	}
	if($tid) $where .= " AND tid = '{$tid}'";
	if($order) $where .= " ORDER BY b.price ASC";
	else $where .= " ORDER BY b.price DESC";
	$templateid = 'buy';
	break;
}

include template('yp', $templateid);
cache_page(intval($M['cache_list']));
?>