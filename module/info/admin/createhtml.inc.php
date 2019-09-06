<?php
defined('IN_PHPCMS') or exit('Access Denied');

@set_time_limit(600);

$channelid = intval($channelid);
$channelid or showmessage($LANG['illegal_parameters'], $referer);

require_once PHPCMS_ROOT.'/module/'.$mod.'/include/global.func.php';
require_once PHPCMS_ROOT.'/module/'.$mod.'/include/area.class.php';

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

case 'index':

	createhtml("index");
	showmessage($LANG['channel_home_update_success'], $referer);
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
		showmessage($LANG['begin_update_category'].'...','?mod='.$mod.'&file='.$file.'&action='.$action.'&catidss='.$catids.'&channelid='.$channelid);
	}
	elseif(is_numeric($catids))
	{
		$catid = $catids;//
		createhtml('list');
		showmessage($LANG['category'].' ['.$CATEGORY[$catids]['catname'].'] '.$LANG['update_success'], $referer);
	}
	break;


case 'per_list'://分段更新栏目

	if(!$catid)
	{
		showmessage($LANG['select_category'], 'goback');
	}
	if(!$CATEGORY[$catid]['ishtml'])//不生成 直接跳出
	{
		showmessage($LANG['category'].' ['.$CATEGORY[$catid]['catname'].'] '.$LANG['update_success'].'...', '?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	if($CATEGORY[$catid]['child'])
	{
		showmessage($LANG['begin_update_category'].'...','?mod='.$mod.'&file='.$file.'&action=list&catids='.$catid.'&channelid='.$channelid);
	}
	if(!isset($tid))
	{
		$CAT = cache_read('category_'.$catid.'.php');
		$tid = ceil($CAT['items']/$CAT['maxperpage']);
	}
	$pernum = isset($pernum) ? $pernum : 50;
	$fid = isset($fid) ? $fid+$pernum : 1;
	if($fid < $tid)
	{
		createhtml('list');
		$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&catid='.$catid.'&fid='.$fid.'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
		showmessage($LANG['id_from'].' '.$fid.' '.$LANG['to'].' '.($fid+$pernum-1).' '.$LANG['update_success'], $referer);
	}
	else
	{
		showmessage($LANG['category'].' ['.$CATEGORY[$catid]['catname'].'] '.$LANG['update_success'].'...', '?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}

	break;

case 'show'://所有信息

	if(!isset($fid))
	{
		$r=$db->get_one("select min(infoid) as fid from ".channel_table('info', $channelid));
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(infoid) as tid from ".channel_table('info', $channelid));
		$tid=$r['tid'];
	}
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		$query = "select infoid from ".channel_table('info', $channelid)." WHERE status=3 and ishtml=1 and islink=0 and infoid>=$fid order by infoid limit 0,$pernum ";
		$result = $db->query($query);
		if($db->affected_rows($result) > 0)
		{
			while($r = $db->fetch_array($result))
			{
				$infoid = $r['infoid'];
				createhtml('show');
			}
		}
		else
		{
			$infoid = $fid + $pernum;
		}
	}
	elseif($fid<$tid)
	{
		$query = "select infoid from ".channel_table('info', $channelid)." WHERE status=3 and ishtml=1 and islink=0 and infoid>=$fid order by infoid limit 0,$pernum ";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$infoid = $r['infoid'];
			createhtml('show');
		}
		showmessage($LANG['info_update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	else
	{
		showmessage($LANG['info_update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$infoid.'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
	showmessage($LANG['id_from'].' '.$fid.' '.$LANG['to'].' '.($fid+$pernum-1).' '.$LANG['info_update_success'], $referer);
	break;

case 'create_show'://信息

	if(empty($infoids))
	{
		showmessage($LANG['select_your_info'], 'goback');
	}
	
	if(is_array($infoids))
	{
		foreach($infoids as $infoid)
		{
			createhtml("show");
		}
	}
	else
	{
		$infoid = $infoids;
		createhtml("show");
	}
	showmessage($LANG['info_update_success'],$referer);
	break;

case 'cat_show'://栏目信息

	if(empty($catids))
	{
		showmessage($LANG['illegal_parameters'], 'goback');
	}
	$catids = is_array($catids) ? implode(',',$catids) : $catids;
	$query = "SELECT infoid FROM ".channel_table('info', $channelid)." WHERE catid IN ($catids) and status=3 and ishtml=1 and islink=0 ";
	$result=$db->query($query);
	while($r=$db->fetch_array($result))
	{
		$infoid=$r['infoid'];
		createhtml("show");
	}
	showmessage($LANG['category_info_update_success'],$referer);
	break;

case 'per_show'://分段栏目信息

	if(!$catid)
	{
		showmessage($LANG['select_category'], 'goback');
	}
	if(!isset($fid))
	{
		$r=$db->get_one("select min(infoid) as fid from ".channel_table('info', $channelid)." WHERE catid=$catid and status=3 and ishtml=1 and islink=0 ");
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(infoid) as tid from ".channel_table('info', $channelid)." WHERE catid=$catid and status=3 and ishtml=1 and islink=0 ");
		$tid=$r['tid'];
	}
	$fid && $tid or showmessage($LANG['update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		$query = "select infoid from ".channel_table('info', $channelid)." WHERE catid=$catid  and status=3 and ishtml=1 and islink=0 and infoid>=$fid order by infoid limit 0,$pernum ";
		$result = $db->query($query);
		if($db->affected_rows($result) > 0)
		{
			while($r = $db->fetch_array($result))
			{
				$infoid = $r['infoid'];
				createhtml('show');
			}
		}
		else
		{
			$infoid = $fid + $pernum;
		}
	}
	elseif($fid < $tid)
	{
		$query = "select infoid from ".channel_table('info', $channelid)." WHERE catid=$catid  and status=3 and ishtml=1 and islink=0 and infoid>=$fid order by infoid limit 0,$pernum ";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$infoid = $r['infoid'];
			createhtml('show');
		}
		showmessage($LANG['category'].' ['.$CATEGORY[$catid]['catname'].']'.$LANG['info_update_success'], '?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	else
	{
		showmessage($LANG['category'].' ['.$CATEGORY[$catid]['catname'].']'.$LANG['info_update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&catid='.$catid.'&fid='.($infoid+1).'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
	showmessage($LANG['id_from'].' '.$fid.' '.$LANG['to'].' '.($fid+$pernum-1).' '.$LANG['info_update_success'],$referer);
	break;

case 'update_url'://地址

	if(empty($infoids))
	{
		showmessage($LANG['select_your_info'], 'goback');
	}
	
	if(is_array($infoids))
	{
		foreach($infoids as $infoid)
		{
			update_info_url($infoid);
		}
	}
	else
	{
		$infoid = $infoids;
		update_info_url($infoid);
	}
	showmessage($LANG['info_linkurl_update_success'],$referer);
	break;

case 'url'://更新地址

	if(!isset($fid))
	{
		$r=$db->get_one("select min(infoid) as fid from ".channel_table('info', $channelid));
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(infoid) as tid from ".channel_table('info', $channelid));
		$tid=$r['tid'];
	}
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		$query = "select infoid from ".channel_table('info', $channelid)." WHERE status=3 and infoid>=$fid order by infoid limit 0,$pernum ";
		$result = $db->query($query);
		if($db->affected_rows($result) > 0)
		{
			while($r = $db->fetch_array($result))
			{
				$infoid = $r['infoid'];
				update_info_url($infoid);
			}
		}
		else
		{
			$infoid = $fid + $pernum;
		}
	}
	elseif($fid<$tid)
	{
		$query = "select infoid from ".channel_table('info', $channelid)." WHERE status=3 and infoid>=$fid order by infoid limit 0,$pernum ";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$infoid = $r['infoid'];
			update_info_url($infoid);
		}
		showmessage($LANG['info_linkurl_update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	else
	{
		showmessage($LANG['info_linkurl_update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$infoid.'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
	showmessage($LANG['id_from'].' '.$fid.' '.$LANG['to'].' '.($fid+$pernum-1).' '.$LANG['info_linkurl_update_success'], $referer);
	break;

case 'create_dir'://创建目录

	if(empty($catids))
	{
		$catids = array();
		foreach($CATEGORY as $r)
		{
			$catids[]=$r['catid'];
		}
	}

	if(is_array($catids))
	{
		foreach($catids as $catids)
		{
			if($CATEGORY[$catids]['islink'] || !$CATEGORY[$catids]['ishtml']) continue;
			$filename = PHPCMS_ROOT.'/'.cat_url('url', $catids);
			$filepath = dirname($filename);
			if(!is_dir($filepath)) dir_create($filepath);
		}
	}
	else
	{
		if(!$CATEGORY[$catids]['islink'] || $CATEGORY[$catids]['ishtml']) 
		$filename = PHPCMS_ROOT.'/'.cat_url('url', $catids);
		$filepath = dirname($filename);
		if(!is_dir($filepath)) dir_create($filepath);
	}
	showmessage($LANG['dir_create_success'],$referer);
	break;

case 'delete_dir'://删除目录

	if(empty($catids))
	{
		$catids = array();
		foreach($CATEGORY as $r)
		{
			$catids[]=$r['catid'];
		}
	}

	if(is_array($catids))
	{
		foreach($catids as $catids)
		{
			if($CATEGORY[$catids]['islink'] || !$CATEGORY[$catids]['ishtml']) continue;
			$filename = PHPCMS_ROOT.'/'.cat_url('url', $catids);
			$filepath = dirname($filename);
			if(is_dir($filepath) && $filepath > PHPCMS_ROOT.'/'.$mod) dir_delete($filepath);
		}
	}
	else
	{
		if(!$CATEGORY[$catids]['islink'] || $CATEGORY[$catids]['ishtml']) 
		$filename = PHPCMS_ROOT.'/'.cat_url('url', $catids);
		$filepath = dirname($filename);
		if(is_dir($filepath) && $filepath > PHPCMS_ROOT.'/'.$mod) dir_delete($filepath);
	}
	showmessage($LANG['dir_delete_success'], $referer);
	break;



default:

	$r=$db->get_one("select min(infoid) as mininfoid,max(infoid) as maxinfoid from ".channel_table('info', $channelid));
	$mininfoid=$r['mininfoid'];
	$maxinfoid=$r['maxinfoid'];
	unset($r);

	$submenu=array(
	array('<font color="red">'.$LANG['info_home'].'</font>','?mod='.$mod.'&file='.$mod.'&channelid='.$channelid),
	array('<font color="blue">'.$LANG['update_channel'].'</font>','?mod='.$mod.'&file='.$file.'&action=index,list,show&channelid='.$channelid,$LANG['tips'].$LANG['click_to_update_followed'].' '.$LANG['channel_home'].'->'.$LANG['category_list']),
	array($LANG['channel_home_updating'],'?mod='.$mod.'&file='.$file.'&action=index&channelid='.$channelid),
	array($LANG['generate_category'],'?mod='.$mod.'&file='.$file.'&action=list&channelid='.$channelid),
	array($LANG['update_info'],'?mod='.$mod.'&file='.$file.'&action=show&fid='.$mininfoid.'&tid='.$maxinfoid.'&pernum=100&channelid='.$channelid),
	);
	$menu=adminmenu($LANG['quick_update'],$submenu);

	require_once PHPCMS_ROOT.'/include/tree.class.php';
	require_once PHPCMS_ROOT.'/admin/include/category_channel.class.php';
	$tree = new tree;
	$cat = new category_channel($channelid);

	$category_select = category_select('catid', $LANG['select_category']);
	$list = $cat->get_list();
	if(is_array($list))
	{
		$categorys = array();
		foreach($list as $catid => $category)
		{
			if($category['islink']) continue;
			$module = $CHA['module'];
			$linkurl = $category['linkurl'];
			$catdir = $category['islink'] ? "<a href='$linkurl' title='".$LANG['click_view']."' target='_blank'>".str_cut($linkurl,20)."</a>" : "<a href='$linkurl' title='".$LANG['click_view']."' target='_blank'>".$category['catdir']."</a>";
			$name = style($category['catname'], $category['style']);
			if(!$category['ishtml'] || is_dir(dirname(PHPCMS_ROOT.'/'.cat_url('path', $category['catid']))))
			{
				$is_dir = $LANG['yes'];
			}
			else
			{
				$is_dir = "<a href=\"?mod=$mod&file=$file&action=createdir&catid=$catid&channelid=$channelid\"><font color=\"red\">".$LANG['no']."</font></a>";
			}
			$categorys[$category['catid']] = array('id'=>$category['catid'],'parentid'=>$category['parentid'],'catdir'=>$catdir,'listorder'=>$category['listorder'],'name'=>$name,'mod'=>$mod,'channelid'=>$channelid,'file'=>$file, 'is_dir'=>$is_dir);
		}
		$str = "<tr align='center' align='center' onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5' height='23'>
					<td><input type='checkbox' name='catids[]' value='\$id'></td>
					<td>\$id</td>
					<td align='left'>\$spacer\$name</td>
					<td>\$catdir</td>
					<td>\$is_dir</td>
					<td> <a href='?mod=\$mod&file=\$file&action=per_list&catid=\$id&channelid=\$channelid'>".$LANG['generate_category_list']."</a> | <a href='?mod=\$mod&file=\$file&action=per_show&catid=\$id&channelid=\$channelid'>".$LANG['generate_info']."</a> | <a href='?mod=\$mod&file=\$file&action=create_dir&catids=\$id&channelid=\$channelid'>".$LANG['generate_category_directory']."</a> </td>
				</tr>";
		$tree->tree($categorys);
		$categorys = $tree->get_tree(0,$str);
	}

	include admintpl('createhtml');
	require_once MOD_ROOT."/include/info.class.php";
	$inf = new info($channelid);
	$inf->update();
}
?>