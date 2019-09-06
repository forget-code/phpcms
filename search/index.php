<?php 
require './include/common.inc.php';

$types = $search->get_type();
if(isset($q)) $q = $search->strip($q);

if($q)
{
	$order = isset($order) ? intval($order) : 0;
	$page = max(intval($page), 1);
	$search->set($M['titlelen'], $M['descriptionlen'], 'red');
	$search->set_type($type);
	$q = new_htmlspecialchars(strip_tags($q));
	$data = $search->q($q, $order, $page, $PHPCMS['search_pagesize']);
	$pages = $search->pages;
	$total = $search->total;
	$usedtime = usedtime();
	$template = 'list';
	$head['title'] = $q.'-'.$PHPCMS['sitename'];
	$head['keywords'] = $q.','.$PHPCMS['keywords'];
	$head['description'] = $q.','.$PHPCMS['description'];
}
else
{
	$template = 'index';
	$head['title'] = '搜索首页-'.$PHPCMS['sitename'];
	$head['keywords'] = $PHPCMS['keywords'];
	$head['description'] = $PHPCMS['description'];
}
include template($mod, $template);
?>