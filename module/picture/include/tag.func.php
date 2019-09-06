<?php
function picture_list($templateid = '', $channelid = 3, $catid = 0, $child = 1, $specialid = 0, $page = 0, $picturenum = 10, $titlelen = 30, $introducelen = 0, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showcatname = 0, $showauthor = 0, $showhits = 0, $target = 0, $cols = 1, $username = '') 
{
	global $db, $PHP_TIME, $CHA, $CATEGORY;
	$cat = (!isset($CHA) || $CHA['channelid'] != $channelid) ? cache_read('categorys_'.$channelid.'.php') : $CATEGORY;
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, pictureid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
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
		$pictureids = @file_get_contents(PHPCMS_ROOT.'/'.$CHA['channeldir'].'/pos/'.$posid.'.txt');
		if($pictureids) $condition .= " AND pictureid IN($pictureids)";
	}
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$condition .= $username ? " AND username='$username' " : '';
	$offset = $page ? ($page-1)*$picturenum : 0;
	$pages = '';
	if($page && $picturenum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".channel_table('picture', $channelid)." WHERE status=3 $condition ","CACHE");
		$pages = (is_numeric($catid) && $catid > 0) ? listpages($catid, $r['number'], $page, $picturenum) : phppages($r['number'], $page, $picturenum);
	}
	$ordertype = $ordertypes[$ordertype];
	$pictures = array();
	$limit = $picturenum ? " LIMIT $offset, $picturenum " : 'LIMIT 0, 10';
	$result = $db->query("SELECT pictureid,catid,typeid,title,style,introduce,author,thumb,addtime,linkurl,hits FROM ".channel_table('picture', $channelid)." WHERE status=3 $condition ORDER BY $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['adddate'] = $datetype ? date($datetypes[$datetype], $r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
		$r['stitle'] = str_cut($r['title'], $str_length , '...');
		$r['stitle'] = style($r['stitle'], $r['style']);
		$r['introduce'] = $introducelen ? str_cut($r['introduce'], $introducelen , '...') : '';
		$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
		if($showcatname)
		{
			$r['catname'] = $cat[$r['catid']]['catname'];
			$r['catlinkurl'] = $cat[$r['catid']]['linkurl'];
		}
		$pictures[] = $r;
	}
	$db->free_result($result);
	$target = $target ? 'target="_blank"' : '';
	$width = ceil(100/$cols).'%';
	$templateid = $templateid ? $templateid : 'tag_picture_list';
	include template('picture',$templateid);
}

function picture_thumb($templateid = '', $channelid = 3, $catid = 0, $child = 1, $specialid = 0, $page = 0, $picturenum = 10, $titlelen = 20, $introducelen = 0, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showalt = 0, $target = 0, $imgwidth = 100, $imgheight = 100, $cols = 1, $username = '')
{
	global $db, $PHP_TIME, $CHA, $CATEGORY;
	$cat = (!isset($CHA) || $CHA['channelid'] != $channelid) ? cache_read('categorys_'.$channelid.'.php') : $CATEGORY;
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, pictureid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
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
		$pictureids = @file_get_contents(PHPCMS_ROOT.'/'.$CHA['channeldir'].'/pos/'.$posid.'.txt');
		if($pictureids) $condition .= " AND pictureid IN($pictureids)";
	}
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$condition .= $username ? " AND username='$username' " : '';
	$offset = $page ? ($page-1)*$picturenum : 0;
	$pages = '';
	if($page && $picturenum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".channel_table('picture', $channelid)." WHERE status=3 $condition ","CACHE");
		$pages = (is_numeric($catid) && $catid > 0) ? listpages($catid, $r['number'], $page, $picturenum) : phppages($r['number'], $page, $picturenum);
	}
	$ordertype = $ordertypes[$ordertype];
	$limit = $picturenum ? " LIMIT $offset, $picturenum " : 'LIMIT 0, 10';
	$pictures = array();
	$result = $db->query("SELECT pictureid,catid,typeid,title,style,introduce,author,thumb,addtime,linkurl FROM ".channel_table('picture', $channelid)." WHERE status=3 $condition ORDER BY $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['adddate'] = $datetype ? date($datetypes[$datetype], $r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
		$r['stitle'] = str_cut($r['title'], $str_length , '...');
		$r['stitle'] = style($r['stitle'], $r['style']);
		$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
		$r['introduce'] = $introducelen ? str_cut($r['introduce'], $introducelen , '...') : '';
		$r['thumb'] = imgurl($r['thumb']);
		if($showalt) $r['alt'] = $r['title'];
		$pictures[] = $r;
	}
	$db->free_result($result);
	$target = $target ? 'target="_blank"' : '';
	$width = ceil(100/$cols).'%';
	$templateid = $templateid ? $templateid : 'tag_picture_thumb';
	include template('picture', $templateid);
}

function picture_slide($templateid = '', $channelid = 3, $catid = 0, $child = 1, $specialid = 0, $picturenum = 5, $titlelen = 30, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $imgwidth = 200, $imgheight = 180, $timeout = 5, $effectid = -1, $username = '')
{
	global $db, $PHP_TIME, $CHA, $CATEGORY;
	$cat = (!isset($CHA) || $CHA['channelid'] != $channelid) ? cache_read('categorys_'.$channelid.'.php') : $CATEGORY;
	$ordertypes = array('listorder DESC, pictureid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
	$channelid = intval($channelid);
	$specialid = intval($specialid);
	$typeid = intval($typeid);
	if($picturenum > 6) $picturenum = 6;
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
		$pictureids = @file_get_contents(PHPCMS_ROOT.'/'.$CHA['channeldir'].'/pos/'.$posid.'.txt');
		if($pictureids) $condition .= " AND pictureid IN($pictureids)";
	}
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$condition .= $username ? " AND username='$username' " : '';
	$ordertype = $ordertypes[$ordertype];
	$limit = $picturenum ? " LIMIT 0, $picturenum " : 'LIMIT 0, 5';
	$k = 0;
	$flash_pics = '';
	$flash_links = '';
	$flash_texts = '';
	$pictures = array();
	$result = $db->query("SELECT pictureid,catid,typeid,title,style,introduce,author,thumb,addtime,linkurl FROM ".channel_table('picture', $channelid)." WHERE status=3 AND thumb!='' $condition ORDER BY $ordertype $limit ","CACHE");
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
		$pictures[]=$r;
	}
	if(empty($pictures))
	{
		$pictures[0]['thumb'] = $flash_pics = PHPCMS_PATH.'images/nopic.gif';
		$pictures[0]['linkurl'] = $flash_links = '#';
		$pictures[0]['title'] = $flash_texts = 'No Picture';
	}
	$db->free_result($result);
	$timeout = $timeout*1000;
	$templateid = $templateid ? $templateid : 'tag_picture_slide';
	include template('picture', $templateid);
}

function picture_related($templateid = '', $channelid = 3, $keywords = '', $pictureid = 0, $picturenum = 10, $titlelen = 30, $datetype = 0)
{
	global $db,$PHP_TIME;
	if(!$keywords) return '';
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$channelid = intval($channelid);
	$pictureid = intval($pictureid);
	$dkeywords = explode(",",$keywords);
	$sql = '';
	foreach($dkeywords as $k=>$v)
	{
		if($k>2) break;
		$sql .= $k ? " OR title like '%$v%' " : " title like '%$v%' ";
	}
	$picturenum++;
	$pictures = array();
	$result = $db->query("SELECT pictureid,catid,typeid,title,style,addtime,linkurl FROM ".channel_table('picture', $channelid)." WHERE status=3 AND ($sql) ORDER BY listorder DESC,pictureid DESC LIMIT 0,$picturenum ","CACHE");
	while($r = $db->fetch_array($result))
	{
		if($r['pictureid'] == $pictureid) continue;
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
		$r['stitle'] = str_cut($r['title'], $str_length , '...');
		$r['stitle'] = style($r['stitle'], $r['style']);
		$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
		$pictures[] = $r;
	}
	$db->free_result($result);
	$templateid = $templateid ? $templateid : 'tag_picture_related';
	include template('picture',$templateid);
}
?>