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
	showmessage($LANG['channel_update_success'], $referer);
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
		showmessage($LANG['category'].$CATEGORY[$catids]['catname'].$LANG['category_update_success'], $referer);
	}
	break;


case 'per_list'://分段更新栏目

	if(!$catid)
	{
		showmessage($LANG['choose_category'], 'goback');
	}
	if(!$CATEGORY[$catid]['ishtml'])//不生成 直接跳出
	{
		showmessage($LANG['category'].$CATEGORY[$catid]['catname'].$LANG['category_update_success'], '?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	if($CATEGORY[$catid]['child'])
	{
		showmessage($LANG['updating_category'],'?mod='.$mod.'&file='.$file.'&action=list&catids='.$catid.'&channelid='.$channelid);
	}
	if(!isset($tid))
	{
		$CAT = cache_read('category_'.$catid.'.php');
		$tid = ceil($CAT['items']/$CAT['maxperpage']);
	}
	$pernum = isset($pernum) ? $pernum : 50;
	$fid = isset($fid) ? $fid+$pernum : 1;
	if($fid<$tid || ($fid-$pernum) < $tid)
	{
		createhtml('list');
		$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&catid='.$catid.'&fid='.$fid.'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
		showmessage($LANG['from'].$fid.$LANG['go'].($fid+$pernum-1).$LANG['page_update_success'], $referer);
	}
	else
	{
		showmessage($LANG['category'].$CATEGORY[$catid]['catname'].$LANG['category_update_success'], '?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}

	break;

case 'show'://所有影片

	if(!isset($fid))
	{
		$r=$db->get_one("select min(movieid) as fid from ".channel_table('movie', $channelid));
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(movieid) as tid from ".channel_table('movie', $channelid));
		$tid=$r['tid'];
	}
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		$query = "select movieid from ".channel_table('movie', $channelid)." WHERE status=3 and ishtml=1 and islink=0 and movieid>=$fid order by movieid limit 0,$pernum ";
		$result = $db->query($query);
		if($db->affected_rows($result) > 0)
		{
			while($r = $db->fetch_array($result))
			{
				$movieid = $r['movieid'];
				createhtml('show');
			}
		}
		else
		{
			$movieid = $fid + $pernum;
		}
	}
	elseif($fid<$tid)
	{
		$query = "select movieid from ".channel_table('movie', $channelid)." WHERE status=3 and ishtml=1 and islink=0 and movieid>=$fid order by movieid limit 0,$pernum ";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$movieid = $r['movieid'];
			createhtml('show');
		}
		showmessage($LANG['movie_update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	else
	{
		showmessage($LANG['movie_update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$movieid.'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
	showmessage($LANG['id'].$fid.$LANG['go'].($fid+$pernum-1).$LANG['movie_success'], $referer);
	break;

case 'create_show'://影片

	if(empty($movieids))
	{
		showmessage($LANG['choices_movie'], 'goback');
	}
	
	if(is_array($movieids))
	{
		foreach($movieids as $movieid)
		{
			createhtml("show");
		}
	}
	else
	{
		$movieid = $movieids;
		createhtml("show");
	}
	showmessage($LANG['movie_update_success'],$referer);
	break;

case 'cat_show'://栏目影片

	if(empty($catids))
	{
		showmessage($LANG['illegal_parameters'], 'goback');
	}
	$catids = is_array($catids) ? implode(',',$catids) : $catids;
	$query = "SELECT movieid FROM ".channel_table('movie', $channelid)." WHERE catid IN ($catids) and status=3 and ishtml=1 and islink=0 ";
	$result=$db->query($query);
	while($r=$db->fetch_array($result))
	{
		$movieid=$r['movieid'];
		createhtml("show");
	}
	showmessage($LANG['movie_update_success'],$referer);
	break;

case 'per_show'://分段栏目影片

	if(!$catid)
	{
		showmessage($LANG['choose_category'], 'goback');
	}
	if(!isset($fid))
	{
		$r=$db->get_one("select min(movieid) as fid from ".channel_table('movie', $channelid)." WHERE catid=$catid and status=3 and ishtml=1 and islink=0 ");
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(movieid) as tid from ".channel_table('movie', $channelid)." WHERE catid=$catid and status=3 and ishtml=1 and islink=0 ");
		$tid=$r['tid'];
	}
	$fid && $tid or showmessage($LANG['successfull'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		$query = "select movieid from ".channel_table('movie', $channelid)." WHERE catid=$catid  and status=3 and ishtml=1 and islink=0 and movieid>=$fid order by movieid limit 0,$pernum ";
		$result = $db->query($query);
		if($db->affected_rows($result) > 0)
		{
			while($r = $db->fetch_array($result))
			{
				$movieid = $r['movieid'];
				createhtml('show');
			}
		}
		else
		{
			$movieid = $fid + $pernum;
		}
	}
	elseif($fid < $tid)
	{
		$query = "select movieid from ".channel_table('movie', $channelid)." WHERE catid=$catid  and status=3 and ishtml=1 and islink=0 and movieid>=$fid order by movieid limit 0,$pernum ";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$movieid = $r['movieid'];
			createhtml('show');
		}

		showmessage($LANG['category'].$CATEGORY[$catid]['catname'].$LANG['update_success'], '?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	else
	{
		showmessage($LANG['category'].$CATEGORY[$catid]['catname'].$LANG['movie_update_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&catid='.$catid.'&fid='.($movieid+1).'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
	showmessage($LANG['id'].$fid.$LANG['go'].($fid+$pernum-1).$LANG['movie_success'],$referer);
	break;

case 'update_url'://地址

	if(empty($movieids))
	{
		showmessage($LANG['choices_movie'], 'goback');
	}
	
	if(is_array($movieids))
	{
		foreach($movieids as $movieid)
		{
			update_movie_url($movieid);
		}
	}
	else
	{
		$movieid = $movieids;
		update_movie_url($movieid);
	}
	showmessage($LANG['url_movie_success'],$referer);
	break;

case 'url'://更新地址

	if(!isset($fid))
	{
		$r=$db->get_one("select min(movieid) as fid from ".channel_table('movie', $channelid));
		$fid=$r['fid'];
	}
	if(!isset($tid))
	{
		$r=$db->get_one("select max(movieid) as tid from ".channel_table('movie', $channelid));
		$tid=$r['tid'];
	}
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		$query = "select movieid from ".channel_table('movie', $channelid)." WHERE status=3 and movieid>=$fid order by movieid limit 0,$pernum ";
		$result = $db->query($query);
		if($db->affected_rows($result) > 0)
		{
			while($r = $db->fetch_array($result))
			{
				$movieid = $r['movieid'];
				echo '';
				update_movie_url($movieid);
			}
		}
		else
		{
			$movieid = $fid + $pernum;
		}
	}
	elseif($fid<$tid)
	{
		$query = "select movieid from ".channel_table('movie', $channelid)." WHERE status=3 and movieid>=$fid order by movieid limit 0,$pernum ";
		$result = $db->query($query);
		while($r = $db->fetch_array($result))
		{
			$movieid = $r['movieid'];
			update_movie_url($movieid);
		}
		showmessage($LANG['url_movie_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	else
	{
		showmessage($LANG['url_movie_success'],'?mod='.$mod.'&file='.$file.'&channelid='.$channelid);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$movieid.'&tid='.$tid.'&pernum='.$pernum.'&channelid='.$channelid;
	showmessage($LANG['id'].$fid.$LANG['go'].($fid+$pernum-1).$LANG['url_movie_update_success'], $referer);
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
	showmessage($LANG['category_create_success'],$referer);
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
	showmessage($LANG['category_remove_success'], $referer);
	break;



default:

	$r=$db->get_one("select min(movieid) as minmovieid,max(movieid) as maxmovieid from ".channel_table('movie', $channelid));
	$minmovieid=$r['minmovieid'];
	$maxmovieid=$r['maxmovieid'];
	unset($r);

	$submenu=array(
	array('<font color="red">'.$LANG['movie_home'].'</font>','?mod='.$mod.'&file='.$mod.'&channelid='.$channelid),
	array('<font color="blue">'.$LANG['update_channels'].'</font>','?mod='.$mod.'&file='.$file.'&action=index,list,show&channelid='.$channelid, $LANG['suggest']),
	array($LANG['channel_home_updating'],'?mod='.$mod.'&file='.$file.'&action=index&channelid='.$channelid),
	array($LANG['update_category'],'?mod='.$mod.'&file='.$file.'&action=list&channelid='.$channelid),
	array($LANG['movie_updated'],'?mod='.$mod.'&file='.$file.'&action=show&fid='.$minmovieid.'&tid='.$maxmovieid.'&pernum=100&channelid='.$channelid)
	);
	$menu=adminmenu($LANG['quick_update'],$submenu);

	require_once PHPCMS_ROOT.'/include/tree.class.php';
	require_once PHPCMS_ROOT.'/admin/include/category_channel.class.php';
	$tree = new tree;
	$cat = new category_channel($channelid);

	$category_select = category_select('catid', $LANG['choose_category']);
	$list = $cat->get_list();
	if(is_array($list))
	{
		$categorys = array();
		foreach($list as $catid => $category)
		{
			//if(!$category['ishtml']) continue;
			$module = $CHA['module'];
			$linkurl = $category['linkurl'];
			$catdir = $category['islink'] ? "<a href='$linkurl' title='".$LANG['title']." target='_blank'>".str_cut($linkurl,20)."</a>" : "<a href='$linkurl' title='".$LANG['title']." target='_blank'>".$category['catdir']."</a>";
			$name = style($category['catname'], $category['style']);
			if(!$category['ishtml'] || $category['islink'] || is_dir(dirname(PHPCMS_ROOT.'/'.cat_url('url', $category['catid']))))
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
					<td> <a href='?mod=\$mod&file=\$file&action=per_list&catid=\$id&channelid=\$channelid'>".$LANG['generate_list_category']."</a> | <a href='?mod=\$mod&file=\$file&action=per_show&catid=\$id&channelid=\$channelid'>".$LANG['generate_movie']."</a> | <a href='?mod=\$mod&file=\$file&action=create_dir&catids=\$id&channelid=\$channelid'>".$LANG['generate_category']."</a> </td>
				</tr>";
		$tree->tree($categorys);
		$categorys = $tree->get_tree(0,$str);
	}
	include admintpl('createhtml');
	require_once MOD_ROOT."/include/movie.class.php";
	$d = new movie($channelid);
	$d->update();
}
?>