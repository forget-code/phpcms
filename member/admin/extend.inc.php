<?php
defined('IN_PHPCMS') or exit('Access Denied');

require MOD_ROOT.'include/extend.class.php';
$extend = new extend();

switch($action)
{
    case 'add':
		if($dosubmit)
		{
		    $extend->set($userid, $groupid);
			if(!$extend->add($unit, $number, $price, $startdate)) showmessage($extend->errormsg());
			showmessage('升级成功', $forward);
		}
		else
		{
			include admin_tpl('extend_add');
		}
		break;

    case 'edit':
		if($dosubmit)
		{
		    $extend->set($userid, $groupid);
			if(!$extend->edit($unit, $number, $price, $startdate)) showmessage($extend->errormsg());
			showmessage('修改成功', $forward);
		}
		else
		{
			include admin_tpl('extend_edit');
		}
		break;

    case 'disable':
		$extend->set($userid, $groupid);
		$extend->disable($disabled);
		showmessage('操作成功', $forward);
		break;

    case 'delete':
		$extend->set($userid, $groupid);
		$extend->delete();
		showmessage('删除成功', $forward);
		break;

    default :
		$where = '';
		if($groupid) $where .= "AND groupid=$groupid";
		if($username)
	    {
			$userid = userid($username);
			if($userid) $where .= "AND userid=$userid";
		}
		if($startdate_start) $where .= "AND startdate>='$startdate_start'";
		if($startdate_end) $where .= "AND startdate<='$startdate_end'";
		if($enddate_start) $where .= "AND enddate>='$enddate_start'";
		if($enddate_end) $where .= "AND enddate<='$enddate_end'";
        if($type == 'join')
	    {
			$date = load('date.class.php');
			$date->set_date();
			$today = date('Y-m-d');
			if($time == 'today')
			{
				$where .= "AND startdate='$today'";
			}
			elseif($time == 'yesterday')
			{
				$date->dayadd(-1);
				$yesterday = $date->get_date();
				$where .= "AND startdate='$yesterday'";
			}
			elseif($time == 'week')
			{
				$w = date('w');
				if($w == 0) $w = 7;
				if($w == 1) 
				{
					$where .= "AND startdate='$today'";
				}
				else
				{
					$date->dayadd(1-$w);
					$startday = $date->get_date();
					$where .= "AND startdate>='$startday'";
				}
			}
			elseif($time == 'month')
			{
				$startday = date('Y-m-1');
				$where .= "AND startdate>='$startday'";
			}
		}
		elseif($type == 'expire')
	    {
			$date = load('date.class.php');
			$date->set_date();
			$today = date('Y-m-d');
			if($time == 'today')
			{
				$where .= "AND enddate='$today'";
			}
			elseif($time == 'yesterday')
			{
				$date->dayadd(-1);
				$yesterday = $date->get_date();
				$where .= "AND enddate='$yesterday'";
			}
			elseif($time == 'week')
			{
				$w = date('w');
				if($w == 0) $w = 7;
				if($w == 1) 
				{
					$where .= "AND enddate='$today'";
				}
				else
				{
					$date->dayadd(1-$w);
					$startday = $date->get_date();
					$date->dayadd(6);
					$endday = $date->get_date();
					$where .= "AND enddate>='$startday' AND enddate<='$endday'";
				}
			}
			elseif($time == 'month')
			{
				$startday = date('Y-m-01');
				$endday = date('Y-m-').$date->get_lastday();
				$where .= "AND enddate>='$startday' AND enddate<='$endday'";
			}
			elseif($time == 'all')
			{
				$where .= "AND enddate<'$today'";
			}
		}
		if($where) $where = substr($where, 3);

		$data = $extend->listinfo($where, '`time` desc', $page, 20);
		include admin_tpl('extend_manage');
}
?>