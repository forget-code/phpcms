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
	createhtml("index");
	showmessage($LANG['shop_index_update_success'],$referer);
	break;

case 'list':
	if(isset($catids))
	{
		if(!is_array($catids) && strpos($catids, ','))
		{
			$catids = explode(',', $catids);
			$catid = $catids[0];
			unset($catids[0]);
			$catids =  implode(',', $catids);
			$referer = '?mod='.$mod.'&file='.$file.'&action='.$action.'&catids='.$catids;
		}
		else
		{
			$catid = $catids;
		}
	}
	if(empty($cats) && !isset($catids) && !$catid)
	{
		$cats = array();
		foreach($CATEGORY as $r)
		{
			$cats[] = $r['catid'];
		}
	}
	if(isset($cats) && is_array($cats))
	{
		$catids = implode(',', $cats);
		unset($cats);
		showmessage($LANG['begin_update_category'].'...','?mod='.$mod.'&file='.$file.'&action='.$action.'&catids='.$catids);
	}
	else if(is_numeric($catid))
	{
		createhtml("list");
		showmessage($LANG['category'].' ['.$CATEGORY[$catid]['catname'].'] '.$LANG['update_success'].'...',$referer);
	}
	break;
case 'show':
	if(!isset($fid))
	{
		$r=$db->get_one("select min(productid) as fid from ".TABLE_PRODUCT);
		$fid=$r['fid'];
	}
	if(!isset($fid))
	{
		$r=$db->get_one("select max(productid) as tid from ".TABLE_PRODUCT);
		$fid=$r['fid'];
	}
	$pernum = isset($pernum) ? intval($pernum) : 100 ;
	if($fid+$pernum < $tid)
	{
		for($productid = $fid; $productid < $fid + $pernum; $productid++)
		{
			createhtml('show');
		}
	}
	elseif($fid<$tid)
	{
		for($productid = $fid; $productid <= $tid; $productid++)
		{
			createhtml('show');
		}
	}
	else
	{
		showmessage($LANG['product_update_success'],'?mod='.$mod.'&file='.$file);
	}
	$referer='?mod='.$mod.'&file='.$file.'&action='.$action.'&fid='.$productid.'&tid='.$tid.'&pernum='.$pernum;
	showmessage($LANG['id_from'].' '.$fid.' '.$LANG['to'].' '.($fid+$pernum-1).' '.$LANG['product_update_success'],$referer);
	break;

case 'create_product':
	if(empty($productids))
	{
		showmessage($LANG['illegal_parameters'], 'goback');
	}	
	if(is_array($productids))
	{
		foreach($productids as $productid)
		{
			createhtml('show');
		}
	}
	else
	{
		$productid = $productids;
		createhtml('show');
	}
	showmessage($LANG['product_update_success'],$referer);
	break;
case 'cat_product':
	if(empty($cats) && !isset($catid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$catid = isset($cats) && is_array($cats) ? implode(',',$cats) : $catid;
	$query = "SELECT productid FROM ".TABLE_PRODUCT." WHERE catid IN ($catid) and ishtml=1";
	$result = $db->query($query);
	while($r = $db->fetch_array($result))
	{
		$productid = $r['productid'];
		createhtml('show');
	}
	showmessage($LANG['category_product_update_success'],$referer);
	break;
case 'create_dir':
	if(!isset($catid) && empty($cats))
	{
		$catid = array();
		foreach($CATEGORY as $r)
		{
			$cats[]=$r['catid'];
		}
	}
	if(isset($cats) && is_array($cats))
	{
		foreach($cats as $catid)
		{
			if($CATEGORY[$catid]['islink'] || !$CATEGORY[$catid]['ishtml']) continue;
			$filename = PHPCMS_ROOT.'/'.cat_url('path', $catid);
			$filepath = dirname($filename);
			if(!is_dir($filepath)) dir_create($filepath);
		}
	}
	else
	{
		if(!$CATEGORY[$catid]['islink'] || $CATEGORY[$catid]['ishtml'])
		{
			$filename = PHPCMS_ROOT.'/'.cat_url('path', $catid);
			$filepath = dirname($filename);
			if(!is_dir($filepath)) dir_create($filepath);
		}
	}
	showmessage($LANG['dir_create_success'],$referer);
	break;
	
case 'delete_dir':

	if(empty($cats))
	{
		$catid = array();
		foreach($CATEGORY as $r)
		{
			$cats[]=$r['catid'];
		}
	}
	if(is_array($cats))
	{
		foreach($cats as $catid)
		{
			if($CATEGORY[$catid]['islink'] || !$CATEGORY[$catid]['ishtml']) continue;
			$filename = cat_url('path', $catid);
			$filepath = dirname($filename);
			if(!is_systemdir($filepath) && is_dir(PHPCMS_ROOT.'/'.$filepath))
			{
				dir_delete(PHPCMS_ROOT.'/'.$filepath);
			}
		}
	}
	else
	{
		if(!$catid && (!$CATEGORY[$catid]['islink'] || $CATEGORY[$catid]['ishtml']))
		{
			$filename = cat_url('path', $catid);
			$filepath = dirname($filename);
			if(!is_systemdir($filepath) && is_dir(PHPCMS_ROOT.'/'.$filepath))
			{
				dir_delete(PHPCMS_ROOT.'/'.$filepath);
			}
		}
	}
	showmessage($LANG['dir_delete_success'], $referer);
	break;

default:

	$r=$db->get_one("select min(productid) as minproductid,max(productid) as maxproductid from ".TABLE_PRODUCT);
	$minproductid=$r['minproductid'];
	$maxproductid=$r['maxproductid'];
	unset($r);

	$submenu=array(
	array('<font color="blue">'.$LANG['update_all'].'</font>','?mod='.$mod.'&file='.$file.'&action=index,list,show',$LANG['tips'].$LANG['click_to_update_followed'].$LANG['product_home'].'->'.$LANG['category_list']),
	array($LANG['generate_product_home'],'?mod='.$mod.'&file='.$file.'&action=index'),
	array($LANG['generate_category'],'?mod='.$mod.'&file='.$file.'&action=list'),
	array($LANG['generate_product_html'],'?mod='.$mod.'&file='.$file.'&action=show&fid='.$minproductid.'&tid='.$maxproductid.'&pernum=100')
	);
	$menu=adminmenu($LANG['quick_update'],$submenu);

	require_once PHPCMS_ROOT.'/include/tree.class.php';
	require_once PHPCMS_ROOT.'/admin/include/category_module.class.php';
	$tree = new tree;
	$cat = new category_module($mod);

	$category_select = category_select('catid', $LANG['select_category']);
	$list = $cat->get_list();
	if(is_array($list))
	{
		$categorys = array();
		foreach($list as $catid => $category)
		{
			//if(!$category['ishtml']) continue;
			$module = $mod;
			$linkurl = linkurl($category['linkurl']);
						
			$catdirpath = cat_url('path', $catid);
			$catdirpath = dirname($catdirpath);
			$catdir = $category['islink'] ? "<a href='$linkurl' title='".$LANG['click_view']."' target='_blank'>".str_cut($linkurl,20)."</a>" : "<a href='$linkurl' title='".$LANG['click_view']."' target='_blank'>".$catdirpath."</a>";
			$name = style($category['catname'], $category['style']);
			$filename = PHPCMS_ROOT.'/'.cat_url('url', $catid);
			$dirpath = dirname($filename);
			if(!$category['ishtml'] || $category['islink'] || is_dir($dirpath))
			{
				$is_dir = $LANG['yes'];
			}
			else
			{
				$is_dir = "<a href=\"?mod=$mod&file=$file&action=create_dir&catid=$catid\"><font color=\"red\">".$LANG['no']."</font></a>";
			}
			$categorys[$category['catid']] = array('id'=>$category['catid'],'parentid'=>$category['parentid'],'catdir'=>$catdir,'listorder'=>$category['listorder'],'name'=>$name,'mod'=>$mod,'file'=>$file, 'is_dir'=>$is_dir);
		}
		$str = "<tr align='center' align='center' onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5' height='23'>
					<td><input type='checkbox' name='cats[]' value='\$id'></td>
					<td>\$id</td>
					<td align='left'>\$spacer\$name</td>
					<td>\$catdir</td>
					<td>\$is_dir</td>
					<td> <a href='?mod=\$mod&file=\$file&action=list&catid=\$id'>".$LANG['generate_category_list']."</a> | <a href='?mod=\$mod&file=\$file&action=cat_product&catid=\$id'>".$LANG['generate_product_html']."</a> | <a href='?mod=\$mod&file=\$file&action=create_dir&catid=\$id'>".$LANG['generate_category_directory']."</a> </td>
				</tr>";
		$tree->tree($categorys);
		$categorys = $tree->get_tree(0,$str);
	}
	include admintpl('createhtml');
}
?>