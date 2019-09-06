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

$result=$db->query("select min(pictureid) as minpictureid,max(pictureid) as maxpictureid from ".TABLE_PICTURE." where channelid='$channelid'",'CACHE');
$r=$db->fetch_array($result);
$minpictureid=$r[minpictureid];
$maxpictureid=$r[maxpictureid];

$submenu=array(
	array('更新频道','?mod='.$mod.'&file='.$file.'&action=index,category&channelid='.$channelid,'提示:点击将依次更新 频道首页->栏目列表'),
	array('更新频道首页','?mod='.$mod.'&file='.$file.'&action=index&channelid='.$channelid),
	array('更新栏目','?mod='.$mod.'&file='.$file.'&action=category&channelid='.$channelid),
	array('更新专题','?mod=phpcms&file='.$file.'&action=special,special_list,special_show&channelid='.$channelid),
    array('更新图片','?mod='.$mod.'&file='.$file.'&action=picture&fid='.$minpictureid.'&tid='.$maxpictureid.'&pernum=100&channelid='.$channelid)
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

case 'catpicture':

	if(empty($catid))
	{
		showmessage('非法参数！请返回！');
	}
	$catids=is_array($catid) ? implode(',',$catid) : $catid;
	$query="SELECT pictureid FROM ".TABLE_PICTURE." WHERE catid IN ($catids)";
	$result=$db->query($query);
	while($r=$db->fetch_array($result))
	{
		$pictureid=$r[pictureid];
		tohtml("picture");
	}
	showmessage('栏目图片更新成功！',$referer);
	break;

//生成图片
case 'picturetohtml':
	if(empty($pictureid))
	{
		showmessage('请选择要生成的图片！');
	}
	
	if(is_array($pictureid))
	{
		$pictureids=$pictureid;
		$i=0;
		foreach($pictureids as $pictureid)
		{
			tohtml('picture');
		}
	}
	else
	{
		tohtml('picture');
	}
	showmessage("生成图片成功！",$referer);
break;

case 'picture':
	if(!ereg('^[0-9]+$',$fid))
	{
		showmessage('非法参数1！请返回！');
	}
	if(!ereg('^[0-9]+$',$tid))
	{
		showmessage('非法参数2！请返回！');
	}
	if(!ereg('^[0-9]+$',$pernum))
	{
		showmessage('非法参数3！请返回！');
	}
	if($pernum<1)
	{
		showmessage('非法参数4！请返回！');
	}
	if($fid+$pernum<$tid)
	{
		for($pictureid=$fid;$pictureid<$fid+$pernum;$pictureid++)
		{
			tohtml('picture');
		}
	}
	elseif($fid<$tid)
	{
		for($pictureid=$fid;$pictureid<=$tid;$pictureid++)
		{
			tohtml('picture');
		}
	}
	else
	{
		showmessage('图片更新成功！','?mod='.$mod.'&file=tohtml&action=publish&channelid='.$channelid);
	}
	$referer='?mod='.$mod.'&file=tohtml&action=picture&fid='.$pictureid.'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
	showmessage('ID从 '.$fid.' 到 '.($fid+$pernum-1).' 的图片更新成功！',$referer);
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