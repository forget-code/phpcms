<?php
defined('IN_PHPCMS') or exit('Access Denied');
$res = $db -> query("SELECT MIN(YEAR(etime)) FROM ".TABLE_STAT_VISITOR);
$row = $db->fetch_row($res);
$startYear = empty($row[0]) ? date('Y') : $row[0];
if ($dosubmit)
{
	$date = $year . $month;
}
elseif (isset($date))
{
	$year = substr($date, 0, 4);
	$month = substr($date, 4);
}
else
{
	$year = date('Y');
	$month = date('m');
	$date = $year . $month;
}
$res = $db -> query("SELECT COUNT(*) AS numpv,COUNT(DISTINCT vip) AS numip,DATE_FORMAT(etime,'%d') AS vday FROM ".TABLE_STAT_VISITOR." WHERE DATE_FORMAT(etime,'%Y%m')='$date' GROUP BY vday ORDER BY vday");
$row = $db -> fetch_array($res);
$dayStat = array();
if ($date == date('Ym'))
{
	$curDay = date('d');
}
else
{
	$curDay = date('t', mktime(0, 0, 0, $month, 1, $year));
}
$total_pv = 0;
$total_ip = 0;
$maxpv = 0;
$maxip = 0;
for ($i = 1; $i <= $curDay; $i++)
{
	if (isset($row['vday']) && intval($row['vday']) == $i)
	{
		$day = $row['vday'] . $LANG['day_th'];
		$dayStat[] = array($day, $row['numpv'], $row['numip']);
		if ($row['numpv'] > $maxpv)
		{
			$maxpv = $row['numpv'];
		}
		if ($row['numip'] > $maxip)
		{
			$maxip = $row['numip'];
		}
		$total_pv += $row['numpv'];
		$total_ip += $row['numip'];
		if (!$row = $db -> fetch_array($res))
		{
			unset($row['vday']);
		}
	}
	else
	{
		if ($i < 10)
		{
			$key = "0" . $i . $LANG['day_th'];
		}
		else
		{
			$key = $i . $LANG['day_th'];
		}
		$dayStat[] = array($key, 0, 0);
	}
}
$curUri = "?mod=$mod&file=$file&action=flux";
include(MOD_ROOT."/include/zhweek.func.php");
?>