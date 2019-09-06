<?php
defined('IN_PHPCMS') or exit('Access Denied');
$engine = "'google.com','baidu.com','search.yahoo.com','search.cn.yahoo.com','search.live.com','search.msn.com.cn','cha.so.163.com','iask.com','sogou.com','soso.com','p.zhongsou.com','search.net2asp.com.cn','search.114.vnet.cn','search.china.com'";
if (isset($domain))
{
	$res = $db -> query("SELECT COUNT(*) AS num,COUNT(DISTINCT DATE_FORMAT(ftime,'%Y-%m-%d')) AS rownum FROM ".TABLE_STAT_VPAGES." WHERE rdomain IN ($engine)");
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
	$res = $db -> query("SELECT COUNT(*) AS numpv,DATE_FORMAT(ftime,'%Y-%m-%d') AS vdate FROM ".TABLE_STAT_VPAGES." WHERE rdomain IN ($engine) GROUP BY vdate ORDER BY vdate DESC LIMIT $offset,$pageSize");
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
	$res = $db -> query("SELECT COUNT(*) AS num FROM ".TABLE_STAT_VPAGES." WHERE rdomain IN ($engine) AND TO_DAYS(ftime) BETWEEN TO_DAYS('$fdate') AND TO_DAYS('$ldate')");
	$row = $db -> fetch_array($res);
	$record = $total_pv = $row['num'];
	if ($record > 0)
	{
		$res = $db -> query("SELECT COUNT(*) AS numpv,rdomain FROM ".TABLE_STAT_VPAGES." WHERE rdomain IN ($engine) AND TO_DAYS(ftime) BETWEEN TO_DAYS('$fdate') AND TO_DAYS('$ldate') GROUP BY rdomain ORDER BY numpv DESC");
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
}
?>