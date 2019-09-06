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
require_once("common.php");

$pagesize= $_PHPCMS['pagesize'] ? $_PHPCMS['pagesize'] : 10;

$channelid = intval($channelid);
$gid = intval($gid);

$position = $channelid ? $_CHA['channelname'].'留言' : '网站留言';
	
if(!$page)
{
	$page=1;
	$offset=0;
}
else
{
	$offset=($page-1)*$pagesize;
}

if($keywords)
{
	$keyword = str_replace(' ','%',$keywords);
	$keyword = str_replace('*','%',$keywords);
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

$addquery .= $channelid ? " AND channelid='$channelid' " : "";
$addquery .= $gid ? " AND gid='$gid' " : "";
$addquery .= $_userid ? "or (hidden=1 and username='$_username') " : "";

$r = $db->get_one("select count(*) as num from ".TABLE_GUESTBOOK." where passed=1 and hidden=0 $addquery");
$number=$r["num"];
$url="?channelid=".$channelid."&keywords=".$keywords."&srchtype=".$srchtype;
$pages=phppages($number,$page,$pagesize,$url);

$result=$db->query("select * from ".TABLE_GUESTBOOK." where passed=1 and hidden=0 $addquery order by gid desc limit $offset,$pagesize");
while($r=$db->fetch_array($result))
{
	$r[content]=reword($r[content]);
	$r[head]=$r[head]<10 ? "0".$r[head] : $r[head];
	$r[addtime]=date("Y-m-d H:i:s",$r[addtime]);
	$r[replytime]=date("Y-m-d H:i:s",$r[replytime]);
	$r[gender]=$r[gender] ? "男" : "女";
	$gbooks[]=$r;
}

$meta_title = $channelid ? $_CHA['channelname']."频道留言本" : "网站留言本";
$meta_keywords = $channelid ? $_CHA['meta_keywords'] : $_PHPCMS['meta_keywords'];
$meta_description = $channelid ? $_CHA['meta_description'] : $_PHPCMS['meta_description'];

include template('guestbook','index');
?>