<?php
require dirname(__FILE__).'/include/common.inc.php';

$head['title'] = '最新更新_'.$PHPCMS['sitename'];
$head['keywords'] = $meta_keywords;
$head['description'] = $meta_description;

$number = 0;
$catname = '';
if($catid)
{
	$C = cache_read('category_'.$catid.'.php');
	extract($C);
}
$datas = array();
$updatetime = date('Y-m-d',TIME);
$updatetime = strtotime($updatetime);

$where = 'status=99 ';
$where .= $catid ? " AND catid='$catid'" : '';
$number = cache_count("SELECT count(*) AS `count` FROM `".DB_PRE."content` WHERE $where AND updatetime>'$updatetime'");

include 'admin/content.class.php';

$CA = new content();

$datas = $CA->listinfo($where,'`updatetime` DESC', 1, 50);

$ttl = CACHE_PAGE_CATEGORY_TTL;
header('Last-Modified: '.gmdate('D, d M Y H:i:s', TIME).' GMT');
header('Expires: '.gmdate('D, d M Y H:i:s', TIME + $ttl).' GMT');
header('Cache-Control: max-age='.$ttl.', must-revalidate');

include template('phpcms', 'renew');
cache_page($ttl);
?>