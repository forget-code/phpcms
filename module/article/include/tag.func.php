<?php
function article_list($templateid = '', $channelid = 1, $catid = 0, $child = 1, $specialid = 0, $page = 0, $articlenum = 10, $titlelen = 30, $introducelen = 0, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showcatname = 0, $showauthor = 0, $showhits = 0, $target = 0, $cols = 1, $username = '') 
{
	global $db, $PHP_TIME, $CHA, $CATEGORY, $MODULE;
	$cat = (!isset($CHA) || $CHA['channelid'] != $channelid) ? cache_read('categorys_'.$channelid.'.php') : $CATEGORY;
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, articleid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
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
		$articleids = @file_get_contents(PHPCMS_ROOT.'/'.$CHA['channeldir'].'/pos/'.$posid.'.txt');
		if($articleids) $condition .= " AND articleid IN($articleids)";
	}
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$condition .= $username ? " AND username='$username' " : '';
	$offset = $page ? ($page-1)*$articlenum : 0;
	if($page && $articlenum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".channel_table('article', $channelid)." WHERE status=3 $condition ","CACHE");
		$pages = (is_numeric($catid) && $catid > 0) ? listpages($catid, $r['number'], $page, $articlenum) : phppages($r['number'], $page, $articlenum);
	}
	$pages = isset($pages) ? $pages : '';
	$ordertype = $ordertypes[$ordertype];
	$limit = $articlenum ? " LIMIT $offset, $articlenum " : 'LIMIT 0, 10';
	$articles = array();
	$result = $db->query("SELECT articleid,catid,typeid,title,style,islink,showcommentlink,introduce,author,hits,thumb,addtime,listorder,linkurl FROM ".channel_table('article', $channelid)." WHERE status=3 $condition ORDER BY $ordertype $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
		$r['stitle'] = str_cut($r['title'], $str_length , '...');
		$r['stitle'] = style($r['stitle'], $r['style']);
		$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
		$r['introduce'] = $introducelen ? str_cut($r['introduce'], $introducelen , '...') : '';
		if($showcatname)
		{
			$r['catname'] = $cat[$r['catid']]['catname'];
			$r['catlinkurl'] = $cat[$r['catid']]['linkurl'];
		}
		$articles[] = $r;
	}
	$db->free_result($result);
	$target = $target ? 'target="_blank"' : '';
	$width = ceil(100/$cols).'%';
	$templateid = $templateid ? $templateid : 'tag_article_list';
	include template('article', $templateid);
}

function article_thumb($templateid = '', $channelid = 1, $catid = 0, $child = 1, $specialid = 0, $page = 0, $articlenum = 10, $titlelen = 20, $introducelen = 0, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showalt = 0, $target = 0, $imgwidth = 100, $imgheight = 100, $cols = 1, $username = '')
{
	global $db, $PHP_TIME, $CHA, $CATEGORY;
	$cat = (!isset($CHA) || $CHA['channelid'] != $channelid) ? cache_read('categorys_'.$channelid.'.php') : $CATEGORY;
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, articleid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
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
		$articleids = @file_get_contents(PHPCMS_ROOT.'/'.$CHA['channeldir'].'/pos/'.$posid.'.txt');
		if($articleids) $condition .= " AND articleid IN($articleids)";
	}
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$condition .= $username ? " AND username='$username' " : '';
	$offset = $page ? ($page-1)*$articlenum : 0;
	if($page && $articlenum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".channel_table('article', $channelid)." WHERE status=3 $condition ","CACHE");
		$pages = (is_numeric($catid) && $catid > 0) ? listpages($catid, $r['number'], $page, $articlenum) : phppages($r['number'], $page, $articlenum);
	}
	$pages = isset($pages) ? $pages : '';
	$ordertype = $ordertypes[$ordertype];
	$limit = $articlenum ? " LIMIT $offset, $articlenum " : 'LIMIT 0, 10';
	$articles = array();
	$result = $db->query("SELECT articleid,catid,typeid,title,style,islink,introduce,author,hits,thumb,addtime,status,listorder,ishtml,urlruleid,linkurl FROM ".channel_table('article', $channelid)." WHERE status=3 AND thumb!='' $condition ORDER BY $ordertype $limit ","CACHE");
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
		$articles[] = $r;
	}
	$db->free_result($result);
	$target = $target ? 'target="_blank"' : '';
	$width = ceil(100/$cols).'%';
	$templateid = $templateid ? $templateid : 'tag_article_thumb';
	include template('article',$templateid);
}

function article_slide($templateid = '', $channelid = 1, $catid = 0, $child = 1, $specialid = 0, $articlenum = 5, $titlelen = 30, $typeid = 0, $posid = 0, $datenum = 0, $ordertype = 0, $imgwidth = 200, $imgheight = 180, $timeout = 5, $effectid = -1, $username = '')
{
	global $db, $PHP_TIME, $CHA, $CATEGORY;
	$cat = (!isset($CHA) || $CHA['channelid'] != $channelid) ? cache_read('categorys_'.$channelid.'.php') : $CATEGORY;
	$ordertypes = array('listorder DESC, articleid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC', 'comments DESC', 'comments ASC');
	$channelid = intval($channelid);
	$specialid = intval($specialid);
	$typeid = intval($typeid);
	if($articlenum > 9) $articlenum = 9;
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
		$articleids = @file_get_contents(PHPCMS_ROOT.'/'.$CHA['channeldir'].'/pos/'.$posid.'.txt');
		if($articleids) $condition .= " AND articleid IN($articleids)";
	}
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$condition .= $username ? " AND username='$username' " : '';
	$ordertype = $ordertypes[$ordertype];
	$limit = $articlenum ? " LIMIT 0, $articlenum " : 'LIMIT 0, 5';
	$k = 0;
	$flash_pics = '';
	$flash_links = '';
	$flash_texts = '';
	$articles = array();
	$result = $db->query("SELECT articleid,catid,typeid,title,style,islink,introduce,author,hits,thumb,addtime,status,listorder,ishtml,urlruleid,linkurl FROM ".channel_table('article', $channelid)." WHERE status=3 AND thumb!='' $condition ORDER BY $ordertype $limit ","CACHE");
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
		$articles[]=$r;
	}
	if(empty($articles))
	{
		$articles[0]['thumb'] = $flash_pics = PHPCMS_PATH.'images/nopic.gif';
		$articles[0]['linkurl'] = $flash_links = '#';
		$articles[0]['title'] = $flash_texts = 'No Picture';
	}
	$db->free_result($result);
	$timeout = $timeout*1000;
	$templateid = $templateid ? $templateid : 'tag_article_slide';
	include template('article',$templateid);
}

function article_related($templateid = '', $channelid = 1, $keywords = '', $articleid = 0, $articlenum = 10, $titlelen = 30, $datetype = 0)
{
	global $db,$PHP_TIME,$MODULE;
	if(!$keywords) return '';
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$channelid = intval($channelid);
	$articleid = intval($articleid);
	$dkeywords = explode(',', $keywords);
	$sql = '';
	foreach($dkeywords as $k=>$v)
	{
		if($k > 2 ) break;
		$sql .= $k ? " OR title like '%$v%' " : " title like '%$v%' ";
	}
	$articlenum++;
	$articles = array();
	$result = $db->query("SELECT articleid,catid,typeid,title,style,showcommentlink,addtime,linkurl FROM ".channel_table('article', $channelid)." WHERE status=3 AND ($sql) ORDER BY listorder DESC,articleid DESC LIMIT 0,$articlenum ","CACHE");
	while($r = $db->fetch_array($result))
	{
		if($r['articleid'] == $articleid) continue;
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$str_length = $r['typeid'] ? $titlelen-6 : $titlelen;
		$r['stitle'] = str_cut($r['title'], $str_length , '...');
		$r['stitle'] = style($r['stitle'], $r['style']);
		$r['type'] = $r['typeid'] ? show_type($channelid, $r['typeid']) : '';
		$articles[] = $r;
	}
	$db->free_result($result);
	$templateid = $templateid ? $templateid : 'tag_article_related';
	include template('article', $templateid);
}
?>