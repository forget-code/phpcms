<?php
defined('IN_PHPCMS') or exit('Access Denied');

$pagesize = $PHPCMS['pagesize'];
if(!isset($page)) $page = 1;
$offset = ($page-1)*$pagesize;

$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_UNION_PAY." WHERE userid=$_userid");
$pages = phppages($r['number'], $page, $pagesize);

$pays = array();
$result = $db->query("SELECT * FROM ".TABLE_UNION_PAY." WHERE userid=$_userid ORDER BY payid DESC LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	$r['addtime'] = $r['addtime'] ? date('Y-m-d H:i', $r['addtime']) : '';
	$pays[] = $r;
}

$head['title'] = '推广联盟结算记录';

include template($mod, 'pay');
?>