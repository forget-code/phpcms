<?php
function down_list($templateid = '', $channelid = 2, $catid = 0, $child = 1, $specialid = 0, $page = 0, $downnum = 10, $titlelen = 30, $introducelen = 0, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showcatname = 0, $showauthor = 0, $showdowns = 0, $target = 0, $cols = 1, $username = '') 
{
	global $db, $PHP_TIME, $CHA, $CATEGORY;
	$cat = (!isset($CHA) || $CHA['channelid'] != $channelid) ? cache_read('categorys_'.$channelid.'.php') : $CATEGORY;
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, edittime DESC', 'edittime DESC', 'downid ASC', 'totaldowns DESC', 'totaldowns ASC', 'comments DESC', 'comments ASC');
	$channelid = intval($channelid);
	$page = isset($page) ? intval($page) : 1;
	$specialid = intval($specialid);
	$typeid = intval($typeid);
	if($datetype < 0 || $datetype > 6) $datetype = 0;
	if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
	if($cols < 1) $cols = 1;
	$catids = $catid ;
	if($child && $catid && is_numeric($catid)) 
	{
		$catids = $cat[$catid]['arrchildid'];
	}
	$condition = '';
	$condition .= $catids ? (is_numeric($catids) ? " AND catid=$catid " : " AND catid IN ($catids) ") : '';
	$condition .= $specialid ? " AND specialid=$specialid " : '';
	$condition .= $typeid ? " AND typeid=$typeid " : '';
	if($posid)
	{
		$downids = @file_get_contents(PHPCMS_ROOT.'/'.$CHA['channeldir'].'/pos/'.$posid.'.txt');
		if($downids) $condition .= " AND downid IN($downids)";
	}
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$condition .= $username ? " AND username='$username' " : '';

	$offset = $page ? ($page-1)*$downnum : 0;
	if($page && $downnum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".channel_table('down', $channelid)." WHERE status=3 $condition ","CACHE");
		$pages = (is_numeric($catid) && $catid > 0) ? listpages($catid, $r['number'], $page, $downnum) : phppages($r['number'], $page, $downnum);
	}
	$pages = isset($pages) ? $pages : '';
	$ordertype = $ordertypes[$ordertype];
	$limit = $downnum ? " LIMIT $offset, $downnum " : "LIMIT 0, 10";
	$result=$db->query("SELECT downid,catid,typeid,title,style,introduce,author,thumb,addtime,linkurl,filesize,totaldowns,stars FROM ".channel_table('down', $channelid)." WHERE status=3 $condition ORDER BY $ordertype $limit ","CACHE");
	$downs = array();
	while($r=$db->fetch_array($result))
	{
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
		$r['stitle'] = str_cut($r['title'], $str_length , '...');
		$r['stitle'] = style($r['stitle'], $r['style']);
		$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
		$r['introduce'] = $introducelen ? str_cut($r['introduce'], $introducelen , '...') : '';
		if($catid && function_exists('stars')) $r['stars'] = stars($r['stars']);
		if($showcatname)
		{
			$r['catname'] = $cat[$r['catid']]['catname'];
			$r['catlinkurl'] = $cat[$r['catid']]['linkurl'];
		}
		$downs[]=$r;
	}
	$db->free_result($result);
	$target = $target ? 'target="_blank"' : '';
	$width = ceil(100/$cols).'%';
	$templateid = $templateid ? $templateid : 'tag_down_list';
	include template('down',$templateid);
}

function down_thumb($templateid = '', $channelid = 2, $catid = 0, $child = 1, $specialid = 0, $page = 0, $downnum = 10, $titlelen = 20, $introducelen = 0, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showalt = 0, $target = 0, $imgwidth = 100, $imgheight = 100, $cols = 1, $username = '')
{
	global $db, $PHP_TIME, $CHA, $CATEGORY;
	$cat = (!isset($CHA) || $CHA['channelid'] != $channelid) ? cache_read('categorys_'.$channelid.'.php') : $CATEGORY;
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, edittime DESC', 'edittime DESC', 'downid ASC', 'totaldowns DESC', 'totaldowns ASC', 'comments DESC', 'comments ASC');
	$channelid = intval($channelid);
	$page = isset($page) ? intval($page) : 1;
	$specialid = intval($specialid);
	$typeid = intval($typeid);
	if($datetype < 0 || $datetype > 6) $datetype = 0;
	if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
	$catids = $catid ;
	if($child && $catid && is_numeric($catid)) 
	{
		$catids = $cat[$catid]['arrchildid'];
	}
	$condition = '';
	$condition .= $catids ? (is_numeric($catids) ? " AND catid=$catid " : " AND catid IN ($catids) ") : '';
	$condition .= $specialid ? " AND specialid=$specialid " : '';
	$condition .= $typeid ? " AND typeid=$typeid " : '';
	if($posid)
	{
		$downids = @file_get_contents(PHPCMS_ROOT.'/'.$CHA['channeldir'].'/pos/'.$posid.'.txt');
		if($downids) $condition .= " AND downid IN($downids)";
	}
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$condition .= $username ? " AND username='$username' " : '';
	$offset = $page ? ($page-1)*$downnum : 0;
	if($page && $downnum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".channel_table('down', $channelid)." WHERE status=3 $condition ","CACHE");
		$pages = (is_numeric($catid) && $catid > 0) ? listpages($catid, $r['number'], $page, $downnum) : phppages($r['number'], $page, $downnum);
	}
	$pages = isset($pages) ? $pages : '';
	$ordertype = $ordertypes[$ordertype];
	$limit = $downnum ? " LIMIT $offset, $downnum " : 'LIMIT 0, 10';
	$result=$db->query("SELECT downid,catid,typeid,title,style,introduce,author,thumb,addtime,linkurl FROM ".channel_table('down', $channelid)." WHERE status=3 AND thumb!='' $condition ORDER BY $ordertype $limit ","CACHE");
	$downs = array();
	while($r=$db->fetch_array($result))
	{
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
		$r['stitle'] = str_cut($r['title'], $str_length , '...');
		$r['stitle'] = style($r['stitle'], $r['style']);
		$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
		$r['introduce'] = $introducelen ? str_cut($r['introduce'], $introducelen , '...') : '';
		$r['thumb'] = imgurl($r['thumb']);
		if($showalt) $r['alt'] = $r['title'];
		$downs[]=$r;
	}
	$db->free_result($result);
	$target = $target ? 'target="_blank"' : '';
	$width = ceil(100/$cols).'%';
	$templateid = $templateid ? $templateid : 'tag_down_thumb';
	include template('down',$templateid);
}

function down_slide($templateid = '', $channelid = 2, $catid = 0, $child = 1, $specialid = 0, $downnum = 5, $titlelen = 30, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $imgwidth = 200, $imgheight = 180, $timeout = 5, $effectid = -1, $username = '')
{
	global $db, $PHP_TIME, $CHA, $CATEGORY;
	$cat = (!isset($CHA) || $CHA['channelid'] != $channelid) ? cache_read('categorys_'.$channelid.'.php') : $CATEGORY;
	$ordertypes = array('listorder DESC, edittime DESC', 'edittime DESC', 'downid ASC', 'totaldowns DESC', 'totaldowns ASC', 'comments DESC', 'comments ASC');
	$channelid = intval($channelid);
	$specialid = intval($specialid);
	$typeid = intval($typeid);
	if($downnum > 6) $downnum = 6;
	if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
	$catids = $catid ;
	if($child && $catid && is_numeric($catid)) 
	{
		$catids = $cat[$catid]['arrchildid'];
	}
	$condition = '';
	$condition .= $catids ? (is_numeric($catids) ? " AND catid=$catid " : " AND catid IN ($catids) ") : '';
	$condition .= $specialid ? " AND specialid=$specialid " : '';
	$condition .= $typeid ? " AND typeid=$typeid " : '';
	if($posid)
	{
		$downids = @file_get_contents(PHPCMS_ROOT.'/'.$CHA['channeldir'].'/pos/'.$posid.'.txt');
		if($downids) $condition .= " AND downid IN($downids)";
	}
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$condition .= $username ? " AND username='$username' " : '';
	$ordertype = $ordertypes[$ordertype];
	$limit = $downnum ? " LIMIT 0, $downnum " : 'LIMIT 0, 5';
	$k = 0;
	$flash_pics = '';
	$flash_links = '';
	$flash_texts = '';
	$downs = array();
	$result = $db->query("SELECT downid,catid,typeid,title,style,introduce,author,thumb,addtime,linkurl FROM ".channel_table('down', $channelid)." WHERE status=3 AND thumb!='' $condition ORDER BY $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['linkurl'] = str_replace('&page=1', '', linkurl($r['linkurl']));
		$r['title'] = addslashes(str_cut($r['title'], $titlelen, '...'));
		$r['thumb'] = imgurl($r['thumb']);
		$s = $k ? '|' : '';
		$flash_pics .= $s.$r['thumb'];
		$flash_links .= $s.$r['linkurl'];
		$flash_texts .= $s.$r['title'];
		$k = 1;
		$downs[]=$r;
	}
	if(empty($downs))
	{
		$downs[0]['thumb'] = $flash_pics = PHPCMS_PATH.'images/nopic.gif';
		$downs[0]['linkurl'] = $flash_links = '#';
		$downs[0]['title'] = $flash_texts = 'No Picture';
	}
	$db->free_result($result);
	$timeout = $timeout*1000;
	$templateid = $templateid ? $templateid : 'tag_down_slide';
	include template('down',$templateid);
}

function down_related($templateid = '', $channelid = 2, $keywords = '', $downid = 0, $downnum = 10, $titlelen = 30, $datetype = 0)
{
	global $db,$PHP_TIME;
	if(!$keywords) return '';
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$channelid = intval($channelid);
	$downid = intval($downid);
	$dkeywords = explode(',', $keywords);
	$sql = '';
	foreach($dkeywords as $k=>$v)
	{
		if($k > 2) break;
		$sql .= $k ? " OR title like '%$v%' " : " title like '%$v%' ";
	}
	$downnum++;
	$downs = array();
	$result = $db->query("SELECT downid,catid,typeid,title,style,addtime,linkurl FROM ".channel_table('down', $channelid)." WHERE status=3 AND ($sql) ORDER BY listorder DESC,downid DESC LIMIT 0,$downnum ","CACHE");
	while($r = $db->fetch_array($result))
	{
		if($r['downid'] == $downid) continue;
		$r['adddate'] = $datetype ? date($datetypes[$datetype], $r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
		$r['stitle'] = str_cut($r['title'], $str_length , '...');
		$r['stitle'] = style($r['stitle'], $r['style']);
		$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
		$downs[] = $r;
	}
	$db->free_result($result);
	$templateid = $templateid ? $templateid : 'tag_down_related';
	include template('down',$templateid);
}
?>