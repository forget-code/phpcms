<?php
defined('IN_PHPCMS') or exit('Access Denied');
$total_pv = 0;
$total_ip = 0;
$maxpv = 0;
$maxip = 0;
if (isset($hour) && intval($hour) >= 0)
{
	$res = $db -> query("SELECT COUNT(*),COUNT(DISTINCT vip),DATE_FORMAT(etime,'%Y-%m-%d %H:00') AS vhour FROM ".TABLE_STAT_VISITOR." WHERE DATE_FORMAT(etime,'%k')='$hour' GROUP BY vhour ORDER BY vhour DESC LIMIT 30");
	$resault = array();
	while ($row = $db -> fetch_row($res))
	{
		$resault[] = $row;
		if ($row[0] > $maxpv)
		{
			$maxpv = $row[0];
		}
		if ($row[1] > $maxip)
		{
			$maxip = $row[1];
		}
		$total_pv += $row[0];
		$total_ip += $row[1];
	}
}
else
{
	if ($dosubmit)
	{
		$date = $mydate;
	}
	elseif (!isset($date))
	{
		$date = date('Y-m-d');
	}
	$res = $db -> query("SELECT COUNT(*) AS numpv,COUNT(DISTINCT vip) AS numip,DATE_FORMAT(etime,'%H:00') AS vhour FROM ".TABLE_STAT_VISITOR." WHERE TO_DAYS(etime)=TO_DAYS('$date') GROUP BY vhour ORDER BY vhour");
	$row = $db -> fetch_array($res);
	$hourStat = array();
	if (strtotime($date) == strtotime(date('Ymd')))
	{
		$curHour = date('G');
	}
	else
	{
		$curHour = 23;
	}
	for ($i = 0; $i <= $curHour; $i++)
	{
		if (isset($row['vhour']) && intval($row['vhour']) == $i)
		{
			$hourStat[$i] = array($row['vhour'], $row['numpv'], $row['numip']);
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
				unset($row['vhour']);
			}
		}
		else
		{
			if ($i < 10)
			{
				$key = "0" . $i . ":00";
			}
			else
			{
				$key = $i . ":00";
			}
			$hourStat[$i] = array($key, 0, 0);
		}
	}
}
?>