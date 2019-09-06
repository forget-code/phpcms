<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$html = load('url.class.php');
if($dosubmit)
{
	if($type == 'lastinput')
	{
		$offset = 0;
	}
	else
	{
		$page = max(intval($page), 1);
		$offset = $pagesize*($page-1);
	}
	$where = ' WHERE status=99 ';
	$order = 'ASC';
	
	if(!isset($firest) && is_array($catids) && $catids[0] > 0) 
	{
		cache_write('url_show_'.$_userid.'.php', $catids);
		$catids = implodeids($catids);
		$where .= " AND catid IN($catids) ";
		$firest = 1;
	}
	elseif($firest)
	{
		$catids = cache_read('url_show_'.$_userid.'.php');
		$catids = implodeids($catids);
		$where .= " AND catid IN($catids) ";
	}
	else
	{
		$firest = 0;
	}

	if($type == 'lastinput' && $number)
	{
		$offset = 0;
		$pagesize = $number;
		$order = 'DESC';
	}
	elseif($type == 'date')
	{
		if($fromdate)
		{
			$fromtime = strtotime($fromdate.' 00:00:00');
			$where .= " AND `inputtime`>=$fromtime ";
		}
		if($todate)
		{
			$totime = strtotime($todate.' 23:59:59');
			$where .= " AND `inputtime`<=$totime ";
		}
	}
	elseif($type == 'id')
	{
		$fromid = intval($fromid);
		$toid = intval($toid);
		if($fromid) $where .= " AND `contentid`>=$fromid ";
		if($toid) $where .= " AND `contentid`<=$toid ";
	}
	if(!isset($total) && $type != 'lastinput')
	{
		$total = cache_count("SELECT COUNT(*) AS `count` FROM `".DB_PRE."content` $where");
		$pages = ceil($total/$pagesize);
		$start = 1;
	}
	$data = $db->select("SELECT `contentid`, `islink`, `url` FROM `".DB_PRE."content` $where ORDER BY `contentid` $order LIMIT $offset,$pagesize");
	foreach($data as $r)
	{
		if($r['islink']) continue;
		$info = $html->show($r['contentid']);
		$url = $info[1];
		$html->update($r['contentid'],$url);
		if(!is_a($c, 'content'))
		{
			require 'admin/content.class.php';
			$c = new content();	
		}
		$c->search_api($r['contentid']);
	}
	if($pages > $page)
	{
		$page++;
		$creatednum = $offset + count($data);
		$percent = round($creatednum/$total, 2)*100;
		$message = "共需更新 <font color='red'>$total</font> 条信息<br />已完成 <font color='red'>{$creatednum}</font> 条（<font color='red'>{$percent}%</font>）";
		$forward = $start ? "?mod=phpcms&file=url&type=$type&dosubmit=1&firest=$firest&action=$action&fromid=$fromid&toid=$toid&fromdate=$fromdate&todate=$todate&pagesize=$pagesize&page=$page&pages=$pages&total=$total" : preg_replace("/&page=([0-9]+)&pages=([0-9]+)&total=([0-9]+)/", "&page=$page&pages=$pages&total=$total", URL);;
	}
	else
	{
		cache_delete('url_show_'.$_userid.'.php');
		if($PHPCMS['ishtml'])
		{
			$message = "URL更新完成！开始更新内容页 ...";
			$forward = '?mod=phpcms&file=html&action=show';
		}
		else
		{
			$message = "URL更新完成！";
			$forward = '?mod=phpcms&file=url';
		}
	}
	showmessage($message, $forward);
}
else
{
	require_once 'admin/category.class.php';
	$cat = new category('phpcms');
	$cat->repair();
	include admin_tpl('url');
}
?>