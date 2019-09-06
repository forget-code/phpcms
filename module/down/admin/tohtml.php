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
defined('IN_PHPCMS') or exit('Access Denied');

if(!ereg('^[0-9]+$',$channelid))
{
	showmessage('非法参数！请返回！',$referer);
}

$result=$db->query("select min(downid) as mindownid,max(downid) as maxdownid from ".TABLE_DOWN." where channelid='$channelid'",'CACHE');
$r=$db->fetch_array($result);
$mindownid=$r[mindownid];
$maxdownid=$r[maxdownid];

$skindir = $_CHA['skinid'] ? PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$_CHA['skinid'] : $skindir;//

$submenu=array(
	array('<font color="red">更新频道</font>','?mod='.$mod.'&file='.$file.'&action=index,category&channelid='.$channelid,'提示:点击将依次更新 频道首页->栏目列表'),
	array('更新频道首页','?mod='.$mod.'&file='.$file.'&action=index&channelid='.$channelid),
	array('更新栏目','?mod='.$mod.'&file='.$file.'&action=category&channelid='.$channelid),
	array('更新专题','?mod=phpcms&file='.$file.'&action=special,special_list,special_show&channelid='.$channelid."&referer=".$referer),
	array('更新下载信息','?mod='.$mod.'&file='.$file.'&action=down&fid='.$mindownid.'&tid='.$maxdownid.'&pernum=100&channelid='.$channelid)
);
$menu=adminmenu('快捷更新',$submenu);

@set_time_limit(600);

$tree = new tree;

$referer=$referer ? $referer : '?mod='.$mod.'&file=tohtml&action=publish&channelid='.$channelid;

if(strpos($action,','))
{
	$actions=explode(',',$action);
	$action=$actions[0];
	unset($actions[0]);
	$actions=implode(',',$actions);
	parse_str($_SERVER['QUERY_STRING'],$strings);
	unset($strings[action]);
	$referer='';
	foreach($strings as $key=>$value)
	{
		$referer.='&'.$key.'='.$value;
	}
	$referer="?mod=".$mod."&file=tohtml&action=".$actions.$referer;
}

switch($action){

case 'index':

	tohtml("index");
	showmessage('频道首页更新成功！',$referer);
	break;

case 'category':

	if(empty($catid))
	{
		foreach($_CAT as $r)
		{
			$catid[]=$r[catid];
		}
	}
	
	if(is_array($catid))
	{
		foreach($catid as $catid)
		{
			tohtml("category");
		}
	}
	else
	{
		tohtml("category");
	}
	showmessage('栏目更新成功！',$referer);
	break;

case 'catdown':

	if(empty($catid))
	{
		showmessage('非法参数！请返回！');
	}
	$catids=is_array($catid) ? implode(',',$catid) : $catid;
	$query="SELECT downid FROM ".TABLE_DOWN." WHERE catid IN ($catids) and channelid='$channelid'";
		while($r = $db->fetch_array($result));
	$result=$db->query($query);
	while($r=$db->fetch_array($result))
	{
		$downid=$r[downid];
		tohtml("down");
	}
	showmessage('栏目下载信息更新成功！',$referer);
	break;

case 'downtohtml':

	if(empty($downid))
	{
		showmessage('非法参数！请返回！@');
	}
	
	if(is_array($downid))
	{
		foreach($downid as $downid)
		{
			tohtml("down");
		}
	}
	else
	{
		tohtml("down");
	}
	showmessage('下载更新成功！',$referer);
	break;

case 'down':
	if(!ereg('^[0-9]+$',$fid))
	{
		showmessage('非法参数！请返回！');
	}
	if(!ereg('^[0-9]+$',$tid))
	{
		showmessage('非法参数！请返回！');
	}
	if(!ereg('^[0-9]+$',$pernum))
	{
		showmessage('非法参数！请返回！');
	}
	if($pernum<1)
	{
		showmessage('非法参数！请返回！');
	}
	if($fid+$pernum<$tid)
	{
		for($downid=$fid;$downid<$fid+$pernum;$downid++)
		{
			tohtml('down');
		}
	}
	elseif($fid<$tid)
	{
		for($downid=$fid;$downid<=$tid;$downid++)
		{
			tohtml('down');
		}
	}
	else
	{
		showmessage('下载信息更新成功！','?mod='.$mod.'&file=tohtml&action=publish&channelid='.$channelid);
	}
	$referer='?mod='.$mod.'&file=tohtml&action=down&fid='.$downid.'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
	showmessage('ID从 '.$fid.' 到 '.($fid+$pernum-1).' 的下载信息更新成功！',$referer);
	break;

case 'createcatdir':

	if(empty($catid))
	{
		showmessage('非法参数！请返回！');
	}
	$p->set_type("path");
	if(is_array($catid))
	{
		foreach($catid as $catid)
		{
			$p->set_catid($catid);
			$f->create($p->get_caturl());
		}
	}
	else
	{
		$p->set_catid($catid);
		$f->create($p->get_caturl());
	}
	showmessage('操作成功！',$referer);
	break;

case 'deletecatdir':

	if(empty($catid))
	{
		showmessage('非法参数！请返回！');
	}
	$p->set_type("path");
	if(is_array($catid))
	{
		foreach($catid as $catid)
		{
			$p->set_catid($catid);
			$f->delete($p->get_caturl());
		}
	}
	else
	{
		$p->set_catid($catid);
		$f->delete($p->get_caturl());
	}
	showmessage('目录删除成功！',$referer);
	break;

case 'cache':

	cache_category($channelid);
	showmessage('缓存更新成功！',$referer);
	break;

case 'publish':

	$sql="SELECT * FROM ".TABLE_SPECIAL." WHERE closed=0 and channelid='$channelid' $condition ORDER BY specialid DESC LIMIT 50";
	$result=$db->query($sql);
	while($r=$db->fetch_array($result))
	{
		$r[adddate] = date('Y-m-d',$r[addtime]);
		$p->set_type("url");
		$r[url] = $p->get_specialitemurl($r[specialid],$r[addtime]);
		$p->set_type("path");
		$r[path] = $p->get_specialitemurl($r[specialid],$r[addtime]);
		$specials[] = $r;
	}
	include admintpl('tohtml');
}
?>