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

if(!ereg('^[0-9]+$',$channelid))
{
	showmessage('非法参数！请返回！',$referer);
}

$pagesize = $_PHPCMS[pagesize];
$referer = $referer ? $referer : $PHP_REFERER;
$action = $action ? $action : 'manage';

$submenu=array(
	array("添加自定义网页模板", "?mod=phpcms&channelid=".$channelid."&file=template&action=add&module=".$mod),
	array("管理自定义网页模板", "?mod=phpcms&channelid=".$channelid."&file=template&action=manage&module=".$mod),
	array('添加自定义网页','?mod='.$mod.'&file='.$file.'&action=add&channelid='.$channelid),
	array('管理自定义网页','?mod='.$mod.'&file='.$file.'&action=manage&channelid='.$channelid),
);
$menu=adminmenu('自定义网页管理',$submenu);

switch($action){

case 'add':

	if($submit)
	{
		if(!preg_match("/^[0-9a-z_]+$/i",$name)) showmessage("<font color='red'>自定义网页名只能由字母、数字和下划线组成！请返回修改！</font>");
        if(!$meta_title) showmessage("网页标题不能为空！请返回修改！");

		$r = $db->get_one("SELECT * FROM ".TABLE_MYPAGE." WHERE name='$name'");
		if($r[name]) showmessage("<font color='red'>该名称已经存在！</font>");

		$db->query("INSERT INTO ".TABLE_MYPAGE." (channelid,name,meta_title,meta_keywords,meta_description,templateid,skinid) VALUES ('$channelid','$name','$meta_title','$meta_keywords','$meta_description','$templateid','$skinid')");

		showmessage("操作成功！","?mod=".$mod."&file=".$file."&action=manage&channelid=".$channelid);
	}
	else
	{
		$showskin = showskin('skinid',$skinid);
		$showtpl = showtpl($mod,'mypage','templateid',$templateid);
		include admintpl('mypage_add');
	}
     break;

case 'edit':

	if($submit)
	{
        if(!$meta_title) showmessage("网页标题不能为空！请返回修改！");

		$db->query("UPDATE ".TABLE_MYPAGE." SET meta_title='$meta_title',meta_keywords='$meta_keywords',meta_description='$meta_description',templateid='$templateid',skinid='$skinid' WHERE mypageid='$mypageid' AND channelid='$channelid'");

		showmessage('操作成功！',$referer);
	}
	else
	{
		@extract($db->get_one("select * from ".TABLE_MYPAGE." where mypageid='$mypageid'"));
		$showskin = showskin('skinid',$skinid);
		$showtpl = showtpl($mod,'mypage','templateid',$templateid);
		include admintpl('mypage_add');
	}
     break;

case 'delete':

	if(empty($mypageid))
	{
		showmessage('非法参数！请返回！');
	}
	$mypageids=is_array($mypageid) ? implode(',',$mypageid) : $mypageid;
	$db->query("DELETE FROM ".TABLE_MYPAGE." WHERE mypageid IN ($mypageids) and channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;

case 'manage':

	$referer = urlencode("?mod=page&file=page&action=manage&passed=".$passed."&channelid=".$channelid."&page=".$page);
	
	if(!$page)
	{
		$page=1;
		$offset=0;
	}
	else
	{
		$offset=($page-1)*$pagesize;
	}

	$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_MYPAGE." WHERE channelid='$channelid'");
	$number = $r['num'];

	$url="?mod=".$mod."&file=page&channelid=".$channelid;
	$pages=phppages($number,$page,$pagesize,$url);

	$result=$db->query("SELECT * FROM ".TABLE_MYPAGE." WHERE channelid='$channelid' ORDER BY mypageid LIMIT $offset,$pagesize");
	while($r=$db->fetch_array($result))
	{
		$r[url] = PHPCMS_SITEURL."mypage/?name=".$r[name];
		$mypages[]=$r;
	}
	include admintpl('mypage_manage');
	break;
}
?>