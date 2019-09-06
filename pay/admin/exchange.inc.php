<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$units = array('point'=>$LANG['point_unit'], 'money'=>$LANG['money_unit'], 'credit'=>$LANG['credit_unit'], 'timey'=>$LANG['year'], 'timem'=>$LANG['month'], 'timed'=>$LANG['day']);
$types = array('money'=>$LANG['money'], 'point'=>$LANG['point'], 'credit'=>$LANG['credit'], 'time'=>$LANG['time']);

$page = isset($page) ? intval($page) : 1;
$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 30;
$offset = ($page-1)*$pagesize;

$sql = '';
if($username) $sql .= " AND username='$username' ";
if($type) $sql .= " AND type='$type' ";
if($begindate)
{
	$begintime = strtotime($begindate.' 00:00:00');
	$sql .= " AND addtime>=$begintime ";
}
if($enddate)
{
	$endtime = strtotime($enddate.' 23:59:59');
	$sql .= " AND addtime<=$endtime";
}
if($sql) $sql = " WHERE 1 $sql";

$r = $db->get_one("SELECT count(*) as number FROM ".TABLE_PAY_EXCHANGE." $sql");
$pages = phppages($r['number'], $page, $pagesize);

$exchanges = array();
$result = $db->query("SELECT * FROM ".TABLE_PAY_EXCHANGE." $sql ORDER BY exchangeid DESC LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	$r['addtime'] = date('Y-m-d h:i:s', $r['addtime']);
	$exchanges[] = $r;
}
include admintpl('exchange');
?>