<?php
function yp_article_list($templateid = '', $catid = 0, $child = 1, $page = 0, $articlenum = 10, $titlelen = 30, $introducelen = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showcatname = 0, $showauthor = 0, $showhits = 0, $target = 0, $cols = 1, $username = '', $elite = 0) 
{
	global $db, $PHP_TIME, $CONFIG, $CATEGORY, $MODULE, $TEMP, $categroy,$MOD,$skindir;
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, articleid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
	$page = isset($page) ? intval($page) : 1;
	if($datetype < 0 || $datetype > 6) $datetype = 0;
	if($ordertype < 0 || $ordertype > 4) $ordertype = 0;
	$listpages = 0;
	$status = $elite ? "status=5 " : "status>=3 ";
	$TRADE_ARTICLE = cache_read('trades_article.php');
	$condition = '';
	if($catid)
	{
		if(is_numeric($catid))
		{
			if($child && $TRADE_ARTICLE[$catid]['child'] && $TRADE_ARTICLE[$catid]['arrchildid'])
			{
				$condition .= ' AND catid IN ('.$TRADE_ARTICLE[$catid]['arrchildid'].') ';
			}
			else
			{
				$condition .= " AND catid=$catid ";
				$listpages = 1;
			}
		}
		else
		{
			$catid = new_addslashes($catid);
			$condition .= " AND catid IN ($catid) ";
		}
	}
	if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
	if($username) $condition .= " AND username='$username' ";
	$offset = $page ? ($page-1)*$articlenum : 0;
	if($page && $articlenum)
	{
		$r = $db->get_one("SELECT SQL_CACHE count(*) AS number FROM ".TABLE_YP_ARTICLE." WHERE $status $condition ");
		if($categroy)
		{
			$pages = companypages(3, $r['number'], $page,$articlenum);
		}
		else
		{
			$pages = phppages($r['number'], $page, $articlenum);
		}
	}
	$ordertype = $ordertypes[$ordertype];
	$limit = $articlenum ? " LIMIT $offset, $articlenum " : 'LIMIT 0, 10';
	$articles = array();
	$result = $db->query("SELECT SQL_CACHE articleid,catid,title,style,content,hits,thumb,addtime,listorder,linkurl FROM ".TABLE_YP_ARTICLE." WHERE $status $condition ORDER BY $ordertype $limit ");
	while($r = $db->fetch_array($result))
	{
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$r['stitle'] = style(str_cut($r['title'], $titlelen , '...'), $r['style']);
		$r['introduce'] = $introducelen ? str_cut(strip_tags($r['content']), $introducelen , '...') : '';
		if($showcatname)
		{
			$r['catname'] = $TRADE_ARTICLE[$r['catid']]['tradename'];
			$r['catlinkurl'] = $MODULE['yp']['linkurl'].$TRADE_ARTICLE[$r['catid']]['linkurl'];
		}
		$articles[] = $r;
	}
	$db->free_result($result);
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_article_list';
	include template('yp', $templateid);
}

function yp_article_thumb($templateid = '', $catid = 0, $child = 1, $page = 0, $articlenum = 10, $titlelen = 20, $introducelen = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showalt = 0, $target = 0, $imgwidth = 100, $imgheight = 100, $cols = 1, $username = '', $elite = 0)
{
	global $db, $PHP_TIME, $CONFIG, $CATEGORY, $TEMP, $categroy,$MOD,$skindir;
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, articleid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
	$page = isset($page) ? intval($page) : 1;
	$status = $elite ? "status=5 " : "status>=3 ";
	if($datetype < 0 || $datetype > 6) $datetype = 0;
	if($ordertype < 0 || $ordertype > 4) $ordertype = 0;
	$listpages = 0;
	$condition = '';
	if($catid)
	{
		if(is_numeric($catid))
		{
			if($child && $TRADE_ARTICLE[$catid]['child'] && $TRADE_ARTICLE[$catid]['arrchildid'])
			{
				$condition .= ' AND catid IN ('.$TRADE_ARTICLE[$catid]['arrchildid'].') ';
			}
			else
			{
				$condition .= " AND catid=$catid ";
				$listpages = 1;
			}
		}
		else
		{
			$catid = new_addslashes($catid);
			$condition .= " AND catid IN ($catid) ";
		}
	}
	if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
	if($username) $condition .= " AND username='$username' ";
	$offset = $page ? ($page-1)*$articlenum : 0;
	if($page && $articlenum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_YP_ARTICLE." WHERE $status $condition ");
		if($categroy)
		{
			$pages = companypages(3, $r['number'], $page,$articlenum);
		}
		else
		{
			$pages = $MOD['tohtml'] ? article_list_pages($catid, $r['number'], $page, $articlenum) : phppages($r['number'], $page, $articlenum);

		}
	}
	$ordertype = $ordertypes[$ordertype];
	$limit = $articlenum ? " LIMIT $offset, $articlenum " : 'LIMIT 0, 10';
	$articles = array();
	$result = $db->query("SELECT SQL_CACHE articleid,catid,title,style,content,hits,thumb,addtime,listorder,linkurl FROM ".TABLE_YP_ARTICLE." WHERE $status AND thumb!='' $condition ORDER BY $ordertype $limit ");
	while($r = $db->fetch_array($result))
	{
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$r['stitle'] = style(str_cut($r['title'], $titlelen , '...'), $r['style']);
		$r['introduce'] = $introducelen ? str_cut(strip_tags($r['content']), $introducelen , '...') : '';
		$r['thumb'] = imgurl($r['thumb']);
		if($showalt) $r['alt'] = $r['title'];
		$articles[] = $r;
	}	
	$db->free_result($result);
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_article_thumb';
	include template('yp',$templateid);
}

function yp_article_slide($templateid = '', $catid = 0, $child = 1, $articlenum = 5, $titlelen = 30, $posid = 0, $datenum = 0, $ordertype = 0, $imgwidth = 200, $imgheight = 180, $timeout = 5, $effectid = -1, $username = '', $elite = 0)
{
	global $db, $PHP_TIME, $CONFIG, $CATEGORY,$MOD, $skindir;
	$ordertypes = array('listorder DESC, articleid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
	if($articlenum > 6) $articlenum = 6;
	if($ordertype < 0 || $ordertype > 4) $ordertype = 0;
	$status = $elite ? "status=5 " : "status>=3 ";
	$listpages = 0;
	$condition = '';
	if($catid)
	{
		if(is_numeric($catid))
		{
			if($child && $TRADE_ARTICLE[$catid]['child'] && $TRADE_ARTICLE[$catid]['arrchildid'])
			{
				$condition .= ' AND catid IN ('.$TRADE_ARTICLE[$catid]['arrchildid'].') ';
			}
			else
			{
				$condition .= " AND catid=$catid ";
				$listpages = 1;
			}
		}
		else
		{
			$catid = new_addslashes($catid);
			$condition .= " AND catid IN ($catid) ";
		}
	}
	if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
	if($username) $condition .= " AND username='$username' ";
	$ordertype = $ordertypes[$ordertype];
	$limit = $articlenum ? " LIMIT 0, $articlenum " : 'LIMIT 0, 5';
	$k = 0;
	$flash_pics = '';
	$flash_links = '';
	$flash_texts = '';
	$articles = array();
	$result = $db->query("SELECT articleid,catid,title,style,content,hits,thumb,addtime,status,listorder,linkurl FROM ".TABLE_YP_ARTICLE." WHERE $status AND thumb!='' $condition ORDER BY $ordertype $limit ");
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
	include template('yp', $templateid);
}

function yp_product_list($templateid = '', $catid = 0, $child = 1, $page = 0, $productnum = 10, $titlelen = 30, $introducelen = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showcatname = 0, $showauthor = 0, $showhits = 0, $target = 0, $cols = 1, $username = '', $elite = 0) 
{
	global $db, $PHP_TIME, $CONFIG, $CATEGORY, $MODULE, $TEMP, $action,$PHP_DOMAIN,$categroy,$skindir;
	$temp_id = 0;
	if($page == 0 && defined('CREATEHTML'))
	{
		$temp_id = $templateid.$catid.$child.$page.$productnum.$titlelen.$introducelen.$posid.$datenum.$ordertype.$datetype.$showcatname.$showauthor.$showhits.$target.$cols.$username.$elite;
	}
	if($temp_id && isset($TEMP['tag'][$temp_id])) 
	{
        $products = $TEMP['tag'][$temp_id];
	}
	else
	{
		$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
		$ordertypes = array('listorder DESC, productid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
		$page = isset($page) ? intval($page) : 1;
		if($datetype < 0 || $datetype > 6) $datetype = 0;
		if($ordertype < 0 || $ordertype > 4) $ordertype = 0;
		$listpages = 0;
		$status = $elite ? "status=5 " : "status>=3";
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
				$catid = new_addslashes($catid);
				$condition .= " AND catid IN ($catid) ";
			}
		}

		if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
		if($username) $condition .= " AND username='$username' ";
		$offset = $page ? ($page-1)*$productnum : 0;
		
		if($page && $productnum)
		{
			$r = $db->get_one("SELECT SQL_CACHE count(*) AS number FROM ".TABLE_YP_PRODUCT." WHERE $status $condition ");
			if($categroy)
			{
				$pages = companypages(3, $r['number'], $page,$productnum);
			}
			else
			{		
				$pages = $listpages ? listpages($catid, $r['number'], $page,$productnum) : phppages($r['number'], $page, $productnum);
			}
		}
		
		$ordertype = $ordertypes[$ordertype];
		$limit = $productnum ? " LIMIT $offset, $productnum " : 'LIMIT 0, 10';
		$products = array();
		$result = $db->query("SELECT SQL_CACHE * FROM ".TABLE_YP_PRODUCT." WHERE $status $condition ORDER BY $ordertype $limit ");
		while($r = $db->fetch_array($result))
		{
			$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['stitle'] = style(str_cut($r['title'], $titlelen , '...'), $r['style']);
			$r['introduce'] = $introducelen ? str_cut(strip_tags($r['introduce']), $introducelen , '...') : '';
			if($showcatname)
			{
				$r['catname'] = $CATEGORY[$r['catid']]['catname'];
				$r['catlinkurl'] = linkurl($CATEGORY[$r['catid']]['linkurl']);
			}
			$products[] = $r;
		}
		$db->free_result($result);
        if($temp_id) $TEMP['tag'][$temp_id] = $products;
	}
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_product_list';
	include template('yp', $templateid);
}

function yp_product_thumb($templateid = '', $catid = 0, $child = 1, $page = 0, $number = 10,$titlelen = 20, $introducelen = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showalt = 0, $target = 0, $imgwidth = 100, $imgheight = 100, $cols = 1, $username = '', $elite = 0)
{
	global $db, $PHP_TIME, $CONFIG, $CATEGORY, $TEMP, $categroy, $skindir;
	$temp_id = 0;
	if($page == 0 && defined('CREATEHTML'))
	{
		$temp_id = $templateid.$catid.$child.$page.$number.$titlelen.$introducelen.$posid.$datenum.$ordertype.$datetype.$showalt.$target.$imgwidth.$imgheight.$cols.$username.$elite;
	}
	if($temp_id && isset($TEMP['tag'][$temp_id])) 
	{
        $products = $TEMP['tag'][$temp_id];
	}
	else
	{
		$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
		$ordertypes = array('listorder DESC, productid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
		$page = isset($page) ? intval($page) : 1;
		$status = $elite ? "status=5 " : "status>=3 ";
		if($datetype < 0 || $datetype > 6) $datetype = 0;
		if($ordertype < 0 || $ordertype > 4) $ordertype = 0;
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
				$catid = new_addslashes($catid);
				$condition .= " AND catid IN ($catid) ";
			}
		}
		if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
		if($username) $condition .= " AND username='$username' ";
		$offset = $page ? ($page-1)*$number : 0;
		if($page && $number)
		{
			$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_YP_PRODUCT." WHERE $status $condition ");
			if($categroy)
			{
				$pages = companypages(0, $r['number'], $page,$number);
			}
			else
			{
				$pages = $listpages ? listpages($catid, $r['number'], $page, $number) : phppages($r['number'], $page, $number);
			}
		}
		$ordertype = $ordertypes[$ordertype];
		$limit = $number ? " LIMIT $offset, $number " : 'LIMIT 0, 10';
		$products = array();
		$result = $db->query("SELECT SQL_CACHE * FROM ".TABLE_YP_PRODUCT." WHERE $status AND thumb!='' $condition ORDER BY $ordertype $limit ");
		while($r = $db->fetch_array($result))
		{
			$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['stitle'] = style(str_cut($r['title'], $titlelen , '...'), $r['style']);
			$r['introduce'] = $introducelen ? str_cut(strip_tags($r['introduce']), $introducelen , '...') : '';
			$r['thumb'] = imgurl($r['thumb']);
			if($showalt) $r['alt'] = $r['title'];
			$products[] = $r;
		}
		
		$db->free_result($result);
        if($temp_id) $TEMP['tag'][$temp_id] = $products;
	}
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_product_thumb';
	include template('yp',$templateid);
}

function yp_product_slide($templateid = '', $catid = 0, $child = 1, $number = 5, $titlelen = 30, $posid = 0, $datenum = 0, $ordertype = 0, $imgwidth = 200, $imgheight = 180, $timeout = 5, $effectid = -1, $username = '', $elite = 0)
{
	global $db, $PHP_TIME, $CONFIG, $CATEGORY, $skindir;
	
	$ordertypes = array('listorder DESC, productid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
	if($number > 6) $number = 6;
	if($ordertype < 0 || $ordertype > 4) $ordertype = 0;
	$status = $elite ? "status=5 " : "status>=3 ";
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
			$catid = new_addslashes($catid);
			$condition .= " AND catid IN ($catid) ";
		}
	}

	if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
	if($username) $condition .= " AND username='$username' ";
	$ordertype = $ordertypes[$ordertype];
	$limit = $number ? " LIMIT 0, $number " : 'LIMIT 0, 5';
	$k = 0;
	$flash_pics = '';
	$flash_links = '';
	$flash_texts = '';
	$products = array();
	$result = $db->query("SELECT SQL_CACHE * FROM ".TABLE_YP_PRODUCT." WHERE $status AND thumb!='' $condition ORDER BY $ordertype $limit ");
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
		$products[] = $r;
	}
	$db->free_result($result);
	if(empty($products))
	{
		$products[0]['thumb'] = $flash_pics = PHPCMS_PATH.'images/nopic.gif';
		$products[0]['linkurl'] = $flash_links = '#';
		$products[0]['title'] = $flash_texts = 'No Picture';
	}
	$timeout = $timeout*1000;
	if(!$templateid) $templateid = 'tag_product_slide';
	include template('yp', $templateid);
}

function yp_job_list($templateid = '', $station = 0, $page = 0, $jobnum = 10, $titlelen = 30, $introducelen = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showstationname = 0, $showauthor = 0, $showhits = 0, $target = 0, $cols = 1, $username = '', $elite = 0) 
{
	global $db, $PHP_TIME, $CONFIG, $CHA, $CATEGORY, $MODULE,$categroy, $skindir;
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, jobid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
	$page = isset($page) ? intval($page) : 1;
	$AREA = cache_read('areas_yp.php');
	if($datetype < 0 || $datetype > 6) $datetype = 0;
	if($ordertype < 0 || $ordertype > 4) $ordertype = 0;
	$listpages = 0;
	$status = $elite ? "status=5 " : "status>=3";
	$condition = '';
	if($station) $condition .= " AND station='$station' ";
	if($posid)
	{
		$jobids = @file_get_contents(PHPCMS_ROOT.'/'.$mod.'/pos/'.$posid.'.txt');
		if($jobids) $condition .= " AND jobid IN($jobids)";
	}
	if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
	if($username) $condition .= " AND username='$username' ";
	$offset = $page ? ($page-1)*$jobnum : 0;
	if($page && $jobnum)
	{
		$r = $db->get_one("SELECT SQL_CACHE count(*) AS number FROM ".TABLE_YP_JOB." WHERE $status $condition ");
		if($categroy)
		{
			$pages = companypages(3, $r['number'], $page,$jobnum);
		}
		else
		{			
			$pages = phppages($r['number'], $page, $jobnum);
		}
	}
	$ordertype = $ordertypes[$ordertype];
	$limit = $jobnum ? " LIMIT $offset, $jobnum " : 'LIMIT 0, 10';
	$jobs = array();
	$result = $db->query("SELECT SQL_CACHE * FROM ".TABLE_YP_JOB." WHERE $status $condition ORDER BY $ordertype $limit ");
	while($r = $db->fetch_array($result))
	{
		extract($db->get_one("SELECT companyname,linkurl FROM ".TABLE_MEMBER_COMPANY." WHERE companyid=$r[companyid]"));
		$r['companyname'] = $companyname;
		$r['url'] = $linkurl;
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$r['stitle'] = style(str_cut($r['title'], $titlelen , '...'), $r['style']);
		$r['introduce'] = $introducelen ? str_cut(strip_tags($r['introduce']), $introducelen , '...') : '';
		$r['province'] = $AREA[$r['areaid']]['areaname'];
		$jobs[] = $r;
	}
	$db->free_result($result);
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_job_list';
	include template('yp', $templateid);
}

function yp_apply_list($templateid = '', $station = 0, $page = 0, $applynum = 10, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showexperience = 0,$showschool = 0, $showspecialty = 0, $showhits = 0, $target = 0, $cols = 1, $elite = 0) 
{
	global $db, $PHP_TIME, $CONFIG, $CHA, $CATEGORY, $MODULE, $skindir;
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, applyid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
	$page = isset($page) ? intval($page) : 1;
	if($datetype < 0 || $datetype > 6) $datetype = 0;
	if($ordertype < 0 || $ordertype > 4) $ordertype = 0;
	$listpages = 0;
	$status = $elite ? "status=5 " : "status>=3";
	$condition = '';
	if($station) $condition .= " AND station='$station' ";
	if($posid)
	{
		$applyids = @file_get_contents(PHPCMS_ROOT.'/'.$mod.'/pos/'.$posid.'.txt');
		if($applyids) $condition .= " AND applyid IN($applyids)";
	}
	if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
	$offset = $page ? ($page-1)*$applynum : 0;
	if($page && $applynum)
	{
		$r = $db->get_one("SELECT SQL_CACHE count(*) AS number FROM ".TABLE_YP_APPLY." WHERE $status $condition ");
		$pages = phppages($r['number'], $page, $applynum);
	}
	$ordertype = $ordertypes[$ordertype];
	$limit = $applynum ? " LIMIT $offset, $applynum " : 'LIMIT 0, 10';
	$applys = array();
	$result = $db->query("SELECT SQL_CACHE * FROM ".TABLE_YP_APPLY." WHERE $status $condition ORDER BY $ordertype $limit ");
	while($r = $db->fetch_array($result))
	{
		@extract($db->get_one("SELECT i.gender FROM ".TABLE_MEMBER." m, ".TABLE_MEMBER_INFO." i WHERE m.username='$r[username]' AND m.userid=i.userid"));
		$r['gender'] = $gender;
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$applys[] = $r;
	}
	$db->free_result($result);
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_apply_list';
	include template('yp', $templateid);
}

function yp_company_list($templateid = '',$tradeid = 0, $child = 0, $page = 0, $elite = 0, $vip = 0,$number = 10, $length = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showcontact = 0, $showhits = 0, $target = 0, $cols = 1,$pattern = 0) 
{
	global $db, $PHP_TIME, $CONFIG, $CHA, $MODULE, $TEMP,$MOD, $skindir;
		$TRADE = cache_read('trades_trade.php');
		$AREA = cache_read('areas_yp.php');
		$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
		$ordertypes = array('listorder DESC, companyid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
		$page = isset($page) ? intval($page) : 1;
		if($datetype < 0 || $datetype > 6) $datetype = 0;
		if($ordertype < 0 || $ordertype > 4) $ordertype = 0;
		$listpages = 0;
		$condition = '';
		if($tradeid) 
		{
			if(is_numeric($tradeid))
			{
				if($child && $TRADE[$tradeid]['child'] && $TRADE[$tradeid]['arrchildid'])
				{
					$condition .= ' AND tradeid IN ('.$TRADE[$tradeid]['arrchildid'].') ';
				}
				else
				{
					$condition .= " AND tradeid=$tradeid ";
					$listpages = 1;
				}
			}
			else
			{
				$tradeid = new_addslashes($tradeid);
				$condition .= " AND tradeid IN ($tradeid) ";
			}
		}
		if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
		if($pattern) $condition .= " AND pattern LIKE '%$pattern%' ";
		if($elite) $condition .= " AND elite=1 ";
		if($vip) $condition .= " AND vip>$PHP_TIME ";
		$offset = $page ? ($page-1)*$number : 0;
		if($page && $number)
		{
			$r = $db->get_one("SELECT SQL_CACHE count(*) AS number FROM ".TABLE_MEMBER_COMPANY." WHERE status=3 $condition ");
			$pages = phppages($r['number'], $page, $number);
		}
		$ordertype = $ordertypes[$ordertype];
		$limit = $number ? " LIMIT $offset, $number " : 'LIMIT 0, 10';
		$companys = array();
		$result = $db->query("SELECT SQL_CACHE * FROM ".TABLE_MEMBER_COMPANY." WHERE status=3 $condition ORDER BY $ordertype $limit ");
		while($r = $db->fetch_array($result))
		{	
			$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
			@extract($db->get_one("SELECT userid AS t_userid FROM ".TABLE_MEMBER." WHERE username='$r[username]'"));
			$r['userid'] = $t_userid;
			$r['vip'] = $r['vip']>$PHP_TIME ? 1 : 0;
			$r['introduce'] = $length ? str_cut(strip_tags($r['introduce']), $length , '...') : '';
			$r['areaname'] = $AREA[$r['areaid']]['areaname'];
			$r['catname'] = $TRADE[$r['tradeid']]['tradename'];
			$companys[] = $r;
		}
		$db->free_result($result);
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_company_list';
	include template('yp', $templateid);
}
function yp_buy_list($templateid = '', $tradeid = 0, $child = 1, $page = 0, $productnum = 10, $titlelen = 30, $introducelen = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showcatname = 0, $showauthor = 0, $showhits = 0, $target = 0, $cols = 1, $username = '', $elite = 0) 
{
	global $db, $PHP_TIME, $CONFIG, $MODULE,$action,$PHP_DOMAIN,$categroy, $skindir;
	$TRADE_BUY = cache_read('trades_buy.php');
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, productid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
	$page = isset($page) ? intval($page) : 1;
	if($datetype < 0 || $datetype > 6) $datetype = 0;
	if($ordertype < 0 || $ordertype > 4) $ordertype = 0;
	$listpages = 0;
	$status = $elite ? "status=5 " : "status>=3";
	$condition = '';
	if($tradeid) 
	{
		if(is_numeric($tradeid))
		{
			if($child && $TRADE_BUY[$tradeid]['child'] && $TRADE_BUY[$tradeid]['arrchildid'])
			{
				$condition .= ' AND catid IN ('.$TRADE_BUY[$tradeid]['arrchildid'].') ';
			}
			else
			{
				$condition .= " AND catid=$tradeid ";
				$listpages = 1;
			}
		}
		else
		{
			$tradeid = new_addslashes($tradeid);
			$condition .= " AND catid IN ($tradeid) ";
		}
	}
	if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
	if($username) $condition .= " AND username='$username' ";
	$offset = $page ? ($page-1)*$productnum : 0;
	
	if($page && $productnum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_YP_BUY." WHERE $status $condition ");
		if($categroy)
		{
			$pages = companypages(3, $r['number'], $page,$productnum);
		}
		else
		{		
			$pages = phppages($r['number'], $page, $productnum);
		}
	}
	$ordertype = $ordertypes[$ordertype];
	$limit = $productnum ? " LIMIT $offset, $productnum " : 'LIMIT 0, 10';
	$products = array();
	$result = $db->query("SELECT SQL_CACHE * FROM ".TABLE_YP_BUY." WHERE $status $condition ORDER BY $ordertype $limit ");
	while($r = $db->fetch_array($result))
	{
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$r['stitle'] = style(str_cut($r['title'], $titlelen , '...'), $r['style']);
		$r['introduce'] = $introducelen ? str_cut(strip_tags($r['introduce']), $introducelen , '...') : '';
		if($showcatname)
		{
			$r['catname'] = $TRADE_BUY[$r['catid']]['tradename'];
			$r['catlinkurl'] = $MODULE['yp']['linkurl'].$TRADE_BUY[$r['catid']]['linkurl'];
		}
		$products[] = $r;
	}
	$db->free_result($result);
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_buy_list';
	include template('yp', $templateid);
}
function yp_sales_list($templateid = '', $tradeid = 0, $child = 1, $page = 0, $productnum = 10, $titlelen = 30, $introducelen = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showcatname = 0, $showauthor = 0, $showhits = 0, $target = 0, $cols = 1, $username = '', $elite = 0) 
{
	global $db, $PHP_TIME, $CONFIG, $MODULE,$action,$PHP_DOMAIN,$categroy, $skindir;
	$TRADE_SALES = cache_read('trades_sales.php');
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, productid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
	$page = isset($page) ? intval($page) : 1;
	if($datetype < 0 || $datetype > 6) $datetype = 0;
	if($ordertype < 0 || $ordertype > 4) $ordertype = 0;
	$listpages = 0;
	$status = $elite ? "status=5 " : "status>=3";
	$condition = '';
	if($tradeid) 
	{
		if(is_numeric($tradeid))
		{
			if($child && $TRADE_SALES[$tradeid]['child'] && $TRADE_SALES[$tradeid]['arrchildid'])
			{
				$condition .= ' AND catid IN ('.$TRADE_SALES[$tradeid]['arrchildid'].') ';
			}
			else
			{
				$condition .= " AND catid=$tradeid ";
				$listpages = 1;
			}
		}
		else
		{
			$tradeid = new_addslashes($tradeid);
			$condition .= " AND catid IN ($tradeid) ";
		}
	}

	if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
	if($username) $condition .= " AND username='$username' ";
	$offset = $page ? ($page-1)*$productnum : 0;
	if($page && $productnum)
	{
		$r = $db->get_one("SELECT SQL_CACHE count(*) AS number FROM ".TABLE_YP_SALES." WHERE $status $condition ");
		if($categroy)
		{
			$pages = companypages(3, $r['number'], $page,$productnum);
		}
		else
		{		
			$pages = phppages($r['number'], $page, $productnum);
		}
	}
	
	$ordertype = $ordertypes[$ordertype];
	$limit = $productnum ? " LIMIT $offset, $productnum " : 'LIMIT 0, 10';
	$products = array();
	$result = $db->query("SELECT SQL_CACHE * FROM ".TABLE_YP_SALES." WHERE $status $condition ORDER BY $ordertype $limit ");
	while($r = $db->fetch_array($result))
	{
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$r['stitle'] = style(str_cut($r['title'], $titlelen , '...'), $r['style']);
		$r['introduce'] = $introducelen ? str_cut(strip_tags($r['intriduce']), $introducelen , '...') : '';
		if($showcatname)
		{
			$r['catname'] = $TRADE_SALES[$r['catid']]['tradename'];
			$r['catlinkurl'] = linkurl($TRADE_SALES[$r['catid']]['linkurl']);
		}
		$products[] = $r;
	}
	$db->free_result($result);
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_sales_list';
	include template('yp', $templateid);
}
function yp_sales_thumb($templateid = '', $tradeid = 0, $child = 1, $page = 0, $number = 10,$titlelen = 20, $introducelen = 0, $posid = 0, $datenum = 0, $ordertype = 0, $datetype = 0, $showalt = 0, $target = 0, $imgwidth = 100, $imgheight = 100, $cols = 1, $username = '', $elite = 0)
{
	global $db, $PHP_TIME, $CONFIG,$categroy, $skindir;
	$TRADE_SALES = cache_read('trades_sales.php');
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$ordertypes = array('listorder DESC, productid DESC', 'edittime DESC', 'edittime ASC', 'hits DESC', 'hits ASC');
	$page = isset($page) ? intval($page) : 1;
	$status = $elite ? "status=5 " : "status>=3 ";
	if($datetype < 0 || $datetype > 6) $datetype = 0;
	if($ordertype < 0 || $ordertype > 4) $ordertype = 0;
	$listpages = 0;
	$condition = '';
	if($tradeid) 
	{
		if(is_numeric($tradeid))
		{
			if($child && $TRADE_SALES[$tradeid]['child'] && $TRADE_SALES[$tradeid]['arrchildid'])
			{
				$condition .= ' AND catid IN ('.$TRADE_SALES[$tradeid]['arrchildid'].') ';
			}
			else
			{
				$condition .= " AND catid=$tradeid ";
				$listpages = 1;
			}
		}
		else
		{
			$tradeid = new_addslashes($tradeid);
			$condition .= " AND catid IN ($tradeid) ";
		}
	}
	if($datenum) $condition .= " AND addtime>$PHP_TIME-86400*$datenum ";
	if($username) $condition .= " AND username='$username' ";
	$offset = $page ? ($page-1)*$number : 0;
	if($page && $number)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_YP_SALES." WHERE $status $condition ");
		if($categroy)
		{
			$pages = companypages(0, $r['number'], $page,$number);
		}
		else
		{
			$pages = phppages($r['number'], $page, $number);
		}
	}
	$ordertype = $ordertypes[$ordertype];
	$limit = $number ? " LIMIT $offset, $number " : 'LIMIT 0, 10';
	$products = array();
	$result = $db->query("SELECT SQL_CACHE * FROM ".TABLE_YP_SALES." WHERE $status AND thumb!='' $condition ORDER BY $ordertype $limit ");
	while($r = $db->fetch_array($result))
	{
		$r['adddate'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$r['linkurl'] = linkurl($r['linkurl']);
		$r['stitle'] = style(str_cut($r['title'], $titlelen , '...'), $r['style']);
		$r['introduce'] = $introducelen ? str_cut(strip_tags($r['introduce']), $introducelen , '...') : '';
		$r['thumb'] = imgurl($r['thumb']);
		if($showalt) $r['alt'] = $r['title'];
		$products[] = $r;
	}
	$db->free_result($result);
	if($target) $target = ' target="_blank"';
	$width = ceil(100/$cols).'%';
	if(!$templateid) $templateid = 'tag_sales_thumb';
	include template('yp',$templateid);
}
?>