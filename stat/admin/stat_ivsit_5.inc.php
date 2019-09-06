<?php
defined('IN_PHPCMS') or exit('Access Denied');
if (isset($province))
{
	$res = $db -> query("SELECT COUNT(*) AS num,COUNT(DISTINCT DATE_FORMAT(".TABLE_STAT_VISITOR.".etime,'%Y-%m-%d')) AS rownum FROM ".TABLE_STAT_VISITOR.",".TABLE_STAT_AREA." WHERE ".TABLE_STAT_VISITOR.".vip=".TABLE_STAT_AREA.".vip AND ".TABLE_STAT_AREA.".province='$province'");
	$row = $db -> fetch_array($res);
	$record = $row['rownum'];
	$total_pv = $row['num'];
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
	$res = $db -> query("SELECT COUNT(*) AS numpv,DATE_FORMAT(".TABLE_STAT_VISITOR.".etime,'%Y-%m-%d') AS vdate FROM ".TABLE_STAT_VISITOR.",".TABLE_STAT_AREA." WHERE ".TABLE_STAT_VISITOR.".vip=".TABLE_STAT_AREA.".vip AND ".TABLE_STAT_AREA.".province='$province' GROUP BY vdate ORDER BY vdate DESC LIMIT $offset,$pageSize");
	$maxpv = 0;
	$resault = array();
	while ($row = $db -> fetch_row($res))
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
	$res = $db -> query("SELECT COUNT(".TABLE_STAT_VISITOR.".vid) AS num,COUNT(DISTINCT ".TABLE_STAT_AREA.".province) AS rownum FROM ".TABLE_STAT_VISITOR.",".TABLE_STAT_AREA." WHERE ".TABLE_STAT_VISITOR.".vip=".TABLE_STAT_AREA.".vip AND TO_DAYS(".TABLE_STAT_VISITOR.".etime) BETWEEN TO_DAYS('$fdate') AND TO_DAYS('$ldate')");
	$row = $db -> fetch_array($res);
	$record = $row['rownum'];
	if ($record > 0)
	{
		$total_pv = $row['num'];
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
		$res = $db -> query("SELECT COUNT(*) AS numpv,".TABLE_STAT_AREA.".province AS province FROM ".TABLE_STAT_VISITOR.",".TABLE_STAT_AREA." WHERE ".TABLE_STAT_VISITOR.".vip=".TABLE_STAT_AREA.".vip AND TO_DAYS(".TABLE_STAT_VISITOR.".etime) BETWEEN TO_DAYS('$fdate') AND TO_DAYS('$ldate') GROUP BY province ORDER BY numpv DESC LIMIT $offset,$pageSize");
		$maxpv = 0;
		$resault = array();
		while ($row = $db -> fetch_row($res))
		{
			$resault[] = $row;
			if ($row[0] > $maxpv)
			{
				$maxpv = $row[0];
			}
		}
	}
}
?>