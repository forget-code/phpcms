<?php
defined('IN_PHPCMS') or exit('Access Denied');

$pagesize = $PHPCMS['pagesize'];
if(!isset($page)) $page = 1;
$offset = ($page-1)*$pagesize;

$sql = isset($userid) ? " WHERE userid=$userid " : '';

$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_UNION_PAY." $sql");
$pages = phppages($r['number'], $page, $pagesize);

$sql = isset($userid) ? " AND p.userid=$userid " : '';

$pays = array();
$result = $db->query("SELECT p.*,u.username FROM ".TABLE_UNION_PAY." p,".TABLE_UNION." u WHERE p.userid=u.userid $sql ORDER BY payid DESC LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	$r['adddate'] = $r['addtime'] ? date('Y-m-d', $r['addtime']) : '';
	$pays[] = $r;
}

include admintpl('pay');
?>