<?php
defined('IN_PHPCMS') or exit('Access Denied');
@set_time_limit(0);

$channelid = intval($channelid);
$channelid or showmessage($LANG['invalid_parameters'], $referer);

$referer=isset($referer) ? $referer : "?mod=$mod&file=$file&channelid=$channelid";

if(isset($action) && strpos($action, ','))
{
	$actions=explode(',', $action);
	$action=$actions[0];
	unset($actions[0]);
	$actions=implode(',', $actions);
	$referer='?mod='.$mod.'&file='.$file.'&action='.$actions.'&channelid='.$channelid;
}

switch($action){
case 'database2txt'://所有文章数据库到文本

	if(!isset($fid))
	{
		$r=$db->get_one("select min(articleid) as fid from ".channel_table('article', $channelid));
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(articleid) as tid from ".channel_table('article', $channelid));
		$tid=$r['tid'];
	}
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		$query = "select articleid,content from ".channel_table('article_data', $channelid)." WHERE articleid>=$fid order by articleid limit 0,$pernum ";
		$result = $db->query($query);
		if($db->affected_rows($result) > 0)
		{
			while($r = $db->fetch_array($result))
			{
				$articleid = $r['articleid'];
				txt_update($channelid, $articleid, $r['content']);
			}
		}
		else
		{
			$articleid = $fid + $pernum;
		}
	}
	elseif($fid<$tid)
	{
		$query = "select articleid,content from ".channel_table('article_data', $channelid)." WHERE articleid>=$fid order by articleid limit 0,$pernum ";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$articleid = $r['articleid'];
			txt_update($channelid, $articleid, $r['content']);
		}
		showmessage($LANG['convert_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	else
	{
		showmessage($LANG['convert_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$articleid.'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
	showmessage('ID '.$LANG['from'].$fid.$LANG['to'].($fid+$pernum-1).$LANG['convert_success'], $referer);
	break;

case 'txt2database'://文本到数据库

	if(!isset($fid))
	{
		$r=$db->get_one("select min(articleid) as fid from ".channel_table('article', $channelid));
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(articleid) as tid from ".channel_table('article', $channelid));
		$tid=$r['tid'];
	}
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		for($i = $fid; $i <= $fid+$pernum; $i++)
		{
			$content = txt_read($channelid, $i);
			if($content)
			{
				$content = addslashes($content);
				$db->query("update ".channel_table('article_data', $channelid)." set content='$content' where articleid=$i ");
			}
		}
		$fid = $fid + $pernum;
	}
	elseif($fid<$tid)
	{
		for($i = $fid; $i <= $tid; $i++)
		{
			$content = txt_read($channelid, $i);
			if($content)
			{
				$content = addslashes($content);
				$db->query("update ".channel_table('article_data', $channelid)." set content='$content' where articleid=$i ");
			}
		}
		showmessage($LANG['convert_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	else
	{
		showmessage($LANG['convert_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$fid.'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
	showmessage('ID '.$LANG['from'].($fid-$pernum).$LANG['to'].($fid-1).$LANG['convert_success'], $referer);
	break;

case 'deltxt':
	if($MOD['storage_mode'] > 1) showmessage('无法进行此操作,请检查模块配置');
	dir_delete(PHPCMS_ROOT.'/data/'.$MOD['storage_dir'].'/'.$channelid.'/');
	showmessage('操作成功', $referer);
	break;

case 'deldatabase':
	if($MOD['storage_mode'] < 3) showmessage('无法进行此操作,请检查模块配置');
	$db->query("update ".channel_table('article_data', $channelid)." set content='' ");
	showmessage('操作成功', $referer);
	break;

case 'index':

	createhtml("index");
	showmessage($LANG['update_channel_homepage_success'], $referer);
	break;

case 'list'://栏目

	if(isset($catidss))
	{
		if(!is_array($catidss) && strpos($catidss, ','))
		{
			$catidss = explode(',', $catidss);
			$catids = $catidss[0];
			unset($catidss[0]);
			$catidss =  implode(',', $catidss);
			$referer = '?mod='.$mod.'&file='.$file.'&action='.$action.'&catidss='.$catidss.'&channelid='.$channelid;
		}
		else
		{
			$catids = $catidss;
		}
	}

	if(empty($catids) && !isset($catidss))
	{
		$catids = array();
		foreach($CATEGORY as $r)
		{
			$catids[]=$r['catid'];
		}
	}
	if(is_array($catids))
	{
		$catids = implode(',', $catids);
		showmessage($LANG['updating'].$LANG['category'],'?mod='.$mod.'&file='.$file.'&action='.$action.'&catidss='.$catids.'&channelid='.$channelid);
	}
	elseif(is_numeric($catids))
	{
		$catid = $catids;//
		createhtml('list');
		showmessage($LANG['category'].' ['.$CATEGORY[$catids]['catname'].'] '.$LANG['update_success'], $referer);
	}
	break;


case 'per_database'://分段更新栏目

	if(!$catid)
	{
		showmessage($LANG['please_select'], 'goback');
	}
	break;


default:

	$r=$db->get_one("select min(articleid) as minarticleid,max(articleid) as maxarticleid from ".channel_table('article', $channelid));
	$minarticleid=$r['minarticleid'];
	$maxarticleid=$r['maxarticleid'];
	unset($r);

	$submenu = array(
		array('<font color="red">'.$LANG['article'].$LANG['manage_homepage'].'</font>','?mod='.$mod.'&file='.$mod.'&channelid='.$channelid),
		array('<font color="blue">'.$LANG['filemanager'].'</font>','?mod=phpcms&file=filemanager&dir=./data/'.$MOD['storage_dir'].'/'.$channelid.'/'),
	);
	$menu=adminmenu($LANG['quit_update'],$submenu);
	include admintpl('txtdata');
	require_once MOD_ROOT."/include/article.class.php";
}
?>