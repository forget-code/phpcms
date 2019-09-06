<?php
defined('IN_PHPCMS') or exit('Access Denied');
error_reporting(7);
require_once MOD_ROOT.'include/stats.class.php';

$ST = new stats();
$where = '';
$type = $type ? $type : 'all';
if($type != 'all')
{
	$year = date('Y',TIME);
	$month = date('m',TIME);
	$day = date('d',TIME);
	if($type=='today')
	{
		//今日统计
		$stime = mktime(0, 0, 0, $month, $day, $year);
	}
	elseif($type=='yestoday')
	{
		//昨日统计
		$stime = mktime(0, 0, 0, $month, $day-1, $year);
	}
	elseif($type=='week')
	{
		//本周统计
		$stime = mktime(0, 0, 0, $month, $day-7, $year);
	}
	else
	{
		//本月统计
		$stime = mktime(0, 0, 0, $month, 1, $year);
	}
	$where .= " AND b.hits_time>$stime";
	
}
if($inputdate_start || $inputdate_end)
{
	$where = '';
	$type = '';//如果选择时间段，那么则重置 type
}
if($catid) $where .= " AND a.catid='$catid'";
if($inputdate_start) $where .= " AND a.`inputtime`>='".strtotime($inputdate_start.' 00:00:00')."'"; else $inputdate_start = date('Y-m-01');
if($inputdate_end) $where .= " AND a.`inputtime`<='".strtotime($inputdate_end.' 23:59:59')."'"; else $inputdate_end = date('Y-m-d');

$field = $field ? $field : 'title';//初始化搜索字段
if($q)
{
	
	if($field == 'title')
	{
		$where .= " AND a.`title` LIKE '%$q%'";
	}
	elseif($field == 'userid')
	{
		$userid = intval($q);
		if($userid)	$where .= " AND a.`userid`='$userid'";
	}
	elseif($field == 'username')
	{
		$userid = userid($q);
		if($userid)	$where .= " AND a.`userid`='$userid'";
	}
	elseif($field == 'vid')
	{
		$vid = intval($q);
		if($vid) $where .= " AND a.`vid`='$vid'";
	}
}
$orderby = $orderby ? $orderby : 'a.`vid` DESC';
$infos = $ST->listinfo($where, $orderby, $page, 10);
if($catid)
{
	$pagetitle = $CATEGORY[$catid]['catname'];
}
else
{
	$pagetitle = '所有';
}
$POSID[] = '批量添加至推荐位：' ;
foreach($POS AS $key => $p)
{
	if($priv_role->check('posid', $key))
	{
		$POSID[$key] = "::".$p;
	}
}
$POS = $POSID;
//专辑分类
if($specialid)
{
	$special_arr = $db->get_one("SELECT * FROM ".DB_PRE."video_special WHERE specialid='$specialid'");
	$specialname = $special_arr['title'];
}
include admin_tpl('stat');
?>