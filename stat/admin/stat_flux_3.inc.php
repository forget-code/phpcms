<?php
defined('IN_PHPCMS') or exit('Access Denied');
$res = $db -> query("SELECT MIN(YEAR(etime)) FROM ".TABLE_STAT_VISITOR);
$row = $db->fetch_row($res);
$startYear = empty($row[0]) ? date('Y') : $row[0];
if (!$dosubmit)
{
	$year = $date = date('Y');
}
$res = $db -> query("SELECT COUNT(*) AS numpv,COUNT(DISTINCT vip) AS numip,DATE_FORMAT(etime,'%m') AS vmonth FROM ".TABLE_STAT_VISITOR." WHERE YEAR(etime)='$date' GROUP BY vmonth ORDER BY vmonth");
$row = $db -> fetch_array($res);
$monthStat = array();
if ($date == date('Y'))
{
	$curMonth = date('m');
}
else
{
	$curMonth = 12;
}
$total_pv = 0;
$total_ip = 0;
$maxpv = 0;
$maxip = 0;
for ($i = 1; $i <= $curMonth; $i++)
{
	if (isset($row['vmonth']) && intval($row['vmonth']) == $i)
	{
		$month = $row['vmonth'];
		$monthStat[] = array($month, $row['numpv'], $row['numip']);
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
			unset($row['vmonth']);
		}
	}
	else
	{
		if ($i < 10)
		{
			$key = "0" . $i;
		}
		else
		{
			$key = $i;
		}
		$monthStat[] = array($key, 0, 0);
	}
}
$curUri = "?mod=$mod&file=$file&action=flux_1";
?>