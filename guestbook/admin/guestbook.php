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

$pagesize=$_PHPCMS[pagesize];
$referer=$referer ? $referer : $PHP_REFERER;
$action=$action ? $action : 'manage';

switch($action){

case 'delete':

	if(empty($gid))
	{
		showmessage('非法参数！请返回！');
	}
	$gids=is_array($gid) ? implode(',',$gid) : $gid;
	$db->query("DELETE FROM ".TABLE_GUESTBOOK." WHERE gid IN ($gids) and channelid='$channelid'");
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

	if(empty($gid))
	{
		showmessage('非法参数！请返回！',$referer);
	}
	if(!ereg('^[0-1]+$',$passed))
	{
		showmessage('非法参数！请返回！',$referer);
	}
	$gids=is_array($gid) ? implode(',',$gid) : $gid;
	$db->query("UPDATE ".TABLE_GUESTBOOK." SET passed=$passed WHERE gid IN ($gids) AND  channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
	break;

case 'reply':

	if(empty($gid))
	{
		showmessage('非法参数！请返回！');
	}
	if($submit)
	{
		$db->query("update ".TABLE_GUESTBOOK." set reply='$reply',passed='$passed',hidden='$hidden',replyer='$_username',replytime='$timestamp' where gid=$gid ");
		showmessage('操作成功！',$PHP_REFERER);
	}
	else
	{
		require PHPCMS_ROOT."/class/ip.php";
		$getip = new IpLocation;
		$referer=urlencode($referer);
		$query="select * from ".TABLE_GUESTBOOK." where gid='$gid'";
		$result=$db->query($query);
		$guestbook=$db->fetch_array($result);
		$gip=$getip->getlocation($guestbook[ip]);
		$guestbook[addtime]=date("Y-m-d H:i:s",$guestbook[addtime]);
		$guestbook[replytime]=date("Y-m-d H:i:s",$guestbook[replytime]);
		$guestbook[head]=$guestbook[head]<10 ? "0".$guestbook[head] : $guestbook[head];
		include admintpl('guestbook_reply');
	}

break;

case 'manage':

	require PHPCMS_ROOT."/class/ip.php";
	$getip = new IpLocation;
	$passed = isset($passed) ? $passed : "1";
	$referer = urlencode("?mod=guestbook&file=guestbook&action=manage&passed=".$passed."&channelid=".$channelid."&page=".$page);
	if(!$page)
	{
		$page=1;
		$offset=0;
	}
	else
	{
		$offset=($page-1)*$pagesize;
	}
	
	$condition = " AND passed=$passed ";
	if(!empty($keyword))
	{
		$keyword=str_replace(' ','%',$keyword);
		$keyword=str_replace('*','%',$keyword);
		switch($srchtype)
		{
		case '0':
			$condition .=" AND title like '%$keyword%' ";
			break;
		case '1':
			$condition .=" AND content like '%$keyword%' ";
			break;
		case '2':
			$condition .=" AND username like '%$keyword%' ";
			break;
		default :
			$condition .=" AND title like '%$keyword%' ";
		}
	}
	$condition .= $ip ? " AND ip='$ip' " : "";
	$query="SELECT COUNT(*) AS num FROM ".TABLE_GUESTBOOK." WHERE channelid='$channelid' $condition";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r['num'];
	$url="?mod=".$mod."&file=guestbook&passed=".$passed."&keywords=".$keywords."&ip=".$ip."&channelid=".$channelid;
	$pages=phppages($number,$page,$pagesize,$url);

	$query="SELECT * FROM ".TABLE_GUESTBOOK." WHERE channelid='$channelid' $condition ORDER BY gid DESC LIMIT $offset,$pagesize";

	$result=$db->query($query);
	while($r=$db->fetch_array($result))
	{
		$r['adddate']=date("Y-m-d",$r['addtime']);
		$r['addtime']=date("Y-m-d H:i:s",$r['addtime']);
		$r['gip']=$getip->getlocation($r['ip']);
		$guestbooks[]=$r;
	}
	include admintpl('guestbook_manage');
	break;
}
?>