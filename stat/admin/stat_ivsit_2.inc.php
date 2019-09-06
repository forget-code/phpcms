<?php
defined('IN_PHPCMS') or exit('Access Denied');
if (isset($pageurl))
{
	$res = $db -> query("SELECT COUNT(*) AS num,COUNT(DISTINCT DATE_FORMAT(ftime,'%Y-%m-%d')) AS rownum FROM ".TABLE_STAT_VPAGES." WHERE pageurl='$pageurl'");
	$row = $db -> fetch_array($res);
	$record = $row['rownum'];
	$pageSize = 20;
	$pageCount = ceil($record / $pageSize);
	if (isset($page) && intval($page) > 0)
	{
		$curPage = intval($page);
		if ($curPage > $pageCount)
		{
			$curPage = $pageCount;
		}
	}
	else
	{
		$curPage = 1;
	}
	$offset = ($curPage - 1) * $pageSize;
	$res = $db -> query("SELECT COUNT(*) AS numpv,DATE_FORMAT(ftime,'%Y-%m-%d') AS vdate FROM ".TABLE_STAT_VPAGES." WHERE pageurl='$pageurl' GROUP BY vdate ORDER BY vdate DESC LIMIT $offset,$pageSize");
	$total_pv = 0;
	$maxpv = 0;
	$resault = array();
	while ($row = $db -> fetch_row($res))
	{
		$resault[] = $row;
		if ($row[0] > $maxpv)
		{
			$maxpv = $row[0];
		}
		$total_pv += $row[0];
	}
}
else
{
	if (!isset($fdate) && !isset($ldate))
	{
		$fdate = date('Y-m-01');
		$ldate = date('Y-m-d');
	}
	$res = $db -> query("SELECT COUNT(*) AS num,COUNT(DISTINCT pageurl) AS rownum FROM ".TABLE_STAT_VPAGES." WHERE TO_DAYS(ftime) BETWEEN TO_DAYS('$fdate') AND TO_DAYS('$ldate')");
	$row = $db -> fetch_array($res);
	$record = $row['rownum'];
	if ($record > 0)
	{
		$pageSize = 20;
		$pageCount = ceil($record / $pageSize);
		if (isset($page) && intval($page) > 0)
		{
			$curPage = intval($page);
			if ($curPage > $pageCount)
			{
				$curPage = $pageCount;
			}
		}
		else
		{
			$curPage = 1;
		}
		$offset = ($curPage - 1) * $pageSize;
		$res = $db -> query("SELECT COUNT(*) AS numpv,pageurl FROM ".TABLE_STAT_VPAGES." WHERE TO_DAYS(ftime) BETWEEN TO_DAYS('$fdate') AND TO_DAYS('$ldate') GROUP BY pageurl ORDER BY numpv DESC LIMIT $offset,$pageSize");
		$total_pv = 0;
		$maxpv = 0;
		$resault = array();
		while ($row = $db -> fetch_row($res))
		{
			$resault[] = $row;
			if ($row[0] > $maxpv)
			{
				$maxpv = $row[0];
			}
			$total_pv += $row[0];
		}
	}
}
?>