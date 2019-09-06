<?php
defined('IN_PHPCMS') or exit('Access Denied');

$pagesize = $PHPCMS['pagesize'];
if(!isset($page)) $page = 1;
$offset = ($page-1)*$pagesize;

$starttime = isset($starttime) ? intval($starttime) : 0;
$sql = $starttime ? " AND p.inputtime>$starttime" : '';

$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_MEMBER." m,".TABLE_PAY." p WHERE m.username=p.username AND m.introducer=$_userid AND p.typeid=2 $sql");
$pages = phppages($r['number'], $page, $pagesize);

$pays = array();
$result = $db->query("SELECT p.username,p.amount,p.inputtime,p.note FROM ".TABLE_MEMBER." m,".TABLE_PAY." p WHERE m.username=p.username AND m.introducer=$_userid AND p.typeid=2 $sql ORDER BY p.payid DESC LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	$r['inputtime'] = $r['inputtime'] ? date('Y-m-d H:i', $r['inputtime']) : '';
	$pays[] = $r;
}

$head['title'] = '推广联盟用户消费记录';

include template($mod, 'expend');
?>