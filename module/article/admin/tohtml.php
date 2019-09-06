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

$result=$db->query("select min(articleid) as minarticleid,max(articleid) as maxarticleid from ".TABLE_ARTICLE." where channelid='$channelid'",'CACHE');
$r=$db->fetch_array($result);
$minarticleid=$r[minarticleid];
$maxarticleid=$r[maxarticleid];

$skindir = $_CHA['skinid'] ? PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$_CHA['skinid'] : $skindir;//

$submenu=array(
	array('<font color="red">更新频道</font>','?mod='.$mod.'&file='.$file.'&action=index,category&channelid='.$channelid,'提示:点击将依次更新 频道首页->栏目列表'),
	array('更新频道首页','?mod='.$mod.'&file='.$file.'&action=index&channelid='.$channelid),
	array('更新栏目','?mod='.$mod.'&file='.$file.'&action=category&channelid='.$channelid),
	array('更新专题','?mod=phpcms&file='.$file.'&action=special,special_list,special_show&channelid='.$channelid."&referer=".$referer),
	array('更新文章','?mod='.$mod.'&file='.$file.'&action=article&fid='.$minarticleid.'&tid='.$maxarticleid.'&pernum=100&channelid='.$channelid)
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


case 'catarticle':

	if(empty($catid))
	{
		showmessage('非法参数！请返回！');
	}
	$catids=is_array($catid) ? implode(',',$catid) : $catid;
	$query="SELECT articleid FROM ".TABLE_ARTICLE." WHERE catid IN ($catids) and channelid='$channelid' ";
	$result=$db->query($query);
	while($r=$db->fetch_array($result))
	{
		$articleid=$r[articleid];
		tohtml("article");
	}
	showmessage('栏目文章更新成功！',$referer);
	break;

case 'articletohtml':

	if(empty($articleid))
	{
		showmessage('非法参数！请返回！@');
	}
	
	if(is_array($articleid))
	{
		foreach($articleid as $articleid)
		{
			tohtml("article");
		}
	}
	else
	{
		tohtml("article");
	}
	showmessage('文章更新成功！',$referer);
	break;

case 'article':
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
		for($articleid=$fid;$articleid<$fid+$pernum;$articleid++)
		{
			tohtml('article');
		}
	}
	elseif($fid<$tid)
	{
		for($articleid=$fid;$articleid<=$tid;$articleid++)
		{
			tohtml('article');
		}
	}
	else
	{
		showmessage('文章更新成功！','?mod='.$mod.'&file=tohtml&action=publish&channelid='.$channelid);
	}
	$referer='?mod='.$mod.'&file=tohtml&action=article&fid='.$articleid.'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
	showmessage('ID从 '.$fid.' 到 '.($fid+$pernum-1).' 的文章更新成功！',$referer);
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

	$result=$db->query("SELECT * FROM ".TABLE_SPECIAL." WHERE closed=0 AND channelid='$channelid' ORDER BY specialid DESC LIMIT 50");
	while($r=$db->fetch_array($result))
	{
		$r[adddate] = date('Y-m-d',$r[addtime]);
		$p->set_type("url");// 
		$r[url] = $p->get_specialitemurl($r[specialid],$r[addtime]);
		$p->set_type("path");
		$r[path] = $p->get_specialitemurl($r[specialid],$r[addtime]);
		$specials[] = $r;
	}

	include admintpl('tohtml');
}
?>