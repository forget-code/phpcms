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
	array('添加公告','?mod='.$mod.'&file='.$file.'&action=add&channelid='.$channelid),
	array('管理公告','?mod='.$mod.'&file='.$file.'&action=manage&passed=1&channelid='.$channelid),
	array('审批公告','?mod='.$mod.'&file='.$file.'&action=manage&passed=0&channelid='.$channelid),
	array('过期公告','?mod='.$mod.'&file='.$file.'&action=manage&channelid='.$channelid.'&timeout=1')
);
$menu=adminmenu('公告管理',$submenu);

$referer=$referer ? $referer : $PHP_REFERER;

$pagesize=$_PHPCMS[pagesize];

$addtime = $timestamp;

$action=$action ? $action : 'manage';

switch($action){

//公告管理界面
case 'manage':
	$referer=urlencode("?mod=".$mod."&file=announce&action=manage&passed=".$passed."&channelid=".$channelid."&timeout=".$timeout."&page=".$page);
	if(!$page)
	{
		$page=1;
		$offset=0;
	}
	else
	{
		$offset=($page-1)*$pagesize;
	}

    $today = date("Y-m-d");
	$sql = "";
	$sql .= isset($passed) ? " AND passed='$passed' " : "";
	$sql .= $timeout ? " AND todate<$today AND todate!='0000-00-00' " : "";

	$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_ANNOUNCEMENT." WHERE channelid='$channelid' $sql ");
	$number=$r['num'];

	$url="?mod=".$mod."&file=announce&now=".$now."&passed=".$passed."&channelid=".$channelid."&page=".$page;
	$pages=phppages($number,$page,$pagesize,$url);

	$result=$db->query("SELECT * FROM  ".TABLE_ANNOUNCEMENT." WHERE channelid=$channelid $sql ORDER BY announceid DESC LIMIT $offset,$pagesize");
	while($r=$db->fetch_array($result))
	{
		$r[addtime] = date('Y-m-d H:i:s',$r[addtime]);
		if($r[todate]=='0000-00-00') $r[todate] = "不限";
		$announces[] = $r;
	}
	include admintpl('announce_manage');
break;

//查看公告
case 'view':
	$announce=$db->get_one("SELECT * FROM  ".TABLE_ANNOUNCEMENT." where announceid='$announceid' ");
	$announce[addtime] = date('Y-m-d H:i:s',$announce[addtime]);
	if($announce[todate]=='0000-00-00') $announce[todate] = "不限";
	include admintpl('announce_view');
break;

//公告添加
case 'add':

    if($submit)
	{
		if(empty($title)) showmessage('对不起，请输入公告名称！请返回！');
		$db->query("insert into ".TABLE_ANNOUNCEMENT."(title,channelid,content,fromdate,todate,username,addtime,passed,templateid,skinid) values('$title','$channelid','$content','$fromdate','$todate','$_username','$addtime','$passed','$templateid','$skinid')");
		$referer="?mod=".$mod."&file=announce&action=manage&passed=".$passed."&channelid=".$channelid;
		showmessage('操作成功！',$referer);
    }
	else
	{
		$today=date("Y-m-d",$timestamp);
		$showskin = showskin('skinid',$skinid);
		$showtpl = showtpl($mod,'announce','templateid',$templateid);
        include admintpl('announce_add');
    }
break;

//公告修改
case 'edit':
	if($submit)
	{
		if(!$fromdate) showmessage('您必须输入起始时间，请返回修改。');
		if(!trim($title) || !trim($content)) showmessage('您必须输入公告标题和内容，请返回修改。');

		$db->query("UPDATE ".TABLE_ANNOUNCEMENT." SET title='$title', fromdate='$fromdate', todate='$todate', content='$content',passed='$passed',templateid='$templateid',skinid='$skinid' WHERE announceid='$announceid'");
		showmessage('操作成功！',$referer);
	}else{
		$r = $db->get_one("select * from ".TABLE_ANNOUNCEMENT." where announceid='$announceid'");
		$r[todate] = $r[todate]!='0000-00-00' ? $r[todate] : '';
		$r[content] = htmlspecialchars($r[content]);
		$showskin = showskin('skinid',$r[skinid]);
		$showtpl = showtpl($mod,'announce','templateid',$r[templateid]);
		include admintpl('announce_edit');
	}
break;

//批准公告
case 'pass':
	if(empty($announceid))
	{
		showmessage('非法参数！请返回！',$referer);
	}
	if(!ereg('^[0-1]+$',$passed))
	{
		showmessage('非法参数！请返回！',$referer);
	}
	$announceids=is_array($announceid) ? implode(',',$announceid) : $announceid;
	$db->query("UPDATE ".TABLE_ANNOUNCEMENT." SET passed=$passed WHERE announceid IN ($announceids)");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$PHP_REFERER);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
	break;

//公告删除
case 'delete':
	if(empty($announceid))
	{
		showmessage('非法参数！请返回！');
	}
	$announceids=is_array($announceid) ? implode(',',$announceid) : $announceid;
	$db->query("DELETE FROM ".TABLE_ANNOUNCEMENT." WHERE announceid IN ($announceids)");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;
}
?>