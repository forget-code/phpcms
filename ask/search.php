<?php 
require './include/common.inc.php';
require_once MOD_ROOT.'include/ask.class.php';
$ask = new ask();
$where = '';
$status = $status ? intval($status) : 3;
if($status==5)
{
	$where .= ' status=5';
}
else if($flag==1)
{
	$where .= ' status=3 AND flag=1';
}
else
{
	$where .= ' status=3';
}
if($keywords)
{
	$where .= " AND title LIKE '%$keywords%'";
}
$infos = $ask->listinfo($where, 'askid DESC', $page, 20);
$pages = $ask->pages;

$head['title'] = $keywords.'_问吧搜索_'.$PHPCMS['sitename'];
$head['keywords'] = $keywords;
$head['description'] = $keywords;
include template('ask', 'search');
?>