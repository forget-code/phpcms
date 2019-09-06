<?php
require './include/common.inc.php';
require_once MOD_ROOT.'include/output.func.php';
if(!$action) $action = 'job';
$types = subtype('yp');
$template = 'job';
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
	case 'list':
	$catid = intval($catid);
	$head['keywords'] .= '职位列表';
	$head['title'] .= '职位列表'.'_'.$PHPCMS['sitename'];
	$head['description'] .= '职位列表'.'_'.$PHPCMS['sitename'];
	$templateid = 'job_list';
	if($inputtime)
	$time = time() - 3600*$inputtime*24;
	else $time = 0;
	if($time < 0 )$time = 0;
	$where = "j.updatetime >= '{$time}' ";
	$genre = urldecode($genre);
	if($station)$where .= "AND j.station = '{$station}' ";
	if($genre)$where .= "AND c.genre = '{$genre}' ";
	if(!trim($where))$where = '1';
	break;
	
	case 'searchlist':
	$head['keywords'] .= '人才招聘搜索结果';
	$head['description'] .= '人才招聘搜索结果'.'_'.$PHPCMS['sitename'];
	$head['title'] .= '人才招聘搜索结果'.'_'.$PHPCMS['sitename'];
	if($page<1)$page = 1;
	if($stype)
	{
		require_once MOD_ROOT.'include/apply.class.php';
		$apply = new apply();
		$rs = $apply->search_apply_result($q,$inputtime,$degree,$station,$workplace,$experience,$page);
		$pages = pages($rs['number'],$page,15);
	}
	else
	{
		require_once MOD_ROOT.'include/job.class.php';
		$job = new job();
		$rs = $job->search_job_result($q,$inputtime,$degree,$station,$workplace,$experience,$page);
		$pages = pages($rs['number'],$page,15);
	}
	$templateid = 'job_searchlist';
	break;
	
	case 'search':
	$head['keywords'] .= '人才招聘搜索';
	$head['description'] .= '人才招聘搜索'.'_'.$PHPCMS['sitename'];
	$head['title'] .= '人才招聘搜索'.'_'.$PHPCMS['sitename'];
	$templateid = 'job_search';
	break;
	
	case 'applylist';
	$head['keywords'] .= '简历列表';
	$head['description'] .= '简历列表'.'_'.$PHPCMS['sitename'];
	$head['title'] .= '简历列表'.'_'.$PHPCMS['sitename'];
	$templateid = 'job_applylist';	
	
	if($inputtime)
	$time = time() - 3600*$inputtime*24;
	else $time = 0;
	if($time < 0 )$time = 0;
	$where = "edittime >= '{$time}' ";
	$genre = urldecode($genre);
	if($experience)$where .= "AND experience >= '{$experience}' ";
	if($genre)$where .= "AND edulevel = '{$genre}' ";
	break;
	
	case 'show':
	$templateid = 'job_show';
	$jobid = intval($id);
	require_once MOD_ROOT.'include/yp.class.php';
	require_once MOD_ROOT.'include/company.class.php';
	$company = new company();
	$yp = new yp();
	$yp->set_model('job');
	$rs = $yp->get($jobid);
	$head['keywords'] .= $rs['keywords'].'_人才招聘';
	$head['description'] .= $rs['title'].'_人才招聘'.'_'.$PHPCMS['sitename'];
	$head['title'] .= $rs['title'].'_人才招聘'.'_'.$PHPCMS['sitename'];
	if(!$rs || $rs['status'] != '99')showmessage('数据未通过审核或者已经被删除');
	$c = $company->get($rs['userid']);
	break;
	
	default:
	$head['keywords'] .= '人才招聘';
	$head['description'] .= '人才招聘'.'_'.$PHPCMS['sitename'];
	$head['title'] .= '人才招聘'.'_'.$PHPCMS['sitename'];
	$templateid = 'job';	
	break;
}
include template('yp', $templateid);
?>