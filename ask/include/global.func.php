<?php
//功能：倒计时计算
function count_down($unix_timestamp)
{ 
	$date = $unix_timestamp-time(); 
	$day = $date/86400; 
	$days = intval($day); 
	$hour = $date/3600 - $days*24; 
	$hours = intval($hour); 
	$minute = $date/60 - $days*1440 - $hours*60; 
	$minutes = intval($minute); 
	$second = $date - $days*86400 - $hours*3600 - $minutes*60; 
	$seconds = intval($second); 
	$result = array($days,$hours,$minutes,$seconds); 
	return $result; 
}
function solve_ask_count($status = 0)
{
	global $db;
	$status = intval($status);
	if($status)
	{
		$status = 5;
	}
	else
	{
		$status = 3;
	}
	$r = $db->get_one("SELECT count(askid) AS num FROM ".DB_PRE."ask WHERE status=$status");
	return $r['num'];
}
function caturl($action)
{
	global $URLRULE,$catid,$page;
	$M = cache_read('module_ask.php');
	$urlrule = $URLRULE[$M['categoryUrlRuleid']];
	if(strpos($urlrule, '|'))
	{
		$urlrules = explode('|', $urlrule);
        $urlrule = $page < 2 ? $urlrules[0] : $urlrules[1];
	}
	eval("\$url = \"$urlrule\";");
	return $url;
}
?>