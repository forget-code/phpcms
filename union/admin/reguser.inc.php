<?php
defined('IN_PHPCMS') or exit('Access Denied');

$pagesize = $PHPCMS['pagesize'];
if(!isset($page)) $page = 1;
$offset = ($page-1)*$pagesize;

$sql = isset($userid) ? " WHERE introducer=$userid " : ' WHERE introducer>0 ';

$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_MEMBER." $sql");
$pages = phppages($r['number'], $page, $pagesize);

$sql = isset($userid) ? " AND m.introducer=$userid " : ' AND m.introducer>0 ';

$users = array();
$result = $db->query("SELECT * FROM ".TABLE_MEMBER." m,".TABLE_MEMBER_INFO." i WHERE m.userid=i.userid $sql ORDER BY m.userid DESC LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	$r['regtime'] = $r['regtime'] ? date('Y-m-d H:i', $r['regtime']) : '';
	$r['lastlogintime'] = $r['lastlogintime'] ? date('Y-m-d H:i', $r['lastlogintime']) : '';
	$users[] = $r;
}

include admintpl('reguser');
?>