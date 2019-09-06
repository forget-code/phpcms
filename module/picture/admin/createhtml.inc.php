<?php
defined('IN_PHPCMS') or exit('Access Denied');

@set_time_limit(600);

$channelid = intval($channelid);
$channelid or showmessage($LANG['illegal_parameters'], $referer);

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

	if(isset($_SESSION['temp_cat_name'.$mod]))
	{
		include PHPCMS_ROOT.'/data/temp/'.$_SESSION['temp_cat_name'.$mod];
		$catids = array_shift($cats_array);
		if(!$catids)
		{
			unlink(PHPCMS_ROOT.'/data/temp/'.$_SESSION['temp_cat_name'.$mod]);
			unset($_SESSION['temp_cat_name'.$mod]);
			showmessage($LANG['update_success'],'?mod='.$mod.'&file=createhtml&channelid='.$channelid);
		}
		array_save($cats_array,"\$cats_array",PHPCMS_ROOT.'/data/temp/'.$_SESSION['temp_cat_name'.$mod]);
		$referer = '?mod='.$mod.'&file='.$file.'&action='.$action.'&channelid='.$channelid;
	}
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
		$_SESSION['temp_cat_name'.$mod] = 'T'.$PHP_TIME.'.php';
		array_save($catids,"\$cats_array",PHPCMS_ROOT.'/data/temp/'.$_SESSION['temp_cat_name'.$mod]);
		showmessage($LANG['updating'].$LANG['category'],'?mod='.$mod.'&file='.$file.'&action='.$action.'&channelid='.$channelid);
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
		showmessage($LANG['label'].' ['.$CATEGORY[$catid]['catname'].'] '.$LANG['update_success'].'...', '?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
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

case 'show'://所有图片

	if(!isset($fid))
	{
		$r=$db->get_one("select min(pictureid) as fid from ".channel_table('picture', $channelid));
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(pictureid) as tid from ".channel_table('picture', $channelid));
		$tid=$r['tid'];
	}
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		$query = "select pictureid from ".channel_table('picture', $channelid)." WHERE status=3 and ishtml=1 and islink=0 and pictureid>=$fid order by pictureid limit 0,$pernum ";
		$result = $db->query($query);
		if($db->affected_rows($result) > 0)
		{
			while($r = $db->fetch_array($result))
			{
				$pictureid = $r['pictureid'];
				createhtml('show');
			}
		}
		else
		{
			$pictureid = $fid + $pernum;
		}
	}
	elseif($fid<$tid)
	{
		$query = "select pictureid from ".channel_table('picture', $channelid)." WHERE status=3 and ishtml=1 and islink=0 and pictureid>=$fid order by pictureid limit 0,$pernum ";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$pictureid = $r['pictureid'];
			createhtml('show');
		}
		showmessage($LANG['picture_update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	else
	{
		showmessage($LANG['picture_update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$pictureid.'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
	showmessage($LANG['id_from'].' '.$fid.' '.$LANG['to'].' '.($fid+$pernum-1).' '.$LANG['picture_update_success'], $referer);
	break;

case 'create_show'://图片

	if(empty($pictureids))
	{
		showmessage($LANG['select_picture_return'], 'goback');
	}
	
	if(is_array($pictureids))
	{
		foreach($pictureids as $pictureid)
		{
			createhtml("show");
		}
	}
	else
	{
		$pictureid = $pictureids;
		createhtml("show");
	}
	showmessage($LANG['picture_update_success'],$referer);
	break;

case 'cat_show'://栏目图片

	if(empty($catids))
	{
		showmessage($LANG['illegal_parameters'], 'goback');
	}
	$catids = is_array($catids) ? implode(',',$catids) : $catids;
	$query = "SELECT pictureid FROM ".channel_table('picture', $channelid)." WHERE catid IN ($catids) and status=3 and ishtml=1 and islink=0 ";
	$result=$db->query($query);
	while($r=$db->fetch_array($result))
	{
		$pictureid=$r['pictureid'];
		createhtml("show");
	}
	showmessage($LANG['category'].$LANG['picture_update_success'],$referer);
	break;

case 'per_show'://分段栏目图片

	if(!$catid)
	{
		showmessage($LANG['select_category'], 'goback');
	}
	if(!isset($fid))
	{
		$r=$db->get_one("select min(pictureid) as fid from ".channel_table('picture', $channelid)." WHERE catid=$catid and status=3 and ishtml=1 and islink=0 ");
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(pictureid) as tid from ".channel_table('picture', $channelid)." WHERE catid=$catid and status=3 and ishtml=1 and islink=0 ");
		$tid=$r['tid'];
	}
	$fid && $tid or showmessage($LANG['update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		$query = "select pictureid from ".channel_table('picture', $channelid)." WHERE catid=$catid  and status=3 and ishtml=1 and islink=0 and pictureid>=$fid order by pictureid limit 0,$pernum ";
		$result = $db->query($query);
		if($db->affected_rows($result) > 0)
		{
			while($r = $db->fetch_array($result))
			{
				$pictureid = $r['pictureid'];
				createhtml('show');
			}
		}
		else
		{
			$pictureid = $fid + $pernum;
		}
	}
	elseif($fid < $tid)
	{
		$query = "select pictureid from ".channel_table('picture', $channelid)." WHERE catid=$catid  and status=3 and ishtml=1 and islink=0 and pictureid>=$fid order by pictureid limit 0,$pernum ";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$pictureid = $r['pictureid'];
			createhtml('show');
		}
		showmessage($LANG['category'].' ['.$CATEGORY[$catid]['catname'].']'.$LANG['picture_update_success'], '?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	else
	{
		showmessage($LANG['category'].' ['.$CATEGORY[$catid]['catname'].']'.$LANG['picture_update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&catid='.$catid.'&fid='.($pictureid+1).'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
	showmessage($LANG['id_from'].' '.$fid.' '.$LANG['to'].' '.($fid+$pernum-1).' '.$LANG['picture_update_success'],$referer);
	break;

case 'update_url'://地址

	if(empty($pictureids))
	{
		showmessage($LANG['select_picture_return'], 'goback');
	}
	
	if(is_array($pictureids))
	{
		foreach($pictureids as $pictureid)
		{
			update_picture_url($pictureid);
		}
	}
	else
	{
		$pictureid = $pictureids;
		update_picture_url($pictureid);
	}
	showmessage($LANG['picture_address_update_success'],$referer);
	break;

case 'url'://更新地址

	if(!isset($fid))
	{
		$r=$db->get_one("select min(pictureid) as fid from ".channel_table('picture', $channelid));
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(pictureid) as tid from ".channel_table('picture', $channelid));
		$tid=$r['tid'];
	}
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		$query = "select pictureid from ".channel_table('picture', $channelid)." WHERE status=3 and pictureid>=$fid order by pictureid limit 0,$pernum ";
		$result = $db->query($query);
		if($db->affected_rows($result) > 0)
		{
			while($r = $db->fetch_array($result))
			{
				$pictureid = $r['pictureid'];
				update_picture_url($pictureid);
			}
		}
		else
		{
			$pictureid = $fid + $pernum;
		}
	}
	elseif($fid<$tid)
	{
		$query = "select pictureid from ".channel_table('picture', $channelid)." WHERE status=3 and pictureid>=$fid order by pictureid limit 0,$pernum ";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$pictureid = $r['pictureid'];
			update_picture_url($pictureid);
		}
		showmessage($LANG['picture_address_update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	else
	{
		showmessage($LANG['picture_address_update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$pictureid.'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
	showmessage($LANG['id_from'].' '.$fid.' '.$LANG['to'].' '.($fid+$pernum-1).' '.$LANG['picture_address_update_success'], $referer);
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

	$r=$db->get_one("select min(pictureid) as minpictureid,max(pictureid) as maxpictureid from ".channel_table('picture', $channelid));
	$minpictureid=$r['minpictureid'];
	$maxpictureid=$r['maxpictureid'];
	unset($r);

	$submenu=array(
	array('<font color="red">'.$LANG['picture_home'].'</font>','?mod='.$mod.'&file='.$mod.'&channelid='.$channelid),
	array('<font color="blue">'.$LANG['update_channel'].'</font>','?mod='.$mod.'&file='.$file.'&action=index,list,show&channelid='.$channelid,$LANG['tips'].$LANG['click_to_update_followed'].' '.$LANG['channel_home'].'->'.$LANG['category_list']),
	array($LANG['channel_home_updating'],'?mod='.$mod.'&file='.$file.'&action=index&channelid='.$channelid),
	array($LANG['generate_category'],'?mod='.$mod.'&file='.$file.'&action=list&channelid='.$channelid),
	array($LANG['update_picture'],'?mod='.$mod.'&file='.$file.'&action=show&fid='.$minpictureid.'&tid='.$maxpictureid.'&pernum=100&channelid='.$channelid)
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
					<td> <a href='?mod=\$mod&file=\$file&action=per_list&catid=\$id&channelid=\$channelid'>".$LANG['generate_category_list']."</a> | <a href='?mod=\$mod&file=\$file&action=per_show&catid=\$id&channelid=\$channelid'>".$LANG['generate_picture']."</a> | <a href='?mod=\$mod&file=\$file&action=create_dir&catids=\$id&channelid=\$channelid'>".$LANG['generate_category_directory']."</a> </td>
				</tr>";
		$tree->tree($categorys);
		$categorys = $tree->get_tree(0,$str);
	}
	include admintpl('createhtml');
	require_once MOD_ROOT."/include/picture.class.php";
	$pic = new picture($channelid);
	$pic->update();
}
?>