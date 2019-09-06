<?php
defined('IN_PHPCMS') or exit('Access Denied');

function get_bill($userid, $year, $month)
{
	global $db;
	$sql = '';
	if(isset($userid) && $userid)
	{
		$userid = intval($userid);
		$sql .= " AND userid=$userid ";
	}
	$year = intval($year);
	$month = intval($month);
    $bill['month'] = $month;
	if($month < 10) $month = '0'.$month;
	$prefix = $year.'-'.$month;
	$sql .= " AND adddate like '$prefix%'";
    $r = $db->get_one("SELECT sum(number) as points FROM ".TABLE_BILL." WHERE `type`='points' $sql");
    $bill['points'] = $r['points'];
    $r = $db->get_one("SELECT sum(number) as days FROM ".TABLE_BILL." WHERE `type`='days' $sql");
    $bill['days'] = $r['days'];
    $r = $db->get_one("SELECT sum(number) as money FROM ".TABLE_BILL." WHERE `type`='money' $sql");
    $bill['money'] = $r['money'];
	return $bill;
}


if(!isset($year)) $year = date('Y');
if(!isset($userid)) $userid = '';

for($month = 1; $month <= 12; $month++)
{
	$bills[$month] = get_bill($userid, $year, $month);
}

$points = 0;
$days = 0;
$money = 0;

include admintpl('stat');
?>