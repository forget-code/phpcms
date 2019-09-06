<?php
function info_list($templateid = '', $channelid = 4, $catid = 0, $child = 1, $specialid = 0, $page = 0, $infonum = 10, $titlelen = 30, $introducelen = 0, $areaid = 0, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showcatname = 0, $showauthor = 0, $showhits = 0, $target = 0, $cols = 1, $username = '') 
{
	global $db, $PHP_TIME, $CONFIG, $CHANNEL, $CHA, $CATEGORY, $MODULE, $FIELD, $TEMP, $AREA, $LANG;
	$temp_id = 0;
	if($page == 0 && defined('CREATEHTML'))
	{
		$temp_id = $templateid.$channelid.$catid.$child.$specialid.$page.$infonum.$titlelen.$introducelen.$areaid.$typeid.$posid.$datenum.$ordertype.$datetype.$showcatname.$showauthor.$showhits.$target.$cols.$username;
	}
	if($temp_id && isset($TEMP['tag'][$temp_id])) 
	{
        $infos = $TEMP['tag'][$temp_id];
	}
	else
	{
		if(!isset($CHA) || $CHA['channelid'] != $channelid) channel_setting($channelid);
		if(!isset($AREA)) $AREA = cache_read('areas_'.$channelid.'.php');
		$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
		$ordertypes = array('listorder DESC, infoid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
		$page = isset($page) ? intval($page) : 1;
		$specialid = intval($specialid);
		$typeid = intval($typeid);
		if($datetype < 0 || $datetype > 6) $datetype = 0;
		if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
		$tablename = $CONFIG['tablepre'].'info_'.$channelid;
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
			$infoids = @file_get_contents(PHPCMS_ROOT.'/'.$CHANNEL[$channelid]['channeldir'].'/pos/'.$posid.'.txt');
			if($infoids) $condition .= " AND infoid IN($infoids)";
		}
		if($specialid) $condition .= " AND specialid=$specialid ";
		if($typeid) $condition .= " AND typeid=$typeid ";
		if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
		if($username) $condition .= " AND username='$username' ";
		if($areaid)
		{
			$arrchildids = $AREA[$areaid]['arrchildid'];
			$condition .= " AND areaid IN($arrchildids)";
		}
		$offset = $page ? ($page-1)*$infonum : 0;
		$pages = '';
		if($page && $infonum)
		{
			$r = $db->get_one("SELECT count(*) AS number FROM $tablename WHERE status=3 $condition ","CACHE");
			$pages = (is_numeric($catid) && $catid > 0) ? listpages($catid, $r['number'], $page, $infonum) : phppages($r['number'], $page, $infonum);
		}
		$ordertype = $ordertypes[$ordertype];
		$sql = $introducelen ? ',content' : '';
		$limit = $infonum ? " LIMIT $offset, $infonum " : 'LIMIT 0, 10';
		$infos = array();
		$result = $db->query("SELECT infoid,catid,typeid,title,style,author,thumb,addtime,endtime,islink,linkurl,hits,areaid $sql $FIELD[$tablename] FROM $tablename WHERE status=3 $condition ORDER BY $ordertype $limit ","CACHE");
		while($r = $db->fetch_array($result))
		{
			if($datetype)
			{
				$r['adddate'] = date($datetypes[$datetype], $r['addtime']);
				$r['enddate'] = $r['endtime'] ? date($datetypes[$datetype], $r['endtime']) : $LANG['no_limit'];
			}
			$r['linkurl'] = linkurl($r['linkurl']);
			$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
			$r['stitle'] = str_cut($r['title'], $str_length , '...');
			$r['stitle'] = style($r['stitle'], $r['style']);
			$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
			$r['introduce'] = $introducelen ? str_cut(strip_tags($r['content']), $introducelen, '...') : '';
			$r['thumb'] = imgurl($r['thumb']);
			if($showcatname)
			{
				$r['catname'] = $CATEGORY[$r['catid']]['catname'];
				$r['catlinkurl'] = linkurl($CATEGORY[$r['catid']]['linkurl']);
			}
			$infos[] = $r;
		}
		$db->free_result($result);
		if($temp_id) $TEMP['tag'][$temp_id] = $infos;
	}
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_info_list';
	include template('info', $templateid);
}

function info_thumb($templateid = '', $channelid = 4, $catid = 0, $child = 1, $specialid = 0, $page = 0, $infonum = 10, $titlelen = 20, $introducelen = 0, $areaid = 0, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showalt = 0, $target = 0, $imgwidth = 100, $imgheight = 100, $cols = 1, $username = '')
{
	global $db, $PHP_TIME, $CONFIG, $CHANNEL, $CHA, $CATEGORY, $AREA, $FIELD, $TEMP;
	$temp_id = 0;
	if($page == 0 && defined('CREATEHTML'))
	{
		$temp_id = $templateid.$channelid.$catid.$child.$specialid.$page.$infonum.$titlelen.$introducelen.$areaid.$typeid.$posid.$datenum.$ordertype.$datetype.$showalt.$target.$imgwidth.$imgheight.$cols.$username;
	}
	if($temp_id && isset($TEMP['tag'][$temp_id])) 
	{
        $infos = $TEMP['tag'][$temp_id];
	}
	else
	{
		if(!isset($CHA) || $CHA['channelid'] != $channelid) channel_setting($channelid);
		if(!isset($AREA)) $AREA = cache_read('areas_'.$channelid.'.php');
		$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
		$ordertypes = array('listorder DESC, infoid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
		$page = isset($page) ? intval($page) : 1;
		$specialid = intval($specialid);
		$typeid = intval($typeid);
		if($datetype < 0 || $datetype > 6) $datetype = 0;
		if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
		$tablename = $CONFIG['tablepre'].'info_'.$channelid;
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
			$infoids = @file_get_contents(PHPCMS_ROOT.'/'.$CHANNEL[$channelid]['channeldir'].'/pos/'.$posid.'.txt');
			if($infoids) $condition .= " AND infoid IN($infoids)";
		}
		if($specialid) $condition .= " AND specialid=$specialid ";
		if($typeid) $condition .= " AND typeid=$typeid ";
		if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
		if($username) $condition .= " AND username='$username' ";
		if($areaid)
		{
			$arrchildids = $AREA[$areaid]['arrchildid'];
			$condition .= " AND areaid IN($arrchildids)";
		}
		$offset = $page ? ($page-1)*$infonum : 0;
		$pages = '';
		if($page && $infonum)
		{
			$r = $db->get_one("SELECT count(*) AS number FROM $tablename WHERE status=3 $condition ","CACHE");
			$pages = (is_numeric($catid) && $catid > 0) ? listpages($catid, $r['number'], $page, $infonum) : phppages($r['number'], $page, $infonum);
		}
		$ordertype = $ordertypes[$ordertype];
		$limit = $infonum ? " LIMIT $offset, $infonum " : 'LIMIT 0, 10';
		$sql = $introducelen ? ',content' : '';
		$infos = array();
		$result = $db->query("SELECT infoid,catid,typeid,title,style,author,thumb,addtime,islink,linkurl $sql $FIELD[$tablename] FROM $tablename WHERE status=3 AND thumb!='' $condition ORDER BY $ordertype $limit ","CACHE");
		while($r = $db->fetch_array($result))
		{
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['adddate'] = $datetype ? date($datetypes[$datetype], $r['addtime']) : '';
			$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
			$r['stitle'] = str_cut($r['title'], $str_length , '...');
			$r['stitle'] = style($r['stitle'], $r['style']);
			$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
			$r['introduce'] = $introducelen ? str_cut(strip_tags($r['content']), $introducelen , '...') : '';
			$r['thumb'] = imgurl($r['thumb']);
			if($showalt) $r['alt'] = $r['title'];
			$infos[] = $r;
		}
		$db->free_result($result);
		if($temp_id) $TEMP['tag'][$temp_id] = $infos;
	}
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_info_thumb';
	include template('info', $templateid);
}

function info_slide($templateid = '', $channelid = 4, $catid = 0, $child = 1, $specialid = 0, $infonum = 5, $titlelen = 30, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $imgwidth = 200, $imgheight = 180, $timeout = 5, $effectid = -1, $username = '')
{
	global $db, $PHP_TIME, $CONFIG, $CHANNEL, $CHA, $CATEGORY, $AREA, $FIELD;
	if(!isset($CHA) || $CHA['channelid'] != $channelid) channel_setting($channelid);
	if(!isset($AREA)) $AREA = cache_read('areas_'.$channelid.'.php');
	$ordertypes = array('listorder DESC, infoid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
	$specialid = intval($specialid);
	$typeid = intval($typeid);
	if($infonum > 6) $infonum = 6;
	if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
	$tablename = $CONFIG['tablepre'].'info_'.$channelid;
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
		$infoids = @file_get_contents(PHPCMS_ROOT.'/'.$CHANNEL[$channelid]['channeldir'].'/pos/'.$posid.'.txt');
		if($infoids) $condition .= " AND infoid IN($infoids)";
	}
	if($specialid) $condition .= " AND specialid=$specialid ";
	if($typeid) $condition .= " AND typeid=$typeid ";
	if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
	if($username) $condition .= " AND username='$username' ";
	$ordertype = $ordertypes[$ordertype];
	$limit = $infonum ? " LIMIT 0, $infonum " : 'LIMIT 0, 5';
	$k = 0;
	$flash_pics = '';
	$flash_links = '';
	$flash_texts = '';
	$infos = array();
	$result = $db->query("SELECT infoid,catid,typeid,title,style,content,author,thumb,addtime,islink,linkurl $FIELD[$tablename] FROM $tablename WHERE status=3 AND thumb!='' $condition ORDER BY $ordertype $limit ","CACHE");
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
		$infos[] = $r;
	}
	if(empty($infos))
	{
		$infos[0]['thumb'] = $flash_pics = PHPCMS_PATH.'images/nopic.gif';
		$infos[0]['linkurl'] = $flash_links = '#';
		$infos[0]['title'] = $flash_texts = 'No Picture';
	}
	$db->free_result($result);
	$timeout = $timeout*1000;
	if(!$templateid) $templateid = 'tag_info_slide';
	include template('info', $templateid);
}

function info_related($templateid = '', $channelid = 4, $keywords = '', $infoid = 0, $infonum = 10, $titlelen = 30, $datetype = 0)
{
	global $db, $PHP_TIME, $CONFIG, $FIELD;
	if(!$keywords) return '';
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$infoid = intval($infoid);
	$keywords = str_replace(',', '+', $keywords);
	$infonum++;
	$tablename = $CONFIG['tablepre'].'info_'.$channelid;
	$infos = array();
	$result = $db->query("SELECT infoid,catid,typeid,title,style,addtime,linkurl $FIELD[$tablename] FROM $tablename WHERE status=3 AND MATCH (keywords) AGAINST ('$keywords' IN BOOLEAN MODE) ORDER BY listorder DESC,infoid DESC LIMIT 0,$infonum ","CACHE");
	while($r = $db->fetch_array($result))
	{
		if($r['infoid'] == $infoid) continue;
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
		$r['linkurl'] = linkurl($r['linkurl']);
		$r['stitle'] = str_cut($r['title'], $str_length , '...');
		$r['stitle'] = style($r['stitle'], $r['style']);
		$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
		$infos[] = $r;
	}
	$db->free_result($result);
	if(!$templateid) $templateid = 'tag_info_related';
	include template('info', $templateid);
}
?>