<?php
defined('IN_PHPCMS') or exit('Access Denied');

$sql = '';
if(isset($userid) && $userid)
{
	$userid = intval($userid);
	$sql .= " AND userid=$userid ";
}
if(isset($ip) && $ip) $sql .= " AND ip='$ip' ";
if(isset($refurl) && $refurl) $sql .= " AND refurl like '%$refurl%' ";
if(isset($begindate) && $begindate)
{
	$sql .= " AND adddate>='$begindate' ";
}
if(isset($enddate) && $enddate)
{
	$sql .= " AND adddate<='$enddate' ";
}
if($sql) $sql = " WHERE 1 $sql";

$page = $page ? intval($page) : 1;
$pagesize = $PHPCMS['pagesize'];
$offset = ($page-1)*$pagesize;
$r = $db->get_one("SELECT count(*) as num FROM ".TABLE_BILL." $sql");
$pages = phppages($r['num'], $page, $pagesize);

$bills = array(); 
$result = $db->query("SELECT * FROM ".TABLE_BILL." $sql LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	$r['addtime'] = date('Y-m-d h:i:s', $r['addtime']);
	$bills[] = $r;
}

if(!isset($userid)) $userid = '';
if(!isset($refurl)) $refurl = '';
if(!isset($ip)) $ip = '';
if(!isset($begindate)) $begindate = date('Y-m').'-01';
if(!isset($enddate)) $enddate = date('Y-m-d');

include admintpl('list');
?>