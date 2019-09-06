<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once PHPCMS_ROOT."/$mod/include/tag.func.php";
@set_time_limit(600);

$referer=isset($referer) ? $referer : "?mod=$mod&file=$file";
if(isset($action) && strpos($action, ','))
{
	$actions=explode(',',$action);
	$action=$actions[0];
	unset($actions[0]);
	$actions=implode(',',$actions);
	$referer='?mod='.$mod.'&file='.$file.'&action='.$actions;
}
switch($action){

case 'index':
	require_once PHPCMS_ROOT.'/include/tree.class.php';
    $tree = new tree;
	createhtml('search');
	createhtml("index");
	showmessage('房产首页更新成功',$referer);
	break;
case 'listinfo':
	if(!$infocat) showmessage('非法参数',$referer);
	createhtml("listinfo");
	showmessage($CAT[$infocat]['name'].'列表 '.$LANG['update_success'].'...',$referer);
	break;
case 'listinfos':
	if(isset($infocatss))
	{
		if(!is_array($infocatss) && strpos($infocatss, ','))
		{
			$infocatss = explode(',', $infocatss);
			$infocats = $infocatss[0];
			unset($infocatss[0]);
			$infocatss =  implode(',', $infocatss);
			$referer = '?mod='.$mod.'&file='.$file.'&action='.$action.'&infocatss='.$infocatss;
		}
		else
		{
			$infocats = $infocatss;
		}
	}

	if(empty($infocats) && !isset($infocatss))
	{
		$infocats = array(1,2,3,4,5,6);	
	}
	if(is_array($infocats))
	{
		$infocats = implode(',', $infocats);
		showmessage('正在更新列表...','?mod='.$mod.'&file='.$file.'&action='.$action.'&infocatss='.$infocats);
	}
	elseif(is_numeric($infocats))
	{
		$infocat = $infocats;
		createhtml("listinfo");
		showmessage($CAT[$infocat]['name'].$LANG['update_success'], $referer);
	}

case 'showinfo':
	
	if(!isset($fid))
	{
		$r=$db->get_one("select min(houseid) as fid from ".TABLE_HOUSE);
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(houseid) as tid from ".TABLE_HOUSE);
		$tid=$r['tid'];
	}
	$pernum = isset($pernum) ? intval($pernum) : 100 ;

	if($fid+$pernum < $tid)
	{
		for($houseid = $fid; $houseid < $fid + $pernum; $houseid++)
		{
			createhtml('showinfo');
		}
	}
	elseif($fid<$tid)
	{
		for($houseid = $fid; $houseid <= $tid; $houseid++)
		{
			createhtml('showinfo');
		}
	}
	else
	{
		showmessage('房产信息更新成功','?mod='.$mod.'&file='.$file);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$houseid.'&tid='.$tid.'&pernum='.$pernum;
	showmessage($LANG['id_from'].' '.$fid.' '.$LANG['to'].' '.($fid+$pernum-1).'房产信息更新成功',$referer);
	break;

case 'listdisplay':
	createhtml("listdisplay");
	showmessage('新楼盘列表更新成功',$referer);
	break;

case 'newhouse':
	if(!isset($fid))
	{
		$r=$db->get_one("select min(displayid) as fid from ".TABLE_HOUSE_DISPLAY);
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(displayid) as tid from ".TABLE_HOUSE_DISPLAY);
		$tid=$r['tid'];
	}
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		for($displayid = $fid; $displayid < $fid + $pernum; $displayid++)
		{
			createhtml('newhouse');
		}
	}
	elseif($fid<$tid)
	{
		for($displayid = $fid; $displayid <= $tid; $displayid++)
		{
			createhtml('newhouse');
		}
	}
	else
	{
		showmessage('新楼盘html更新成功','?mod='.$mod.'&file='.$file);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$displayid.'&tid='.$tid.'&pernum='.$pernum;
	showmessage($LANG['id_from'].' '.$fid.' '.$LANG['to'].' '.($fid+$pernum-1).'新楼盘更新成功',$referer);
	break;

	
case 'create_showinfo':
	if(empty($houseids))
	{
		showmessage($LANG['illegal_parameters'], 'goback');
	}	
	if(is_array($houseids))
	{
		foreach($houseids as $houseid)
		{
			createhtml('showinfo');
		}
	}
	else
	{
		$houseid = $houseids;
		createhtml('showinfo');
	}
	showmessage('指定的信息更新成功',$referer);
	break;
	
case 'create_newhouse':
	if(empty($displayids))
	{
		showmessage($LANG['illegal_parameters'], 'goback');
	}	
	if(is_array($displayids))
	{
		foreach($displayids as $displayid)
		{
			createhtml('newhouse');
		}
	}
	else
	{
		$displayidid = $displayidids;
		createhtml('newhouse');
	}
	showmessage('指定的新楼盘html更新成功', $referer);
	break;

case 'search':
	require_once PHPCMS_ROOT.'/include/tree.class.php';
    $tree = new tree;
	createhtml('search');
	showmessage('搜索框更新成功', $referer);
	break;

case 'urlinfo'://HOUSE更新地址

	if(!isset($fid))
	{
		$r=$db->get_one("select min(houseid) as fid from ".TABLE_HOUSE);
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(houseid) as tid from ".TABLE_HOUSE);
		$tid=$r['tid'];
	}
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		$query = "select houseid from ".TABLE_HOUSE." WHERE houseid>=$fid order by houseid limit 0,$pernum ";
		$result = $db->query($query);
		if($db->affected_rows($result) > 0)
		{
			while($r = $db->fetch_array($result))
			{
				$houseid = $r['houseid'];
				update_house_url($houseid);
			}
		}
		else
		{
			$houseid = $fid + $pernum;
		}
	}
	elseif($fid<$tid)
	{
		$query = "select houseid from ".TABLE_HOUSE." WHERE houseid>=$fid order by houseid limit 0,$pernum ";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$houseid = $r['houseid'];
			update_house_url($houseid);
		}
		showmessage('房产信息地址更新成功', $referer);
	}
	else
	{
		showmessage('房产信息地址更新成功', $referer);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$houseid.'&tid='.$tid.'&pernum='.$pernum;
	showmessage('ID '.$LANG['from'].$fid.' '.$LANG['to'].' '.($fid+$pernum-1).' 房产信息地址更新成功', $referer);
	break;

case 'urlhouse'://新楼盘信息更新地址

	if(!isset($fid))
	{
		$r=$db->get_one("select min(displayid) as fid from ".TABLE_HOUSE_DISPLAY);
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(displayid) as tid from ".TABLE_HOUSE_DISPLAY);
		$tid=$r['tid'];
	}
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		$query = "select displayid from ".TABLE_HOUSE_DISPLAY." WHERE displayid>=$fid order by displayid limit 0,$pernum ";
		$result = $db->query($query);
		if($db->affected_rows($result) > 0)
		{
			while($r = $db->fetch_array($result))
			{
				$displayid = $r['displayid'];
				update_display_url($displayid);
			}
		}
		else
		{
			$displayid = $fid + $pernum;
		}
	}
	elseif($fid<$tid)
	{
		$query = "select displayid from ".TABLE_HOUSE_DISPLAY." WHERE displayid>=$fid order by displayid limit 0,$pernum ";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$displayid = $r['displayid'];
			update_display_url($displayid);
		}
		showmessage('新楼盘信息地址更新成功', $referer);
	}
	else
	{
		showmessage('新楼盘信息地址更新成功', $referer);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$displayid.'&tid='.$tid.'&pernum='.$pernum;
	showmessage('ID '.$LANG['from'].$fid.' '.$LANG['to'].' '.($fid+$pernum-1).' 新楼盘信息地址更新成功', $referer);
	break;

default:

	$r=$db->get_one("select min(houseid) as minhouseid,max(houseid) as maxhouseid from ".TABLE_HOUSE);
	$minhouseid=$r['minhouseid'];
	$maxhouseid=$r['maxhouseid'];
	$r=$db->get_one("select min(displayid) as mindisplayid,max(displayid) as maxdisplayid from ".TABLE_HOUSE_DISPLAY);
	$mindisplayid=$r['mindisplayid'];
	$maxdisplayid=$r['maxdisplayid'];
	unset($r);
	$INFOtype = array();
	foreach ($PARS['infotype'] as $k=>$v)
	{
		if(strpos($k,'type_')>-1)
		{
			$INFOtype[] = $v;
		}
	}
	
	$submenu=array(
	array('生成房产首页','?mod='.$mod.'&file='.$file.'&action=index'),
	array('生成房产列表','?mod='.$mod.'&file='.$file.'&action=listinfos'),
	array('生成房产信息','?mod='.$mod.'&file='.$file.'&action=showinfo'),
	array('生成新楼盘列表','?mod='.$mod.'&file='.$file.'&action=listdisplay'),
	array('生成新楼盘信息','?mod='.$mod.'&file='.$file.'&action=newhouse'),
	array('生成搜索框','?mod='.$mod.'&file='.$file.'&action=search'),
	);
	$menu=adminmenu($LANG['quick_update'],$submenu);	
	include admintpl('createhtml');
}
?>