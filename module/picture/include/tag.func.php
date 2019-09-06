<?php
function picture_list($templateid = '', $channelid = 3, $catid = 0, $child = 1, $specialid = 0, $page = 0, $picturenum = 10, $titlelen = 30, $introducelen = 0, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showcatname = 0, $showauthor = 0, $showhits = 0, $target = 0, $cols = 1, $username = '') 
{
	global $db, $PHP_TIME, $CONFIG, $CHANNEL, $CHA, $CATEGORY, $MODULE, $FIELD, $TEMP, $skindir;
	$temp_id = 0;
	if($page == 0 && defined('CREATEHTML'))
	{
		$temp_id = $templateid.$channelid.$catid.$child.$specialid.$page.$picturenum.$titlelen.$introducelen.$typeid.$posid.$datenum.$ordertype.$datetype.$showcatname.$showauthor.$showhits.$target.$cols.$username;
	}
	if($temp_id && isset($TEMP['tag'][$temp_id])) 
	{
        $pictures = $TEMP['tag'][$temp_id];
	}
	else
	{
		if(!isset($CHA) || $CHA['channelid'] != $channelid) channel_setting($channelid);
		$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
		$ordertypes = array('listorder DESC, pictureid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
		$channelid = intval($channelid);
		$page = isset($page) ? intval($page) : 1;
		$specialid = intval($specialid);
		$typeid = intval($typeid);
		if($datetype < 0 || $datetype > 6) $datetype = 0;
		if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
		$tablename = $CONFIG['tablepre'].'picture_'.$channelid;
		$listpages = 0;
		$condition = '';
		if($catid) 
		{
			if(is_numeric($catid))
			{
				if($child && $CATEGORY[$catid]['child'] && $CATEGORY[$catid]['arrchildid'])
				{
					$condition .= ' AND catid IN ('.$CATEGORY[$catid]['arrchildid'].') ';
				}
				else
				{
					$condition .= " AND catid=$catid ";
					$listpages = 1;
				}
			}
			else
			{
				$condition .= " AND catid IN ($catid) ";
			}
		}
		if($posid)
		{
			$pictureids = @file_get_contents(PHPCMS_ROOT.'/'.$CHANNEL[$channelid]['channeldir'].'/pos/'.$posid.'.txt');
			if($pictureids) $condition .= " AND pictureid IN($pictureids)";
		}
		if($specialid) $condition .= " AND specialid=$specialid ";
		if($typeid) $condition .= " AND typeid=$typeid ";
		if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
		if($username) $condition .= " AND username='$username' ";
		$offset = $page ? ($page-1)*$picturenum : 0;
		$pages = '';
		if($page && $picturenum)
		{
			$r = $db->get_one("SELECT count(*) AS number FROM $tablename WHERE status=3 $condition ","CACHE");
			$pages = (is_numeric($catid) && $catid > 0) ? listpages($catid, $r['number'], $page, $picturenum) : phppages($r['number'], $page, $picturenum);
		}
		$ordertype = $ordertypes[$ordertype];
		$pictures = array();
		$limit = $picturenum ? " LIMIT $offset, $picturenum " : 'LIMIT 0, 10';
		$result = $db->query("SELECT pictureid,catid,typeid,title,style,introduce,author,thumb,addtime,linkurl,hits $FIELD[$tablename] FROM $tablename WHERE status=3 $condition ORDER BY $ordertype $limit ","CACHE");
		while($r = $db->fetch_array($result))
		{
			$r['adddate'] = $datetype ? date($datetypes[$datetype], $r['addtime']) : '';
			$r['linkurl'] = linkurl($r['linkurl']);
			$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
			$r['stitle'] = str_cut($r['title'], $str_length , '...');
			$r['stitle'] = style($r['stitle'], $r['style']);
			$r['introduce'] = $introducelen ? str_cut(strip_tags($r['introduce']), $introducelen , '...') : '';
			$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
			if($showcatname)
			{
				$r['catname'] = $CATEGORY[$r['catid']]['catname'];
				$r['catlinkurl'] = linkurl($CATEGORY[$r['catid']]['linkurl']);
			}
			$pictures[] = $r;
		}
		$db->free_result($result);
        if($temp_id) $TEMP['tag'][$temp_id] = $pictures;
	}
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_picture_list';
	include template('picture',$templateid);
}

function picture_thumb($templateid = '', $channelid = 3, $catid = 0, $child = 1, $specialid = 0, $page = 0, $picturenum = 10, $titlelen = 20, $introducelen = 0, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showalt = 0, $target = 0, $imgwidth = 100, $imgheight = 100, $cols = 1, $username = '')
{
	global $db, $PHP_TIME, $CONFIG, $CHANNEL, $CHA, $CATEGORY, $FIELD, $TEMP, $skindir;
	$temp_id = 0;
	if($page == 0 && defined('CREATEHTML'))
	{
		$temp_id = $templateid.$channelid.$catid.$child.$specialid.$page.$picturenum.$titlelen.$introducelen.$typeid.$posid.$datenum.$ordertype.$datetype.$showalt.$target.$imgwidth.$imgheight.$cols.$username;
	}
	if($temp_id && isset($TEMP['tag'][$temp_id])) 
	{
        $pictures = $TEMP['tag'][$temp_id];
	}
	else
	{
		if(!isset($CHA) || $CHA['channelid'] != $channelid) channel_setting($channelid);
		$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
		$ordertypes = array('listorder DESC, pictureid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
		$channelid = intval($channelid);
		$page = isset($page) ? intval($page) : 1;
		$specialid = intval($specialid);
		$typeid = intval($typeid);
		if($datetype < 0 || $datetype > 6) $datetype = 0;
		if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
		$tablename = $CONFIG['tablepre'].'picture_'.$channelid;
		$listpages = 0;
		$condition = '';
		if($catid) 
		{
			if(is_numeric($catid))
			{
				if($child && $CATEGORY[$catid]['child'] && $CATEGORY[$catid]['arrchildid'])
				{
					$condition .= ' AND catid IN ('.$CATEGORY[$catid]['arrchildid'].') ';
				}
				else
				{
					$condition .= " AND catid=$catid ";
					$listpages = 1;
				}
			}
			else
			{
				$condition .= " AND catid IN ($catid) ";
			}
		}
		if($posid)
		{
			$pictureids = @file_get_contents(PHPCMS_ROOT.'/'.$CHANNEL[$channelid]['channeldir'].'/pos/'.$posid.'.txt');
			if($pictureids) $condition .= " AND pictureid IN($pictureids)";
		}
		if($specialid) $condition .= " AND specialid=$specialid ";
		if($typeid) $condition .= " AND typeid=$typeid ";
		if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
		if($username) $condition .= " AND username='$username' ";
		$offset = $page ? ($page-1)*$picturenum : 0;
		$pages = '';
		if($page && $picturenum)
		{
			$r = $db->get_one("SELECT count(*) AS number FROM $tablename WHERE status=3 $condition ","CACHE");
			$pages = (is_numeric($catid) && $catid > 0) ? listpages($catid, $r['number'], $page, $picturenum) : phppages($r['number'], $page, $picturenum);
		}
		$ordertype = $ordertypes[$ordertype];
		$limit = $picturenum ? " LIMIT $offset, $picturenum " : 'LIMIT 0, 10';
		$pictures = array();
		$result = $db->query("SELECT pictureid,catid,typeid,title,style,introduce,author,thumb,addtime,linkurl $FIELD[$tablename] FROM $tablename WHERE status=3 $condition ORDER BY $ordertype $limit ","CACHE");
		while($r = $db->fetch_array($result))
		{
			$r['adddate'] = $datetype ? date($datetypes[$datetype], $r['addtime']) : '';
			$r['linkurl'] = linkurl($r['linkurl']);
			$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
			$r['stitle'] = str_cut($r['title'], $str_length , '...');
			$r['stitle'] = style($r['stitle'], $r['style']);
			$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
			$r['introduce'] = $introducelen ? str_cut(strip_tags($r['introduce']), $introducelen , '...') : '';
			$r['thumb'] = imgurl($r['thumb']);
			if($showalt) $r['alt'] = $r['title'];
			$pictures[] = $r;
		}
		$db->free_result($result);
		if($temp_id) $TEMP['tag'][$temp_id] = $pictures;
	}
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_picture_thumb';
	include template('picture', $templateid);
}

function picture_slide($templateid = '', $channelid = 3, $catid = 0, $child = 1, $specialid = 0, $picturenum = 5, $titlelen = 30, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $imgwidth = 200, $imgheight = 180, $timeout = 5, $effectid = -1, $username = '')
{
	global $db, $PHP_TIME, $CONFIG, $CHANNEL, $CHA, $CATEGORY, $FIELD, $skindir;
	if(!isset($CHA) || $CHA['channelid'] != $channelid) channel_setting($channelid);
	$ordertypes = array('listorder DESC, pictureid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
	$specialid = intval($specialid);
	$typeid = intval($typeid);
	if($picturenum > 6) $picturenum = 6;
	if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
	$catids = $catid ;
	$tablename = $CONFIG['tablepre'].'picture_'.$channelid;
	$listpages = 0;
	$condition = '';
	if($catid) 
	{
		if(is_numeric($catid))
		{
			if($child && $CATEGORY[$catid]['child'] && $CATEGORY[$catid]['arrchildid'])
			{
				$condition .= ' AND catid IN ('.$CATEGORY[$catid]['arrchildid'].') ';
			}
			else
			{
				$condition .= " AND catid=$catid ";
			}
		}
		else
		{
			$condition .= " AND catid IN ($catid) ";
		}
	}
	if($posid)
	{
		$pictureids = @file_get_contents(PHPCMS_ROOT.'/'.$CHANNEL[$channelid]['channeldir'].'/pos/'.$posid.'.txt');
		if($pictureids) $condition .= " AND pictureid IN($pictureids)";
	}
	if($specialid) $condition .= " AND specialid=$specialid ";
	if($typeid) $condition .= " AND typeid=$typeid ";
	if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
	if($username) $condition .= " AND username='$username' ";
	$ordertype = $ordertypes[$ordertype];
	$limit = $picturenum ? " LIMIT 0, $picturenum " : 'LIMIT 0, 5';
	$k = 0;
	$flash_pics = '';
	$flash_links = '';
	$flash_texts = '';
	$pictures = array();
	$result = $db->query("SELECT pictureid,catid,typeid,title,style,introduce,author,thumb,addtime,linkurl $FIELD[$tablename] FROM $tablename WHERE status=3 AND thumb!='' $condition ORDER BY $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['linkurl'] = linkurl($r['linkurl']);
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
	if(!$templateid) $templateid = 'tag_picture_slide';
	include template('picture', $templateid);
}

function picture_related($templateid = '', $channelid = 3, $keywords = '', $pictureid = 0, $picturenum = 10, $titlelen = 30, $datetype = 0)
{
	global $db, $PHP_TIME, $CONFIG, $MODULE, $FIELD, $skindir;
	if(!$keywords) return '';
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$pictureid = intval($pictureid);
	$keywords = str_replace(',', '+', addslashes($keywords));
	$picturenum++;
	$tablename = $CONFIG['tablepre'].'picture_'.$channelid;
	$pictures = array();
	$result = $db->query("SELECT pictureid,catid,typeid,title,style,addtime,linkurl $FIELD[$tablename] FROM $tablename WHERE status=3 AND MATCH (keywords) AGAINST ('$keywords' IN BOOLEAN MODE) ORDER BY listorder DESC,pictureid DESC LIMIT 0,$picturenum ","CACHE");
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
	if(!$templateid) $templateid = 'tag_picture_related';
	include template('picture',$templateid);
}
?>