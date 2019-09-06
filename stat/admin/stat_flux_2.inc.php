<?php
defined('IN_PHPCMS') or exit('Access Denied');
$res = $db -> query("SELECT MIN(YEAR(etime)) FROM ".TABLE_STAT_VISITOR);
$row = $db->fetch_row($res);
$startYear = empty($row[0]) ? date('Y') : $row[0];
if (!$dosubmit)
{
	$year = date('Y');
}
$res = $db -> query("SELECT COUNT(*) AS numpv,COUNT(DISTINCT vip) AS numip,tweek FROM ".TABLE_STAT_VISITOR." WHERE YEAR(etime)='$year' GROUP BY tweek ORDER BY tweek");
$row = $db -> fetch_array($res);
$weekStat = array();
if ($year == date('Y'))
{
	$curWeek = intval(date('W'));
}
else
{
	$curWeek = 52;
}
$total_pv = 0;
$total_ip = 0;
$maxpv = 0;
$maxip = 0;
for ($i = 1; $i <= $curWeek; $i++)
{
	$fweek = date('w', mktime(0, 0, 0, 1, 1, $year));
	$fdate = date('m-d', mktime(0, 0, 0, 1, $i * 7 - $fweek - 6, $year));
	$ldate = date('m-d', mktime(0, 0, 0, 1, $i * 7 - $fweek, $year));
	$key = $fdate . "--" . $ldate;
	if (isset($row['tweek']) && intval($row['tweek']) == $i)
	{
		$weekStat[] = array($key, $row['numpv'], $row['numip']);
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
			unset($row['tweek']);
		}
	}
	else
	{
		$weekStat[] = array($key, 0, 0);
	}
}
?>