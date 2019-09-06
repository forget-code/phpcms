<?php
include './include/common.inc.php';
if($vid && $pid)
{
	$db->query("UPDATE ".TABLE_STAT_VISITOR." SET ltime=null,beon=1 WHERE vid=$vid");
	$db->query("UPDATE ".TABLE_STAT_VPAGES." SET ltime=null WHERE vid=$vid AND pid=$pid");
	mkcookie('vid', $vid, $PHP_TIME + $interval);
	mkcookie('pid', $pid, $PHP_TIME + $interval);
}
$row = $db->get_one("SELECT COUNT(*) AS num FROM ".TABLE_STAT_VISITOR." WHERE UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(ltime)<=$interval");
echo $row['num'] ? $row['num'] : 1;
?>