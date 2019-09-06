<?php
require './include/common.inc.php';
cache_page_start();
require_once MOD_ROOT.'/include/company.class.php';
$template = 'company';
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
	case 'search':
	$head['keywords'] .= '企业搜索';
	$head['title'] .= '企业搜索'.'_'.$PHPCMS['sitename'];
	$head['description'] .= '企业搜索'.'_'.$PHPCMS['sitename']; 
	$CAT = subcat('yp', 0);
	$templateid = 'company_search';
	break;
	
	case 'member':
	$company_user_infos = $db->get_one("SELECT * FROM `".DB_PRE."member_company` WHERE `userid`='$_userid'");
	if($company_user_infos)
	{
		showmessage("您已经是企业用户了",BUSINESSDIR);
	}
	else
	{
		$r = $db->get_one("SELECT modelid FROM `".DB_PRE."model` WHERE `tablename`='company' AND `modeltype` = 2");
		$db->query("UPDATE `".DB_PRE."member` SET modelid = '$r[modelid]' WHERE userid = '$_userid'");
		$db->query("UPDATE `".DB_PRE."member_cache` SET modelid = '$r[modelid]' WHERE userid = '$_userid'");
		$db->query("INSERT INTO `".DB_PRE."member_company` (`userid`) VALUES ('$_userid')");
		showmessage("您已成功升级为企业会员！",BUSINESSDIR.'?file=company&action=edit');
	}
	break;
	
	case 'searchlist':
	$head['keywords'] .= '企业搜索结果';
	$head['title'] .= '企业搜索结果'.'_'.$PHPCMS['sitename'];
	$head['description'] .= '企业搜索结果'.'_'.$PHPCMS['sitename'];
	$page = $page ? $page:1;
	$catid = intval($catid);
	$q = addslashes(htmlspecialchars($q));
	$genre = addslashes(htmlspecialchars($genre));
	$areaname = addslashes(htmlspecialchars($areaname));
	$where = '';
	if($catid)
	{
		$c= new company();
		$r = $c->get_yp_arrchildid($catid);
		if($r['arrchildid'])$r['arrchildid'] = $catid.','.$r['arrchildid'];
		else $r['arrchildid'] = $catid;
		$where .= "r.catid IN ($catid) AND ";
	}
	if($genre) $where .= "c.genre = '{$genre}' AND ";
	if($areaname) $where .= "c.areaname = '{$areaname}' AND ";
	if($q) $where .= "c.companyname LIKE '%{$q}%' AND ";
	$where .= "r.userid = c.userid AND c.status = 1";
	$templateid = 'company_searchlist';
	break;
	
	default:
	$templateid = 'company';
	$head['keywords'] .= '企业';
	$head['description'] .= '企业'.'_'.$PHPCMS['sitename'];
	$head['title'] .= '企业'.'_'.$PHPCMS['sitename'];
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
		$where .= "r.catid IN ({$r['arrchildid']})";
	}
	$page = intval($page);
	if(!$page)$page = 1;
	if($areaname)
	{
		$areaname = htmlspecialchars($areaname);
		if(strpos(',',$areaname)===false)
		{
			if($where)$where .= " AND c.areaname='$areaname'";
			else $where .= " c.areaname='$areaname'";
		}
		else
		{
			if($where)$where .= " AND c.areaname IN ($areaname)";
			else $where .= " c.areaname IN ($areaname)";
		}
		$areaname = urlencode($areaname);
	}
	if($where) $where .= " AND c.status = '1'";
	else $where = "c.status = '1'";
	$pagesize = intval($pagesize);
	if(!$pagesize) $pagesize = 20;
	switch($listtype)
	{
		case 'elite':
		$where .= " AND c.elite = 1";
		break;
		
		case 'new':
		$listtype = 'new';
		break;
		
		default:
		$listtype = "all";
		break;
	}
}

include template('yp',$templateid);
cache_page(intval($M['cache_list']));
?>