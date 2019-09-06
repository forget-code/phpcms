<?php
defined('IN_PHPCMS') or exit('Access Denied');

$pagesize = $PHPCMS['pagesize'];
if(!isset($page)) $page = 1;
$offset = ($page-1)*$pagesize;

$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_UNION_VISIT." WHERE userid=$_userid");
$pages = phppages($r['number'], $page, $pagesize);

$visits = array();
$result = $db->query("SELECT * FROM ".TABLE_UNION_VISIT." WHERE userid=$_userid ORDER BY visitid DESC LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	$r['visittime'] = date('Y-m-d H:i', $r['visittime']);
	$r['regtime'] = $r['regtime'] ? date('Y-m-d H:i', $r['regtime']) : '';
	$visits[] = $r;
}

$head['title'] = '访问记录';

include template($mod, 'visit');
?>