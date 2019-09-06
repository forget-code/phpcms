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

$pagesize=$_PHPCMS[pagesize];
$referer=$referer ? $referer : $PHP_REFERER;
$action=$action ? $action : 'manage';

$submenu=array(
	array('管理网页','?mod='.$mod.'&file='.$file.'&action=manage&channelid='.$channelid),
	array('添加网页','?mod='.$mod.'&file='.$file.'&action=add&channelid='.$channelid)
);
$menu=adminmenu('单网页管理',$submenu);

switch($action){

case 'add':

	if($submit)
	{
		if(!trim($title)) 
		{
			showmessage('您必须输入标题，请返回修改。');
		}

		if(!$linkurl && !trim($content)) 
		{
			showmessage('您必须输入内容，请返回修改。');
		}

		$filepath = ($path && $filename) ? $path.$filename : '';
		if(!$linkurl)
		{
			$query = "INSERT INTO ".TABLE_PAGE." (channelid,title,meta_title,meta_keywords,meta_description,content,templateid,skinid,addtime) VALUES ('$channelid','$title','$meta_title','$meta_keywords','$meta_description', '$content','$templateid','$skinid','$timestamp')";
		}
		else
		{
			$query = "INSERT INTO ".TABLE_PAGE." (channelid,title,linkurl,addtime) VALUES ('$channelid','$title','$linkurl','$timestamp')";
		}
		$db->query($query);

		$pageid=$db->insert_id();

		$db->query("UPDATE ".TABLE_PAGE." SET `orderid`=$pageid WHERE pageid='$pageid' AND channelid='$channelid' ");

		if(!$linkurl)
		{
			$path = $path ? $path : "page/";
			$filename = $filename ? $filename : "page_".$pageid.".html";
			$filepath = $path.$filename;
			$db->query("UPDATE ".TABLE_PAGE." SET filepath='$filepath' WHERE pageid='$pageid' AND channelid='$channelid' ");
			tohtml("page");
		}
        cache_definedpage($channelid);
		showmessage("操作成功！","?mod=".$mod."&file=".$file."&action=manage&channelid=".$channelid);
	}
	else
	{
		$showskin = showskin('skinid',$skinid);
		$showtpl = showtpl($mod,'page','templateid',$templateid);
		$path = "page/";
		$r = $db->get_one("select max(pageid) as maxpageid from ".TABLE_PAGE." where 1 limit 0,1");
		$pageid = $r[maxpageid] +1 ;
		$filename = "page_".$pageid.".html";
		include admintpl('page_add');
	}
     break;

case 'edit':

	if($submit)
	{
		if(!trim($title)) showmessage('您必须输入标题，请返回修改。');

        if($linkurl)
		{
			$db->query("UPDATE ".TABLE_PAGE." SET title='$title',linkurl='$linkurl',addtime='$timestamp' WHERE pageid='$pageid' AND channelid='$channelid'");
		}
		else
		{
			if(!trim($content)) showmessage('您必须输入内容，请返回修改。');
			preg_match("/^[0-9a-z\/]+$/i",$path) or showmessage("非法路径！");

            $r = $db->get_one("SELECT linkurl,filepath FROM ".TABLE_PAGE." WHERE pageid=$pageid");
			if( empty($r[linkurl]) ) $f->unlink(PHPCMS_ROOT."/".$r[filepath]);

			$path = $path ? $path : "page/";
			$filename = $filename ? $filename : "page_".$pageid.".html";
			$filepath = $path.$filename;
			$db->query("UPDATE ".TABLE_PAGE." SET title='$title',linkurl='',meta_title='$meta_title',meta_keywords='$meta_keywords',meta_description='$meta_description',content='$content',templateid='$templateid',skinid='$skinid',filepath='$filepath',addtime='$timestamp' WHERE pageid='$pageid' AND channelid='$channelid'");
			tohtml("page");
		}
        cache_definedpage($channelid);
		showmessage('操作成功！',$referer);
	}
	else
	{
		@extract($db->get_one("select * from ".TABLE_PAGE." where pageid='$pageid'"));
		$showskin = showskin('skinid',$skinid);
		$showtpl = showtpl($mod,'page','templateid',$templateid);
		$filename = basename($filepath);
		$path = str_replace($filename,'',$filepath);
		$display = $linkurl ? "none" : "block";
		include admintpl('page_add');
	}
     break;

case 'delete':

	if(empty($pageid))
	{
		showmessage('非法参数！请返回！');
	}
	if(is_array($pageid))
	{
		$id = $pageid;
		foreach($id as $i)
		{
			@extract($db->get_one("select filepath,linkurl from ".TABLE_PAGE." where pageid=$i and channelid=$channelid"));
			!$linkurl ? $f->unlink(PHPCMS_ROOT."/".$filepath) : '';
		}
	}
	else
	{
		@extract($db->get_one("select filepath,linkurl from ".TABLE_PAGE." where pageid=$pageid and channelid=$channelid"));
		!$linkurl ? $f->unlink(PHPCMS_ROOT."/".$filepath) : '';
	}

	$pageids=is_array($pageid) ? implode(',',$pageid) : $pageid;
	$db->query("DELETE FROM ".TABLE_PAGE." WHERE pageid IN ($pageids) and channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		cache_definedpage($channelid);
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
break;


case 'pass':

	if(empty($pageid))
	{
		showmessage('非法参数！请返回！',$referer);
	}
	if(!ereg('^[0-1]+$',$passed))
	{
		showmessage('非法参数！请返回！',$referer);
	}
	$pageids=is_array($pageid) ? implode(',',$pageid) : $pageid;
	$db->query("UPDATE ".TABLE_PAGE." SET passed=$passed WHERE pageid IN ($pageids) AND  channelid='$channelid'");
	if($db->affected_rows()>0)
	{
		cache_definedpage($channelid);
		showmessage('操作成功！',$referer);
	}
	else
	{
		showmessage('操作失败！请返回！');
	}
	break;

case 'tohtml':

	if(empty($pageid))
	{
		showmessage('非法参数！请返回！');
	}
	if(is_array($pageid))
	{
        $pageids = $pageid;
		foreach($pageids as $pageid)
		{
            tohtml("page");
		}
	}
	else
	{
        tohtml("page");
	}
	showmessage("网页更新成功！",$referer);
break;

case 'updateorderid':

	if(empty($orderid) || !is_array($orderid))
	{
		showmessage('非法参数！请返回！');
	}

	foreach($orderid as $key=>$val)
	{
		$db->query("UPDATE ".TABLE_PAGE." SET `orderid`='$val' WHERE pageid=$key AND channelid='$channelid'");
	}
    cache_definedpage($channelid);
	showmessage('排序更新成功！',$referer);

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

	$r = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_PAGE." WHERE channelid='$channelid'");
	$number = $r['num'];

	$url="?mod=".$mod."&file=page&channelid=".$channelid;
	$pages=phppages($number,$page,$pagesize,$url);

	$result=$db->query("SELECT * FROM ".TABLE_PAGE." WHERE channelid='$channelid' ORDER by `orderid` LIMIT $offset,$pagesize");
	while($r=$db->fetch_array($result))
	{
		$r['adddate']=date("Y-m-d",$r['addtime']);
		$r['url'] = $r['linkurl'] ? $r['linkurl'] : PHPCMS_SITEURL.$r['filepath'];
		$pg[]=$r;
	}
	include admintpl('page_manage');
	break;
}
?>