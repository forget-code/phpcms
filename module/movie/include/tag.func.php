<?php
function movie_list($templateid = '', $channelid = 2, $catid = 0, $child = 1, $specialid = 0, $page = 0, $movienum = 10, $titlelen = 30, $introducelen = 0, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showcatname = 0, $showauthor = 0, $showmovies = 0, $target = 0, $cols = 1, $username = '', $letter = 0) 
{
	global $db, $PHP_TIME, $CHA, $CATEGORY,$skindir,$mod,$FIELD,$CHANNEL,$TEMP;
	$temp_id = 0;
	if($page == 0 && defined('CREATEHTML'))
	{
		$temp_id = $templateid.$channelid.$catid.$child.$specialid.$page.$movienum.$titlelen.$introducelen.$typeid.$posid.$datenum.$ordertype.$datetype.$showcatname.$showauthor.$showmovies.$target.$cols.$username.$letter;
	}
	if($temp_id && isset($TEMP['tag'][$temp_id])) 
	{
        $movies = $TEMP['tag'][$temp_id];
	}
	else
	{
		if(!isset($CHA) || $CHA['channelid'] != $channelid) channel_setting($channelid);
		$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
		$ordertypes = array('listorder DESC, edittime DESC', 'edittime DESC', 'movieid ASC', 'totalview DESC', 'totalview ASC', 'comments DESC', 'comments ASC');
		$channelid = intval($channelid);
		$page = isset($page) ? intval($page) : 1;
		$specialid = intval($specialid);
		$typeid = intval($typeid);
		if($datetype < 0 || $datetype > 6) $datetype = 0;
		if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
		if($cols < 1) $cols = 1;
		$tablename = channel_table('movie', $channelid);
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
		$condition .= $specialid ? " AND specialid=$specialid " : '';
		$condition .= $typeid ? " AND typeid=$typeid " : '';
		if($posid)
		{
			$movieids = @file_get_contents(PHPCMS_ROOT.'/'.$CHA['channeldir'].'/pos/'.$posid.'.txt');
			if($movieids) $condition .= " AND movieid IN($movieids)";
		}
		$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
		$condition .= $username ? " AND username='$username' " : '';
		$condition .= $letter ? " AND letter='$letter' " : '';

		$offset = $page ? ($page-1)*$movienum : 0;
		if($page && $movienum)
		{
			$r = $db->get_one("SELECT count(movieid) AS number FROM ".channel_table('movie', $channelid)." WHERE status=3 $condition ","CACHE");
			$pages = (is_numeric($catid) && $catid > 0) ? listpages($catid, $r['number'], $page, $movienum) : phppages($r['number'], $page, $movienum);
		}
		$pages = isset($pages) ? $pages : '';
		$ordertype = $ordertypes[$ordertype];
		$limit = $movienum ? " LIMIT $offset, $movienum " : "LIMIT 0, 10";
		$result=$db->query("SELECT movieid,catid,typeid,title,style,introduce,thumb,addtime,linkurl,totalview,stars $FIELD[$tablename] FROM $tablename WHERE status=3 $condition ORDER BY $ordertype $limit ","CACHE");
		$movies = array();
		while($r=$db->fetch_array($result))
		{
			$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
			$r['linkurl'] = linkurl($r['linkurl']);
			$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
			$r['stitle'] = str_cut($r['title'], $str_length , '...');
			$r['stitle'] = style($r['stitle'], $r['style']);
			$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
			$r['introduce'] = $introducelen ? str_cut(strip_tags($r['introduce']), $introducelen , '...') : '';
			if($mod == 'movie') $r['stars'] = stars($r['stars']);
			if($showcatname)
			{
				$r['catname'] = $CATEGORY[$r['catid']]['catname'];
				$r['catlinkurl'] = linkurl($CATEGORY[$r['catid']]['linkurl']);
			}
			$movies[]=$r;
		}
		$db->free_result($result);
		if($temp_id) $TEMP['tag'][$temp_id] = $movies;
	}
		$target = $target ? 'target="_blank"' : '';
		$width = ceil(100/$cols).'%';
		$templateid = $templateid ? $templateid : 'tag_movie_list';
		include template('movie',$templateid);
}

function movie_thumb($templateid = '', $channelid = 2, $catid = 0, $child = 1, $specialid = 0, $page = 0, $movienum = 10, $titlelen = 20, $introducelen = 0, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showalt = 0, $target = 0, $imgwidth = 100, $imgheight = 100, $cols = 1, $username = '', $onlythumb = 1)
{
	global $db, $PHP_TIME, $CHA, $CATEGORY,$skindir,$mod,$FIELD,$CHANNEL,$TEMP;
	$temp_id = 0;
	if($page == 0 && defined('CREATEHTML'))
	{
		$temp_id = $templateid.$channelid.$catid.$child.$specialid.$page.$movienum.$titlelen.$introducelen.$typeid.$posid.$datenum.$ordertype.$datetype.$showalt.$target.$imgwidth.$imgheight.$cols.$username.$onlythumb;
	}
	if($temp_id && isset($TEMP['tag'][$temp_id])) 
	{
        $movies = $TEMP['tag'][$temp_id];
	}
	else
	{
		if(!isset($CHA) || $CHA['channelid'] != $channelid) channel_setting($channelid);
		$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
		$ordertypes = array('listorder DESC, edittime DESC', 'edittime DESC', 'movieid ASC', 'totalview DESC', 'totalview ASC', 'comments DESC', 'comments ASC');
		$channelid = intval($channelid);
		$page = isset($page) ? intval($page) : 1;
		$specialid = intval($specialid);
		$typeid = intval($typeid);
		if($datetype < 0 || $datetype > 6) $datetype = 0;
		if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
		$tablename = channel_table('movie', $channelid);
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
		$condition .= $specialid ? " AND specialid=$specialid " : '';
		$condition .= $typeid ? " AND typeid=$typeid " : '';
		if($posid)
		{
			$movieids = @file_get_contents(PHPCMS_ROOT.'/'.$CHA['channeldir'].'/pos/'.$posid.'.txt');
			if($movieids) $condition .= " AND movieid IN($movieids)";
		}
		$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
		$condition .= $username ? " AND username='$username' " : '';
		$condition .= $onlythumb ? " AND thumb!='' " : '';
		$offset = $page ? ($page-1)*$movienum : 0;
		if($page && $movienum)
		{
			$r = $db->get_one("SELECT count(movieid) AS number FROM ".channel_table('movie', $channelid)." WHERE status=3 $condition ","CACHE");
			$pages = (is_numeric($catid) && $catid > 0) ? listpages($catid, $r['number'], $page, $movienum) : phppages($r['number'], $page, $movienum);
		}
		$pages = isset($pages) ? $pages : '';
		$ordertype = $ordertypes[$ordertype];
		$limit = $movienum ? " LIMIT $offset, $movienum " : 'LIMIT 0, 10';
		$result=$db->query("SELECT movieid,catid,typeid,title,style,introduce,thumb,addtime,linkurl,totalview,stars $FIELD[$tablename] FROM $tablename WHERE status=3 $condition ORDER BY $ordertype $limit ","CACHE");
		$movies = array();
		while($r=$db->fetch_array($result))
		{
			$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
			$r['linkurl'] = linkurl($r['linkurl']);
			$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
			$r['stitle'] = str_cut($r['title'], $str_length , '...');
			$r['stitle'] = style($r['stitle'], $r['style']);
			$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
			$r['introduce'] = $introducelen ? str_cut(strip_tags($r['introduce']), $introducelen , '...') : '';
			$r['thumb'] = imgurl($r['thumb']);
			if($mod == 'movie') $r['stars'] = stars($r['stars']);
			if($showalt) $r['alt'] = $r['title'];
			$movies[]=$r;
		}
		$db->free_result($result);
		if($temp_id) $TEMP['tag'][$temp_id] = $movies;
	}
	$target = $target ? 'target="_blank"' : '';
	$width = ceil(100/$cols).'%';
	$templateid = $templateid ? $templateid : 'tag_movie_thumb';
	include template('movie',$templateid);
}

function movie_slide($templateid = '', $channelid = 2, $catid = 0, $child = 1, $specialid = 0, $movienum = 5, $titlelen = 30, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $imgwidth = 200, $imgheight = 180, $timeout = 5, $effectid = -1, $username = '', $thumbtype = 0)
{
	global $db, $PHP_TIME, $CHA, $CATEGORY,$skindir,$mod,$FIELD,$CHANNEL;
	if(!isset($CHA) || $CHA['channelid'] != $channelid) channel_setting($channelid);
	$ordertypes = array('listorder DESC, edittime DESC', 'edittime DESC', 'movieid ASC', 'totalview DESC', 'totalview ASC', 'comments DESC', 'comments ASC');
	$channelid = intval($channelid);
	$specialid = intval($specialid);
	$typeid = intval($typeid);
	if($thumbtype){
		$thumb = 'bigthumb';
	}
	else
	{
		$thumb = 'thumb';
	}
	if($movienum > 6) $movienum = 6;
	if($ordertype < 0 || $ordertype > 6) $ordertype = 0;
	$tablename = channel_table('movie', $channelid);
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
	$condition .= $specialid ? " AND specialid=$specialid " : '';
	$condition .= $typeid ? " AND typeid=$typeid " : '';
	if($posid)
	{
		$movieids = @file_get_contents(PHPCMS_ROOT.'/'.$CHA['channeldir'].'/pos/'.$posid.'.txt');
		if($movieids) $condition .= " AND movieid IN($movieids)";
	}
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$condition .= $username ? " AND username='$username' " : '';
	$ordertype = $ordertypes[$ordertype];
	$limit = $movienum ? " LIMIT 0, $movienum " : 'LIMIT 0, 5';
	$k = 0;
	$flash_pics = '';
	$flash_links = '';
	$flash_texts = '';
	$movies = array();
	$result = $db->query("SELECT movieid,catid,typeid,title,style,introduce,$thumb,addtime,linkurl $FIELD[$tablename] FROM $tablename WHERE status=3 AND $thumb!='' $condition ORDER BY $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['linkurl'] = str_replace('&page=1', '', linkurl($r['linkurl']));
		$r['title'] = addslashes(str_cut($r['title'], $titlelen, '...'));
		$r['thumb'] = imgurl($r[$thumb]);
		$s = $k ? '|' : '';
		$flash_pics .= $s.$r['thumb'];
		$flash_links .= $s.$r['linkurl'];
		$flash_texts .= $s.$r['title'];
		$k = 1;
		$movies[]=$r;
	}
	if(empty($movies))
	{
		$movies[0]['thumb'] = $flash_pics = PHPCMS_PATH.'images/nopic.gif';
		$movies[0]['linkurl'] = $flash_links = '#';
		$movies[0]['title'] = $flash_texts = 'No Picture';
	}
	$db->free_result($result);
	$timeout = $timeout*1000;
	$templateid = $templateid ? $templateid : 'tag_movie_slide';
	include template('movie',$templateid);
}

function movie_related($templateid = '', $channelid = 2, $keywords = '', $movieid = 0, $movienum = 10, $titlelen = 30, $datetype = 0)
{
	global $db,$PHP_TIME;
	if(!$keywords) return '';
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$channelid = intval($channelid);
	$movieid = intval($movieid);
	$keywords = str_replace(',', '+', $keywords);
	$movienum++;
	$movies = array();
	$result = $db->query("SELECT movieid,catid,typeid,title,style,addtime,linkurl FROM ".channel_table('movie', $channelid)." WHERE status=3 AND MATCH (keywords) AGAINST ('$keywords' IN BOOLEAN MODE) ORDER BY listorder DESC,movieid DESC LIMIT 0,$movienum ","CACHE");
	while($r = $db->fetch_array($result))
	{
		if($r['movieid'] == $movieid) continue;
		$r['adddate'] = $datetype ? date($datetypes[$datetype], $r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
		$r['stitle'] = str_cut($r['title'], $str_length , '...');
		$r['stitle'] = style($r['stitle'], $r['style']);
		$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
		$movies[] = $r;
	}
	$db->free_result($result);
	$templateid = $templateid ? $templateid : 'tag_movie_related';
	include template('movie',$templateid);
}
?>