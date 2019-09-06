<?php 
require './include/common.inc.php';

$head['keywords'] = $M['name'];
$head['description'] = $head['title'] = $M['name'].'_'.$PHPCMS['sitename'];
$week_time = TIME-86400*7;
$month_time = TIME-86400*30;
$day_time = TIME-86400;
$subcats = subcat('video', 0, 0);
$menu_selectid = $M['menu_selectid'];

header('Last-Modified: '.gmdate('D, d M Y H:i:s', TIME).' GMT');
header('Expires: '.gmdate('D, d M Y H:i:s', TIME+CACHE_PAGE_INDEX_TTL).' GMT');
header('Cache-Control: max-age='.CACHE_PAGE_INDEX_TTL.', must-revalidate');

include template('video', 'index');
cache_page(CACHE_PAGE_INDEX_TTL);
?>