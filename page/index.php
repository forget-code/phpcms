<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/
chdir('../');

include "common.php";
require PHPCMS_ROOT.'/include/ubb.php';
$pagesize= $_PHPCMS['pagesize'] ? $_PHPCMS['pagesize'] : 20;

//if(!ereg('^[a-z]+$',$item))
//{
//	message('非法参数！请返回！g',$referer);
//}
//
//if(!ereg('^[0-9]+$',$itemid))
//{
//	message('非法参数！请返回！k',$referer);
//}

switch($action){

case 'add':

		if($checkcodeguestbook && $_SESSION['randomstr']!=$checkcode)
		{
			message('验证码不正确！','goback');
		}
		if($gender!=0 && $gender!=1)
		{
			message('参数错误！','goback'); 
		}
		if(strlen($username)>20 || strlen($email)>50 || strlen($homepage)>255 || strlen($content)>10000)
		{
			message('参数错误！','goback');
		}
		if(empty($username))
		{
			message('请输入姓名！','goback');
		}
		if(empty($title))
		{
			message('请输入留言主题！','goback');
		}
		if(empty($content))
		{
			message('请输入留言内容');
		}
		if($hidden!=0 && $hidden!=1)
		{
			message('参数错误！','goback'); 
		}
		$username = $_username ? $_username : $username;
		$inputstring=dhtmlspecialchars(array('title'=>$title,'content'=>$content,'username'=>$username,'gender'=>$gender,'head'=>$headimg,'email'=>$email,'homepage'=>$homepage,'hidden'=>$hidden));
		extract($inputstring,EXTR_OVERWRITE);
		if($replycheck)
		{
			$passed=0;
			$message="留言发表成功！请等待管理员审核！";
		}
		else
		{
			$passed=1;
			$message="留言发表成功！";
		}
		$query = "insert into ".TABLE_GUESTBOOK."(channelid,title,content,username,gender,head,email,homepage,addtime,passed,ip) values('$channelid','$title','$content','$_username','$gender','$head','$email','$homepage','$timestamp','$passed','$PHP_IP')";
		$db->query($query);
		if($db->affected_rows()>0)
		{
			message($message,"./?channelid=".$channelid);
		}
		else
		{
			message('留言发表失败！请联系管理员！','goback');
		}


break;

case 'headlist':

	$facedir=opendir($phpcms_root."/images/guestbook/face/");
	while($face=readdir($facedir))
	{
		if($face!="." && $face!=".." && preg_match("/.gif$/i",$face))
		{
			$head=str_replace(".gif","",$face);
			$faces[]=$head;
		}
	}
	include template('guestbook_headlist');

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
	if(!empty($keyword))
	{
		$keyword=str_replace(' ','%',$keyword);
		$keyword=str_replace('*','%',$keyword);
		switch($srchtype)
		{
		case '0':
			$addquery=" and title like '%$keyword%' ";
			break;
		case '1':
			$addquery=" and content like '%$keyword%' ";
			break;
		case '2':
			$addquery=" and username like '%$keyword%' ";
			break;
		default :
			$addquery=" and title like '%$keyword%' ";
		}
	}

	$addquery.= $channelid ? " AND channelid='$channelid' " : "";
	$addquery.= $gid ? " AND gid='$gid' " : "";
	$query="select count(*) as num from ".TABLE_GUESTBOOK." where passed=1 $addquery";
	$result=$db->query($query);
	$r=$db->fetch_array($result);
	$number=$r["num"];
	$url="?channelid=".$channelid."&keyword=".$keyword."&srchtype=".$srchtype."&page=".$page;
	$pages=phppages($number,$page,$pagesize,$url);

	$query="select * from ".TABLE_GUESTBOOK." where passed=1 $addquery order by gid desc limit $offset,$pagesize";
	$result=$db->query($query);
	if($db->num_rows($result)>0)
	{
		while($r=$db->fetch_array($result))
		{
			$r[content]=ubb($r[content]);
			$r[content]=reword($r[content]);
			$r[head]=$r[head]<10 ? "0".$r[head] : $r[head];
			$r[addtime]=date("Y-m-d H:i:s",$r[addtime]);
			$r[replytime]=date("Y-m-d H:i:s",$r[replytime]);
			$r[gender]=$r[gender] ? "男" : "女";
			$gbooks[]=$r;
		}
	}
	include template('guestbook','guestbook');
}

copyright($version);
?>