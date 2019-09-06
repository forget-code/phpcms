<?php
defined('IN_PHPCMS') or exit('Access Denied');

$pagesize = $PHPCMS['pagesize'];
if(!isset($page)) $page = 1;
$offset = ($page-1)*$pagesize;

$sql = isset($userid) ? " WHERE userid=$userid " : '';

$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_UNION_VISIT." $sql");
$pages = phppages($r['number'], $page, $pagesize);

$visits = array();
$result = $db->query("SELECT * FROM ".TABLE_UNION_VISIT." $sql ORDER BY visitid DESC LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	$r['visittime'] = date('Y-m-d H:i', $r['visittime']);
	$r['regtime'] = $r['regtime'] ? date('Y-m-d H:i', $r['regtime']) : '';
	$visits[] = $r;
}

include admintpl('visit');
?>