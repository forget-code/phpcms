<?php
require './include/common.inc.php';

extract($departments[$departmentid]);

$pagesize = $PHPCMS['pagesize'];

if(!isset($page)) $page = 1;
$offset = ($page-1)*$pagesize;

$sql = '';
$sql .= isset($status) ? " and status='$status' " : '';
$dkeywords = isset($keywords) ? str_replace(" ","%",$keywords) : '';
$sql .= isset($keywords) ? " and (title like '%$dkeywords%' or content like '%$dkeywords%')" : "";

$r = $db->get_one("select count(*) as number from ".TABLE_ASK." where username='$_username' AND departmentid=$departmentid order by askid desc");
$pages = phppages($r['number'], $page, $pagesize);

$asks = array();

$result = $db->query("select * from ".TABLE_ASK." where username='$_username' AND departmentid=$departmentid $sql order by lastreply desc,askid desc limit $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	$r['addtime'] = date('Y-m-d h:i', $r['addtime']);
	$r['lastreply'] = date('Y-m-d h:i', $r['lastreply']);
	$r['stat'] = $STATUS[$r['status']];
	$asks[] = $r;
}

$head['title'] = $LANG['consultation'];

include template($mod, 'list');
?>