<?php
/*
*######################################
* PHPCMS v2.00 - Advanced Content Manage System.
* Copyright (c) 2004-2005 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*######################################
*/
defined('IN_PHPCMS') or exit('Access Denied');

$submenu = array
(
	array("站内信件管理", "?mod=".$mod."&file=".$file."&action=manage"),
	array("添加系统信件", "?mod=".$mod."&file=".$file."&action=add")
);

$menu = adminmenu("站内信件管理",$submenu);
$referer=$referer ? $referer : $PHP_REFERER;
$pagesize = $_PHPCMS['pagesize'] ? $_PHPCMS['pagesize'] : 20;
$action=$action ? $action : 'manage';

switch($action){

case 'add':

	if($submit)
	{

		if(empty($title))
		{
			showmessage('请输入标题！',$referer);
		}
		if(empty($content))
		{
			showmessage('请输入内容',$referer);
		}

		if(!empty($inbox) && $inbox!=1)
		{
			showmessage('参数错误！',$referer); 
		}

		$db->query("insert into ".TABLE_PM."(fromusername,title,posttime,content,system) values('$_username','$title','$timestamp','$content','1')");
		if($db->affected_rows()>0)
		{
			showmessage('信件发送成功！',$referer);
		}
		else
		{
			showmessage('发送失败！请联系管理员！',$referer);
		}
	}
	break;


case 'edit':

	if($submit)
	{

		if(empty($title))
		{
			showmessage('请输入标题！',$referer);
		}
		if(empty($content))
		{
			showmessage('请输入内容',$referer);
		}

		if(!empty($inbox) && $inbox!=1)
		{
			showmessage('参数错误！',$referer); 
		}

		$db->query("update ".TABLE_PM." set title='$title',posttime='$timestamp',content='$content' where pmid='$pmid'");

		if($db->affected_rows()>0)
		{
			showmessage('操作成功！',$referer);
		}
		else
		{
			showmessage('操作失败！请联系管理员！',$referer);
		}

	} 
	else
	{
		if(!ereg('^[0-9]+$',$pmid)) 
		{
			showmessage('参数错误！',$referer); 
		}

		$query="select * from ".TABLE_PM." where pmid='$pmid' limit 1";
		$result=$db->query($query);
		if(!$pm = $db->fetch_array($result))
		{
			showmessage('信件不存在！',$referer);
		}
	}

break;

case 'delete':

	if(empty($pmid))
	{
		showmessage('非法参数！请返回！');
	}
	$pmids=is_array($pmid) ? implode(',',$pmid) : $pmid;

	$db->query("delete from ".TABLE_PM." where pmid in ($pmids)");

	showmessage('操作成功！',$referer);

break;

case 'view':

	if(!ereg('^[0-9]+$',$pmid))
	{
		showmessage('参数错误！',$referer); 
	}
	$query="select * from ".TABLE_PM." where pmid='$pmid' limit 1";
	$result=$db->query($query);
	if(!$pm = $db->fetch_array($result)) 
	{
		showmessage('信件不存在！',$referer);
	}
	$pm['posttime']=date("Y-m-d H:i:s",$pm['posttime']);

break;

case 'clear':

	if(!ereg('^[0-9]+$',$day))
	{
	showmessage('参数错误！',$referer); 
	}
	$day=$timestamp-$day*86400;
	$result=$db->query("select pmid from ".TABLE_PM." where posttime<$day");
	$clear_num=$db->num_rows($result);
	$db->query("delete from ".TABLE_PM." where posttime<$day and system=0");
	showmessage('成功清理'.$clear_num.'条信息！',$referer);

break;


default:

	if(!$page)
	{
		$page=1;
		$offset=0;
	}
	else
	{
		$offset=($page-1)*$pagesize;
	}

	$query="select count(*) as num from ".TABLE_PM." where system=1 ";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r["num"];
	$url="?dir=plugin&file=pm";
	$pages=phppages($number,$page,$pagesize,$url);

	$query="select * from ".TABLE_PM." where system=1 order by pmid desc limit $offset,$pagesize";
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$r[posttime]=date("Y-m-d H:i:s",$r[posttime]);
			$pms[]=$r;
		}
	}
	 
}

include admintpl('pm');

?>
