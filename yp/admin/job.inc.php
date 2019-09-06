<?php
defined('IN_PHPCMS') or exit('Access Denied');

$action = $action ? $action : 'manage';
$class = isset($class) ? $class : 'manage';
$jobs = array("manage"=>"status=3 ", "check"=>"status=1", "recycle"=>"status=-1");
array_key_exists($class, $jobs) or showmessage($LANG['illegal_action'], 'goback');
$submenu = array(
	array($LANG['job_manage'],"?mod=$mod&file=$file&action=manage&class=manage"),
	array($LANG['job_check'],"?mod=$mod&file=$file&action=manage&class=check"),
	array($LANG['recycle'],"?mod=$mod&file=$file&action=manage&class=recycle"),
	array($LANG['statistical_report'],"?mod=$mod&file=$file&action=stats"),

);
$menu = adminmenu($LANG['job_manage'],$submenu);
require PHPCMS_ROOT.'/yp/include/tag.func.php';

switch($action)
{
	case 'manage':
		
		if($class == 'manage')
		{
			$status = 'status>=3';
		}
		elseif($class == 'check')
		{
			$status = 'status=1';
		}
		else
		{
			$status = 'status=-1';
		}
		$station = isset($station) ? $station : '';
		$station_select = '<select id="station" name="station">';
		$station_select .= '<option value="0">'.$LANG['choose_station'].'</option>';
		$station_selects = explode("\n",$MOD['station']);

		foreach($station_selects AS $v)
		{
			$selected = '';
			if($station == $v) $selected = 'selected="selected"';
			$station_select .= '<option value="'.$v.'" '.$selected.'>'.$v.'</option>';
		}
		$station_select .= '</select>';

		$pagesize = $PHPCMS['pagesize'];
		$page = isset($page) ? intval($page) : 1;
		$offset = ($page-1)*$pagesize;
		$srchtype = isset($srchtype) ? intval($srchtype) : 0;
		$typeid = isset($typeid) ? intval($typeid) : 0;
		$orders = array('jobid DESC', 'jobid ASC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
		$ordertype = isset($ordertype) ? intval($ordertype) : 0;
		$order = $orders[$ordertype];
		$condition = '';
		if(isset($keyword))
		{
			$keyword = trim($keyword);
			$keyword = str_replace(' ','%',$keyword);
			$keyword = str_replace('*','%',$keyword);
			if($srchtype)
			{
				$condition .= " AND unit LIKE '%$keyword%' ";
			}
			else
			{
				$condition .= " AND title LIKE '%$keyword%' ";
			}
			$condition .= $station ? " AND station = '$station' " : '';
		}
		$r = $db->get_one("SELECT COUNT(companyid) AS num FROM ".TABLE_YP_JOB." WHERE $status $condition");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$jobs = array();
		$result = $db->query("SELECT * FROM ".TABLE_YP_JOB." WHERE $status $condition ORDER BY $order LIMIT $offset,$pagesize");		
		while($r = $db->fetch_array($result))
		{
			$r['addtime'] = date('Y-m-d',$r['addtime']);
			$r['edittime'] = date('Y-m-d H:i:s',$r['edittime']);
			$r['checktime'] = date('Y-m-d H:i:s',$r['checktime']);
			extract($db->get_one("SELECT companyname,sitedomain FROM ".TABLE_MEMBER_COMPANY." WHERE companyid=$r[companyid]"));
			$r['companyname'] = $companyname;
			if($MOD['enableSecondDomain'])
			{
				$r['domain'] = 'http://'.$sitedomain.'.'.$MOD['secondDomain'];
			}
			else
			{
				@extract($db->get_one("SELECT userid FROM ".TABLE_MEMBER." WHERE username = '$r[username]'"));
				$r['domain'] = $PHPCMS['siteurl']."yp/web/?".$userid."/";
			}
			$jobs[] = $r;
		}
	include admintpl('job_'.$class);
	break;

case 'listorder':

	if(empty($listorder) || !is_array($listorder))
	{
		showmessage($LANG['illegal_parameters']);
	}

	foreach($listorder as $key=>$val)
	{
		$db->query("UPDATE ".TABLE_YP_JOB." SET `listorder`='$PHP_TIME' WHERE jobid=$key ");
	}

	showmessage($LANG['update_success'],$forward);

break;

case 'status' :
	if(empty($jobid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	if(!is_numeric($status))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$jobids = is_array($jobid) ? implode(',',$jobid) : $jobid;
	$db->query("UPDATE ".TABLE_YP_JOB." SET status=$status WHERE jobid IN ($jobids)");
	if($db->affected_rows()>0)
	{
		showmessage($LANG['operation_success'],$forward);
	}
	else
	{
		showmessage($LANG['operation_failure']);
	}
	break;
case 'truncate':
	$db->query("DELETE FROM ".TABLE_YP_JOB." WHERE status='-1'");
	showmessage($LANG['operation_success'],$forward);
	break;
case 'delete':
	if(empty($jobid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$jobids = is_array($jobid) ? implode(',',$jobid) : $jobid;
	$db->query("DELETE FROM ".TABLE_YP_JOB." WHERE jobid IN ($jobids)");
	if($db->affected_rows()>0)
	{
		showmessage($LANG['operation_success'],$forward);
	}
	else
	{
		showmessage($LANG['operation_failure']);
	}
	break;
case 'edit':
	if($dosubmit)
	{
		if($MOD['enableSecondDomain'])
		{
			extract($db->get_one("SELECT companyname AS pagename,sitedomain AS domainName,templateid AS defaultTplType,banner,background,introduce FROM ".TABLE_MEMBER_COMPANY." WHERE companyid='$companyid'"));
			$product['linkurl'] = 'http://'.$domainName.'.'.$MOD['secondDomain'].'/job.php?item-'.$jobid.'.html';
		}
		else
		{
			extract($db->get_one("SELECT m.username,m.userid, c.companyname AS pagename,c.templateid AS defaultTplType,c.banner,c.background,c.introduce FROM ".TABLE_MEMBER_COMPANY." c, ".TABLE_MEMBER." m WHERE c.companyid='$companyid' AND c.username=m.username"));
			$product['linkurl'] = $MODULE['yp']['linkurl'].'web/job.php?enterprise-'.$userid.'/item-'.$jobid.'.html';
			
		}
		if($background)
		{
			$backgrounds = explode('|',$background);
			$backgroundtype = $backgrounds[0];
			$background = $backgrounds[1];
		}
		$job['edittime'] = $PHP_TIME;
		$job['editor'] = $_username;
		$job['title'] = htmlspecialchars($job['title']);
		$job['introduce'] = str_safe($job['introduce']);
		$sql = $s = "";
		foreach($job as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ",";
		}
		$db->query("UPDATE ".TABLE_YP_JOB." SET $sql WHERE jobid='$jobid'");
		createhtml('job');
		showmessage($LANG['operation_success'],$forward);

	}
	else
	{
		require_once PHPCMS_ROOT.'/include/tree.class.php';
		$tree = new tree;
		$AREA = cache_read('areas_'.$mod.'.php');
		require_once PHPCMS_ROOT.'/include/area.func.php';
		@extract($db->get_one("SELECT * FROM ".TABLE_YP_JOB." WHERE jobid='$jobid'"),EXTR_OVERWRITE);
		$style_edit = style_edit("job[style]", $style);
		include admintpl('job_edit');
	}

	break;

	case 'stats':
		$username = isset($username) ? $username : '';
		$fromdate = isset($fromdate) && preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $fromdate) ? $fromdate : '';
		$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
		$todate = isset($todate) && preg_match('/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/', $todate) ? $todate : '';
		$totime = $todate ? strtotime($todate.' 23:59:59') : 0;
		$sql = '';
		if($username) $sql .= " and username='$username' ";
		if($fromtime) $sql .= " and addtime>$fromtime ";
		if($totime) $sql .= " and addtime<$totime ";

		$stations = explode("\n",$MOD['station']);

		$station = '';
		$id = 1;
		$sum__1 = $sum_0 = $sum_1 = $sum_2 = $sum_3 =0;
		foreach($stations as $k => $v)
		{
			$status[-1] = 'num__1';
			$status[0] = 'num_0';
			$status[1] = 'num_1';
			$status[2] = 'num_2';
			$status[3] = 'num_3';
			for($i=-1; $i<4; $i++)
			{
				$r = $db->get_one("select count(jobid) as num from ".TABLE_YP_JOB." where status=$i and station='$v' $sql ");
				$$status[$i] = $r['num'];
			}
			$percent__1 = $percent_0 = $percent_1 = $percent_2 = $percent_3 =0;
			$sum = $num__1+$num_0+$num_1+$num_2+$num_3;
			$sum__1 += $num__1;
			$sum_0 += $num_0;
			$sum_1 += $num_1;
			$sum_2 += $num_2;
			$sum_3 += $num_3;
			if($sum > 0)
			{
				$percent__1 = round(100*$num__1/$sum, 1);
				$percent_0 = round(100*$num_0/$sum, 1);
				$percent_1 = round(100*$num_1/$sum, 1);
				$percent_2 = round(100*$num_2/$sum, 1);
				$percent_3 = round(100*$num_3/$sum, 1);
			}
			$str = urlencode($v);
			$station .= "<tr onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5' height='23'>
						<td>$id</td>
						<td><span style='float:left;font-size:12px;'><a href=\"?mod=yp&file=job&action=manage&catid=0&srchtype=0&keyword=&station=$str&ordertype=0&pagesize=20\">$v</a></span></td>
						<td><span style='float:right;font-size:10px;'>$percent_3%</span>$num_3</td>
						<td><span style='float:right;font-size:10px;'>$percent_1%</span>$num_1</td>
						<td><span style='float:right;font-size:10px;'>$percent__1%</span>$num__1</td>
						<td><span style='float:right;font-size:10px;'>$percent_0%</span>$num_0</td>
						<td><span style='float:right;font-size:10px;'>$percent_2%</span>$num_2</td>
						</tr>
			";
			$id++;
		}		
		include admintpl('job_stats');
	break;
}
?>