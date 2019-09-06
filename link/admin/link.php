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
$referer = $referer ? $referer : '?mod='.$mod.'&file='.$file.'&action=manage&channelid='.$channelid;

$g = $db->get_one("SELECT count(*) AS number FROM ".TABLE_LINK." WHERE passed=0 AND channelid='$channelid'");

if($g[number])
{
	$submenu=array(
		array('添加链接','?mod='.$mod.'&file='.$file.'&action=add&channelid='.$channelid),
		array('管理链接','?mod='.$mod.'&file='.$file.'&action=manage&channelid='.$channelid),
		array('<font color=red>审核链接('.$g[number].')</font>','?mod='.$mod.'&file='.$file.'&action=manage&passed=0&channelid='.$channelid)
	);
}
else
{
	$submenu=array(
		array('添加链接','?mod='.$mod.'&file='.$file.'&action=add&channelid='.$channelid),
		array('管理链接','?mod='.$mod.'&file='.$file.'&action=manage&channelid='.$channelid),
		array('审核链接','?mod='.$mod.'&file='.$file.'&action=manage&passed=0&channelid='.$channelid)
	);
}
$menu=adminmenu('链接管理',$submenu);

$action=$action ? $action : 'manage';

switch($action){

case 'add':

	if($submit)
	{
		if(!ereg('^[01]+$',$linktype))
		{
			showmessage('非法参数！请返回！'); 
		}   
		if(empty($name))
		{
			showmessage("请输入网站名称！","goback");
		}
		if(empty($url) || $url=='http://')
		{
			showmessage("请输入网站地址！","goback");
		}

		$password = $password ? md5($password) : '';
		$db->query("insert into ".TABLE_LINK."(linktype,name,url,logo,introduction,username,email,password,elite,passed,addtime,channelid) values('$linktype','$name','$url','$logo','$introduction','$username','$email','$password','$elite','$passed','$timestamp','$channelid')");
		if($db->affected_rows()>0)
		{
			$siteid = $db->insert_id();
            $db->query("update ".TABLE_LINK." set `orderid`=$siteid where siteid=$siteid");
			showmessage('操作成功！',$referer);
		}
		else
		{
			showmessage('操作失败！请返回！');
		}
	}
	else
	{
		include admintpl('link_add');
	}
	break;

case 'edit':

	if($submit)
	{
		if(!ereg('^[01]+$',$linktype))
		{
			showmessage('非法参数！请返回！'); 
		}    

		$password=$password ? md5($password) : '';
		$query=$password ? "update ".TABLE_LINK." set linktype='$linktype',name='$name',url='$url',logo='$logo',introduction='$introduction',username='$username',email='$email',password='$password',elite='$elite',passed='$passed' where siteid='$siteid' and channelid='$channelid'" : "update ".TABLE_LINK." set linktype='$linktype',name='$name',url='$url',logo='$logo',introduction='$introduction',username='$username',email='$email',elite='$elite',passed='$passed' where siteid='$siteid' and channelid='$channelid'";
		$db->query($query);
		if($db->affected_rows()>0)
		{
			showmessage('操作成功！',$referer);
		}
		else
		{
			showmessage('操作失败！请返回！');
		}
	}
	else
	{
		$site=$db->get_one("select * from ".TABLE_LINK." where siteid='$siteid' and channelid='$channelid'");
		include admintpl('link_add');
	}
	break;

case 'updateorderid':

	if(empty($orderid) || !is_array($orderid))
	{
		showmessage('非法参数！请返回！');
	}

	foreach($orderid as $key=>$val)
	{
		$db->query("UPDATE ".TABLE_LINK." SET `orderid`='$val' WHERE siteid=$key AND channelid='$channelid'");
	}

	showmessage('排序更新成功！',$referer);

break;

case 'delete':

	if(empty($siteid))
	{
		showmessage('非法参数请返回！');
	}
	$siteids=is_array($siteid) ? implode(',',$siteid) : $siteid;
	$db->query("DELETE FROM ".TABLE_LINK." WHERE siteid IN ($siteids) and channelid='$channelid'");
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

	if(empty($siteid))
	{
		showmessage('非法参数！请返回！');
	}
	if(!ereg('^[0-1]+$',$passed))
	{
		showmessage('非法参数！请返回！');
	}
	$siteids=is_array($siteid) ? implode(',',$siteid) : $siteid;
	$db->query("UPDATE ".TABLE_LINK." SET passed=$passed WHERE siteid IN ($siteids) AND  channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
	break;


case 'elite':

	if(empty($siteid))
	{
		showmessage('非法参数！请返回！');
	}
	if(!ereg('^[0-1]+$',$elite))
	{
		showmessage('非法参数！请返回！');
	}
	$siteids=is_array($siteid) ? implode(',',$siteid) : $siteid;
	$db->query("UPDATE ".TABLE_LINK." SET elite=$elite WHERE siteid IN ($siteids) AND  channelid='$channelid'");
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

	$passed = isset($passed) ? $passed : "1";
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
		$condition .= " AND name LIKE '%$keyword' ";
	}
	$condition .= isset($linktype) ? " AND linktype='$linktype' " : "";
	$condition .= $elite ? " AND elite=1 " : "";

	$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_LINK." WHERE channelid='$channelid' $condition");
	$number=$r['num'];
	$url="?mod=".$mod."&file=".$file."&passed=".$passed."&keywords=".$keywords."&channelid=".$channelid;
	$pages=phppages($number,$page,$pagesize,$url);

	$result=$db->query("SELECT * FROM ".TABLE_LINK." WHERE channelid='$channelid' $condition ORDER by `orderid` LIMIT $offset,$pagesize");
	while($r=$db->fetch_array($result))
	{
		$r['adddate']=date("Y-m-d",$r['addtime']);
		$r['addtime']=date("Y-m-d H:i:s",$r['addtime']);
		$links[]=$r;
	}
	include admintpl('link_manage');
	break;
}
?>