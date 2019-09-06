<?php
/*
*######################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2004-2005 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*######################################
*/
defined('IN_PHPCMS') or exit('Access Denied');

$submenu=array(
	array('添加投票','?mod='.$mod.'&file='.$file.'&action=add&channelid='.$channelid),
	array('管理投票','?mod='.$mod.'&file='.$file.'&action=manage&passed=1&channelid='.$channelid),
	array('审核投票','?mod='.$mod.'&file='.$file.'&action=manage&passed=0&channelid='.$channelid),
	array('过期投票','?mod='.$mod.'&file='.$file.'&action=manage&channelid='.$channelid.'&timeout=1'),
	array('更新JS','?mod='.$mod.'&file='.$file.'&action=updatejs&channelid='.$channelid)
);
$menu = adminmenu("投票管理",$submenu);

$pagesize=$_PHPCMS[pagesize];
$today = date("Y-m-d");

$action = $action ? $action : 'manage';

switch($action){

case 'add':
    if($submit)
	{
		if(empty($subject)) showmessage('对不起，请输入投票名称！请返回！');
		if(empty($voteoption[0])) showmessage('非法参数！请返回！'); 
		if(!ereg('^[01]+$',$passed)) showmessage('非法参数！请返回！'); 

		$db->query("insert into ".TABLE_VOTESUBJECT."(channelid,subject,type,username,fromdate,todate,addtime,passed,templateid,skinid) values('$channelid','$subject','$type','$_username','$fromdate','$todate','$timestamp','$passed','$templateid','$skinid')");
        $voteid = $db->insert_id();
		foreach($voteoption as $optionid=>$option)
		{
			if(empty($option)) continue;
			$db->query("insert into ".TABLE_VOTEOPTION."(`voteid`,`option`) values('$voteid','$option')");
		}
        showmessage('操作成功！',$referer);
    }
	else
	{
		$showskin = showskin('skinid',$skinid);
        $showtpl = showtpl($mod,'show','templateid',$templateid);
        include admintpl('vote_add');
    }
    break;

case 'edit':
	if($submit)
	{
		$db->query("update ".TABLE_VOTESUBJECT." set subject='$subject',type='$type',fromdate='$fromdate',todate='$todate',templateid='$templateid',skinid='$skinid' where channelid=$channelid and voteid='$voteid' ");
		foreach($voteoptionedit as $optionid=>$option)
		{
			if($option)
			{
				$db->query("update ".TABLE_VOTEOPTION." set `option`='$option' where optionid='$optionid'");
			}
			else
			{
				$db->query("delete from ".TABLE_VOTEOPTION." where optionid='$optionid'");
			}
		}
		//编辑的时候新添加的选项
		if(is_array($voteoption))
		{
			foreach($voteoption as $optionid=>$option)
			{
				if(empty($option)) continue;
				$db->query("insert into ".TABLE_VOTEOPTION."(`voteid`,`option`) values('$voteid','$option')");
			}
		}
		tohtml("vote");
		showmessage('操作成功',$referer);
	}
	else
	{
		$r = $db->get_one("select * from ".TABLE_VOTESUBJECT."  where channelid=$channelid and voteid='$voteid'");
		@extract($r);
		$result=$db->query("select * from ".TABLE_VOTEOPTION." where voteid='$voteid'");
		while($r=$db->fetch_array($result))
		{
			$ops[]=$r;
		}
		$number = $db->num_rows($result);
		$todate = $todate>'0000-00-00' ? $todate : "";
		$showskin = showskin('skinid',$skinid);
        $showtpl = showtpl($mod,'show','templateid',$templateid);
		include admintpl('vote_edit');
	}
	break;

case 'delete':
	if(empty($voteid)) showmessage('非法参数！请返回！');

	$voteids=is_array($voteid) ? implode(',',$voteid) : $voteid;
	$db->query("DELETE FROM ".TABLE_VOTESUBJECT." WHERE channelid=$channelid and voteid IN ($voteids)");
	$db->query("DELETE FROM ".TABLE_VOTEOPTION." WHERE voteid IN ($voteids)");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

case 'pass':

	if(empty($voteid)) showmessage('非法参数！请返回！',$referer);

	if(!ereg('^[0-1]+$',$passed)) showmessage('非法参数！请返回！',$referer);

	$voteids = is_array($voteid) ? implode(',',$voteid) : $voteid;
	$db->query("UPDATE ".TABLE_VOTESUBJECT." SET passed=$passed WHERE channelid=$channelid and voteid IN ($voteids)");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
	break;

case 'getcode':
	include admintpl('vote_getcode');
	break;

case 'updatejs':
	$today = date("Y-m-d");
	$result = $db->query("SELECT voteid FROM  ".TABLE_VOTESUBJECT." WHERE channelid=$channelid AND passed=1 AND todate>'$today' OR todate='0000-00-00' ORDER BY voteid DESC ");
	while($r = $db->fetch_array($result))
	{
		$voteid = $r[voteid];
		tohtml("vote");
	}
	showmessage('更新成功！',$PHP_REFERER);
	break;

//投票管理界面
case 'manage':
	if(!$page)
	{
		$page=1;
		$offset=0;
	}
	else
	{
		$offset = ($page-1)*$pagesize;
	}
	$sql = "";
	$sql .= isset($passed) ? " AND passed='$passed' " : "";
	$sql .= $timeout ? " AND todate<'$today' AND todate!='0000-00-00' " : " AND (todate>='$today' OR todate='0000-00-00') ";

	$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_VOTESUBJECT." WHERE channelid=$channelid $sql");
	$number = $r['num'];
	
	$url = "?mod=".$mod."&file=vote&passed=".$passed."&channelid=".$channelid;
	$pages = phppages($number,$page,$pagesize,$url);

	$result = $db->query("SELECT * FROM  ".TABLE_VOTESUBJECT." WHERE channelid=$channelid $sql ORDER BY voteid DESC LIMIT $offset,$pagesize");
	while($r=$db->fetch_array($result))
	{
		$r['adddate'] = date("Y-m-d",$r['addtime']);
		$r['addtime'] = date("Y-m-d H:i:s",$r['addtime']);
		$votes[]=$r;
	}
	$referer = urlencode($PHP_URL);
	include admintpl('vote_manage');
	break;
	
}
?>