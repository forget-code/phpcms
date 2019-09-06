<?php
require './include/common.inc.php';
$action = isset($action) ? $action : '';
require_once PHPCMS_ROOT.'/include/tree.class.php';
$tree = new tree;
$AREA = cache_read('areas_'.$mod.'.php');
require_once PHPCMS_ROOT.'/include/area.func.php';
$stations_job = $stations_apply = array();
$string = explode("\n",$MOD['station']);
foreach($string AS $key=>$str)
{
	$r = $db->get_one("SELECT count(jobid) AS num FROM ".TABLE_YP_JOB." WHERE status>=3 AND station='$str'");
	$rs = $db->get_one("SELECT count(applyid) AS num FROM ".TABLE_YP_APPLY." WHERE status>=3 AND station='$str'");
	$stations_job[$key]['station'] = $stations_apply[$key]['station'] = $str;
	$stations_job[$key]['items'] = $r['num'];
	$stations_apply[$key]['items'] = $rs['num'];
}
switch($action)
{
	case 'job':
	
		include template($mod, 'job_list');
	break;

	case 'apply':
	
		include template($mod, 'apply_list');
	break;
	
	case 'jobstation':
		$pagesize = $PHPCMS['pagesize'];
		$page = empty($page) ? 1 : intval($page);
		$offset = ($page-1)*$pagesize;
		$station = trim($station);
		$condition = '';
		if(isset($station)) $condition = " AND station like '%$station%'";
		$r = $db->get_one("SELECT COUNT(jobid) AS num FROM ".TABLE_YP_JOB." WHERE status>=3 $condition");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$jobs = array();
		$result = $db->query("SELECT * FROM ".TABLE_YP_JOB." WHERE status>=3 $condition ORDER BY listorder LIMIT $offset,$pagesize");		
		while($r = $db->fetch_array($result))
		{
			$r['adddate'] = date("Y-m-d",$r['addtime']);
			$jobs[] = $r;
		}
		include template($mod, 'job_station');
	break;

	case 'applystation':
		$pagesize = $PHPCMS['pagesize'];
		$page = empty($page) ? 1 : intval($page);
		$offset = ($page-1)*$pagesize;
		$station = trim($station);
		$condition = '';
		if(isset($station)) $condition = " AND station like '%$station%'";	
		$r = $db->get_one("SELECT COUNT(applyid) AS num FROM ".TABLE_YP_APPLY." WHERE status>=3 $condition");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$applys = array();
		$result = $db->query("SELECT * FROM ".TABLE_YP_APPLY." WHERE status>=3 $condition ORDER BY listorder LIMIT $offset,$pagesize");		
		while($r = $db->fetch_array($result))
		{
			@extract($db->get_one("SELECT i.gender FROM ".TABLE_MEMBER." m, ".TABLE_MEMBER_INFO." i WHERE m.username='$r[username]' AND m.userid=i.userid"));
			$r['gender'] = $gender;
			$applys[] = $r;
		}
		include template($mod, 'apply_station');
	break;

	case 'search':
		if($PHPCMS['searchtime'])
		{
			$searchtime = getcookie('searchtime');
			if($PHPCMS['searchtime'] > $PHP_TIME - $searchtime) showmessage($LANG['search_time_not_less_than'].$PHPCMS['searchtime'].$LANG['second'] ,'goback');
			mkcookie('searchtime',$PHP_TIME);
		}
		if(isset($keyword))
		{
			$keyword = strip_tags(trim($keyword));
			if(strlen($keyword)>50) showmessage($LANG['keyword_num_not_greater_than_50'], 'goback');
			$head['title'] = $keyword."-".$head['title'];
			$head['keywords'] .= ",".$keyword;
			$head['description'] .= ",".$keyword;
		}
		else
		{
			$keyword = '';
		}
		$searchfrom = isset($searchfrom) ? intval($searchfrom) : 0;

		$pagesize = 1;
		$maxsearchresults = $PHPCMS['maxsearchresults'];
		$page = isset($page) ? intval($page) : 1;
		$offset = ($page-1)*$pagesize;
		$offset = $maxsearchresults > ($offset + $pagesize) ? $offset : ($maxsearchresults - $pagesize);
		$sql = '';
		if($keyword)
		{
			$keyword = str_replace(array(' ','*'),array('%','%'),$keyword);
			$sql .= " AND title LIKE '%$keyword%' " ;
		}
		if($searchfrom)
		{
			$edittime = $PHP_TIME-$searchfrom*86400;
			$sql .= " AND edittime>$edittime ";
		}
		$areaid = isset($areaid) ? intval($areaid) : 0;
		$sql .= $areaid ? " AND areaid=$areaid" : '';
		$query = "SELECT count(jobid) as number FROM ".TABLE_YP_JOB." WHERE status>=3 $sql";
		$r = $db->get_one($query);	
		$number = $r['number'];	
		$jobs = array();
		if($number)
		{
			$pages = phppages($number, $page, $pagesize);
			$query = "SELECT * FROM ".TABLE_YP_JOB." WHERE status>=3 $sql order by edittime DESC limit $offset,$pagesize";
			$result = $db->query($query);
			while($r = $db->fetch_array($result))
			{
				$r['addtime'] = $r['adddate'] = date('Y-m-d', $r['addtime']);
				$jobs[] = $r;
			}
		}
		include template($mod, 'job_search');
	break;
	default :
		$lastedittime = @filemtime('job.html');
		$lastedittime = $PHP_TIME-$lastedittime;
		$autoupdatetime = intval($MOD['autoupdate']);
		if(file_exists('job.html') && $lastedittime<$autoupdatetime)
		{	
			include 'job.html';
		}
		else
		{
			$head['title'] = $LANG['job'].'-'.$head['title'];
			ob_start();
			include template($mod, 'job');
			$data .= ob_get_contents();
			ob_clean();
			file_put_contents('job.html', $data);
			@chmod('job.html', 0777);	
			echo $data;
		}
	break;

}
?>
