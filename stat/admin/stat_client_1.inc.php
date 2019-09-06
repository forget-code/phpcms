<?php
defined('IN_PHPCMS') or exit('Access Denied');
if (isset($broswer))
{
	$res = $db -> query("SELECT COUNT(*) as num,COUNT(DISTINCT broswer) AS rownum FROM ".TABLE_STAT_VISITOR." WHERE broswer='$broswer'");
	$row = $db -> fetch_array($res);
	$total_pv = $row['num'];
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
	$res = $db -> query("SELECT COUNT(*) AS numpv,DATE_FORMAT(etime,'%Y-%m-%d') AS vdate FROM ".TABLE_STAT_VISITOR." WHERE broswer='$broswer' GROUP BY vdate ORDER BY vdate DESC LIMIT $offset,$pageSize");
	$maxpv = 0;
	$resault = array();
	while ($row = $db->fetch_row($res))
	{
		$resault[] = $row;
		if ($row[0] > $maxpv)
		{
			$maxpv = $row[0];
		}
	}
}
else
{
	if (!isset($fdate) && !isset($ldate))
	{
		$fdate = date('Y-m-01');
		$ldate = date('Y-m-d');
	}
	$res = $db -> query("SELECT COUNT(*) as numpv,broswer FROM ".TABLE_STAT_VISITOR." WHERE TO_DAYS(etime) BETWEEN TO_DAYS('$fdate') AND TO_DAYS('$ldate') GROUP BY broswer ORDER BY numpv DESC");
	$total_pv = 0;
	$maxpv = 0;
	$resault = array();
	while ($row = $db->fetch_row($res))
	{
		$resault[] = $row;
		if ($row[0] > $maxpv)
		{
			$maxpv = $row[0];
		}
		$total_pv += $row[0];
	}
}
?>