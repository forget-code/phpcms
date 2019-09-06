<?php
function article_list($templateid = '', $channelid = 1, $catid = 0, $child = 1, $specialid = 0, $page = 0, $articlenum = 10, $titlelen = 30, $introducelen = 0, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showcatname = 0, $showauthor = 0, $showhits = 0, $target = 0, $cols = 1, $username = '') 
{
	global $db, $PHP_TIME, $CONFIG, $CHANNEL, $CHA, $CATEGORY, $MODULE, $FIELD, $TEMP, $skindir;
	$temp_id = 0;
	if($page == 0 && defined('CREATEHTML'))
	{
		$temp_id = $templateid.$channelid.$catid.$child.$specialid.$page.$articlenum.$titlelen.$introducelen.$typeid.$posid.$datenum.$ordertype.$datetype.$showcatname.$showauthor.$showhits.$target.$cols.$username;
	}
	if($temp_id && isset($TEMP['tag'][$temp_id])) 
	{
        $articles = $TEMP['tag'][$temp_id];
	}
	else
	{
		if(!isset($CHA) || $CHA['channelid'] != $channelid) channel_setting($channelid);
		$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
		$ordertypes = array('listorder DESC, articleid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
		$page = isset($page) ? intval($page) : 1;
		$specialid = intval($specialid);
		$typeid = intval($typeid);
		if($datetype < 0 || $datetype > 6) $datetype = 0;
		if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
		$tablename = $CONFIG['tablepre'].'article_'.$channelid;
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
			$articleids = @file_get_contents(PHPCMS_ROOT.'/'.$CHANNEL[$channelid]['channeldir'].'/pos/'.$posid.'.txt');
			if($articleids) $condition .= " AND articleid IN($articleids)";
		}
		if($specialid) $condition .= " AND specialid=$specialid ";
		if($typeid) $condition .= " AND typeid=$typeid ";
		if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
		if($username) $condition .= " AND username='$username' ";
		$offset = $page ? ($page-1)*$articlenum : 0;
		if($page && $articlenum)
		{
			$r = $db->get_one("SELECT SQL_CACHE count(*) AS number FROM $tablename WHERE status=3 $condition ","CACHE");
			$pages = $listpages ? listpages($catid, $r['number'], $page, $articlenum) : phppages($r['number'], $page, $articlenum);
		}
		$ordertype = $ordertypes[$ordertype];
		$limit = $articlenum ? " LIMIT $offset, $articlenum " : 'LIMIT 0, 10';
		$articles = array();
		$result = $db->query("SELECT SQL_CACHE articleid,catid,typeid,title,style,islink,showcommentlink,introduce,author,hits,thumb,addtime,listorder,linkurl $FIELD[$tablename] FROM $tablename WHERE status=3 $condition ORDER BY $ordertype $limit ","CACHE");
		while($r = $db->fetch_array($result))
		{
			$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['stitle'] = style(str_cut($r['title'], $titlelen , '...'), $r['style']);
			$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
			$r['introduce'] = $introducelen ? str_cut($r['introduce'], $introducelen , '...') : '';
			if($showcatname)
			{
				$r['catname'] = $CATEGORY[$r['catid']]['catname'];
				$r['catlinkurl'] = linkurl($CATEGORY[$r['catid']]['linkurl']);
			}
			$articles[] = $r;
		}
		$db->free_result($result);
        if($temp_id) $TEMP['tag'][$temp_id] = $articles;
	}
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_article_list';
	include template('article', $templateid);
}

function article_thumb($templateid = '', $channelid = 1, $catid = 0, $child = 1, $specialid = 0, $page = 0, $articlenum = 10, $titlelen = 20, $introducelen = 0, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showalt = 0, $target = 0, $imgwidth = 100, $imgheight = 100, $cols = 1, $username = '')
{
	global $db, $PHP_TIME, $CONFIG, $CHANNEL, $CHA, $CATEGORY, $FIELD, $TEMP, $skindir;
	$temp_id = 0;
	if($page == 0 && defined('CREATEHTML'))
	{
		$temp_id = $templateid.$channelid.$catid.$child.$specialid.$page.$articlenum.$titlelen.$introducelen.$typeid.$posid.$datenum.$ordertype.$datetype.$showalt.$target.$imgwidth.$imgheight.$cols.$username;
	}
	if($temp_id && isset($TEMP['tag'][$temp_id])) 
	{
        $articles = $TEMP['tag'][$temp_id];
	}
	else
	{
		if(!isset($CHA) || $CHA['channelid'] != $channelid) channel_setting($channelid);
		$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
		$ordertypes = array('listorder DESC, articleid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
		$channelid = intval($channelid);
		$page = isset($page) ? intval($page) : 1;
		$specialid = intval($specialid);
		$typeid = intval($typeid);
		if($datetype < 0 || $datetype > 6) $datetype = 0;
		if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
		$tablename = $CONFIG['tablepre'].'article_'.$channelid;
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
			$articleids = @file_get_contents(PHPCMS_ROOT.'/'.$CHANNEL[$channelid]['channeldir'].'/pos/'.$posid.'.txt');
			if($articleids) $condition .= " AND articleid IN($articleids)";
		}
		if($specialid) $condition .= " AND specialid=$specialid ";
		if($typeid) $condition .= " AND typeid=$typeid ";
		if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
		if($username) $condition .= " AND username='$username' ";
		$offset = $page ? ($page-1)*$articlenum : 0;
		if($page && $articlenum)
		{
			$r = $db->get_one("SELECT count(*) AS number FROM $tablename WHERE status=3 $condition ","CACHE");
			$pages = $listpages ? listpages($catid, $r['number'], $page, $articlenum) : phppages($r['number'], $page, $articlenum);
		}
		$ordertype = $ordertypes[$ordertype];
		$limit = $articlenum ? " LIMIT $offset, $articlenum " : 'LIMIT 0, 10';
		$articles = array();
		$result = $db->query("SELECT articleid,catid,typeid,title,style,islink,introduce,author,hits,thumb,addtime,status,listorder,ishtml,urlruleid,linkurl $FIELD[$tablename] FROM $tablename WHERE status=3 AND thumb!='' $condition ORDER BY $ordertype $limit ","CACHE");
		while($r = $db->fetch_array($result))
		{
			$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['stitle'] = style(str_cut($r['title'], $titlelen , '...'), $r['style']);
			$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
			$r['introduce'] = $introducelen ? str_cut($r['introduce'], $introducelen , '...') : '';
			$r['thumb'] = imgurl($r['thumb']);
			if($showalt) $r['alt'] = $r['title'];
			$articles[] = $r;
		}
		$db->free_result($result);
        if($temp_id) $TEMP['tag'][$temp_id] = $articles;
	}
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_article_thumb';
	include template('article',$templateid);
}

function article_slide($templateid = '', $channelid = 1, $catid = 0, $child = 1, $specialid = 0, $articlenum = 5, $titlelen = 30, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $imgwidth = 200, $imgheight = 180, $timeout = 5, $effectid = -1, $username = '')
{
	global $db, $PHP_TIME, $CONFIG, $CHANNEL, $CHA, $CATEGORY, $FIELD, $skindir;
	if(!isset($CHA) || $CHA['channelid'] != $channelid) channel_setting($channelid);
	$ordertypes = array('listorder DESC, articleid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
	$specialid = intval($specialid);
	$typeid = intval($typeid);
	if($articlenum > 6) $articlenum = 6;
	if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
	$tablename = $CONFIG['tablepre'].'article_'.$channelid;
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
		$articleids = @file_get_contents(PHPCMS_ROOT.'/'.$CHANNEL[$channelid]['channeldir'].'/pos/'.$posid.'.txt');
		if($articleids) $condition .= " AND articleid IN($articleids)";
	}
	if($specialid) $condition .= " AND specialid=$specialid ";
	if($typeid) $condition .= " AND typeid=$typeid ";
	if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
	if($username) $condition .= " AND username='$username' ";
	$ordertype = $ordertypes[$ordertype];
	$limit = $articlenum ? " LIMIT 0, $articlenum " : 'LIMIT 0, 5';
	$k = 0;
	$flash_pics = '';
	$flash_links = '';
	$flash_texts = '';
	$articles = array();
	$result = $db->query("SELECT articleid,catid,typeid,title,style,islink,introduce,author,hits,thumb,addtime,status,listorder,ishtml,urlruleid,linkurl $FIELD[$tablename] FROM $tablename WHERE status=3 AND thumb!='' $condition ORDER BY $ordertype $limit ","CACHE");
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
		$articles[] = $r;
	}
	$db->free_result($result);
	if(empty($articles))
	{
		$articles[0]['thumb'] = $flash_pics = PHPCMS_PATH.'images/nopic.gif';
		$articles[0]['linkurl'] = $flash_links = '#';
		$articles[0]['title'] = $flash_texts = 'No Picture';
	}
	$timeout = $timeout*1000;
	if(!$templateid) $templateid = 'tag_article_slide';
	include template('article', $templateid);
}

function article_related($templateid = '', $channelid = 1, $keywords = '', $articleid = 0, $articlenum = 10, $titlelen = 30, $datetype = 0)
{
	global $db, $PHP_TIME, $CONFIG, $MODULE, $FIELD, $skindir;
	if(!$keywords) return '';
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$articleid = intval($articleid);
	$keywords = str_replace(',', '+', addslashes($keywords));
	$articlenum++;
	$tablename = $CONFIG['tablepre'].'article_'.$channelid;
	$articles = array();
	$query = "SELECT articleid,catid,typeid,title,style,showcommentlink,addtime,linkurl $FIELD[$tablename] FROM $tablename WHERE status=3 AND MATCH (keywords) AGAINST ('$keywords' IN BOOLEAN MODE) ORDER BY listorder DESC,articleid DESC LIMIT 0,$articlenum ";
	$result = $db->query($query);
	while($r = $db->fetch_array($result))
	{
		if($r['articleid'] == $articleid) continue;
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$r['stitle'] = style(str_cut($r['title'], $titlelen , '...'), $r['style']);
		$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
		$articles[] = $r;
	}
	$db->free_result($result);
	if(!$templateid) $templateid = 'tag_article_related';
	include template('article', $templateid);
}
?>