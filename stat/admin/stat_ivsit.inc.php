<?php
defined('IN_PHPCMS') or exit('Access Denied');
if (isset($type) && ($type == "today" || $type == "all") && isset($visits) && intval($visits) > 0)
{
	switch ($type)
	{
		case "today":
			$res = $db -> query("SELECT ".TABLE_STAT_VISITOR.".vid FROM ".TABLE_STAT_VISITOR.",".TABLE_STAT_AREA.",".TABLE_STAT_VPAGES." WHERE ".TABLE_STAT_AREA.".vip=".TABLE_STAT_VISITOR.".vip AND ".TABLE_STAT_VPAGES.".vid=".TABLE_STAT_VISITOR.".vid AND TO_DAYS(".TABLE_STAT_VISITOR.".etime)=TO_DAYS(CURDATE()) AND ".TABLE_STAT_VISITOR.".times='$visits' GROUP BY ".TABLE_STAT_VPAGES.".vid ORDER BY ".TABLE_STAT_VPAGES.".vid DESC,".TABLE_STAT_VPAGES.".pid");
			$record = $db -> num_rows($res);
			if ($record > 0)
			{
				$pageSize = 5;
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
				$res = $db -> query("SELECT ".TABLE_STAT_VISITOR.".vid,".TABLE_STAT_VISITOR.".vip,DATE_FORMAT(".TABLE_STAT_VISITOR.".etime,'%Y-%m-%d %H:%i:%s'),UNIX_TIMESTAMP(".TABLE_STAT_VISITOR.".ltime)-UNIX_TIMESTAMP(".TABLE_STAT_VISITOR.".etime),".TABLE_STAT_VISITOR.".beon,".TABLE_STAT_AREA.".address,".TABLE_STAT_VPAGES.".refurl,".TABLE_STAT_VPAGES.".rdomain,".TABLE_STAT_VPAGES.".keyword,".TABLE_STAT_VPAGES.".pageurl FROM ".TABLE_STAT_VISITOR.",".TABLE_STAT_AREA.",".TABLE_STAT_VPAGES." where ".TABLE_STAT_AREA.".vip=".TABLE_STAT_VISITOR.".vip AND ".TABLE_STAT_VPAGES.".vid=".TABLE_STAT_VISITOR.".vid AND ".TABLE_STAT_VISITOR.".times='$visits' AND TO_DAYS(".TABLE_STAT_VISITOR.".etime)=TO_DAYS(CURDATE()) GROUP BY ".TABLE_STAT_VPAGES.".vid ORDER BY ".TABLE_STAT_VPAGES.".vid DESC,".TABLE_STAT_VPAGES.".pid LIMIT $offset,$pageSize");
				$resault = array();
				$stay = array();
				while ($row = $db -> fetch_row($res))
				{
					$resault[] = $row;
					$second = $row[3] % 60;
					if ($second > 0)
					{
						$second .= $LANG['second'];
					}
					else
					{
						$second = '';
					}
					$minutes = intval($row[3] / 60);
					$minute = $minutes % 60;
					if ($minute > 0)
					{
						$minute .= $LANG['minute'];
					}
					else
					{
						$minute = '';
					}
					$hours = intval($minutes / 60);
					if ($hours > 0)
					{
						$hours .= $LANG['hour'];
					}
					else
					{
						$hours = '';
					}
					$stay[] = $hours . $minute . $second;
				}
			}
			break;
		case 'all':
			$res = $db -> query("SELECT COUNT(*) AS numpv,DATE_FORMAT(etime,'%Y-%m-%d') AS vdate FROM ".TABLE_STAT_VISITOR." WHERE times='{$visits}' GROUP BY vdate ORDER BY vdate DESC");
			$record = $total_pv = $db -> num_rows($res);
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
			$res = $db -> query("SELECT COUNT(*),DATE_FORMAT(etime,'%Y-%m-%d') AS vdate FROM ".TABLE_STAT_VISITOR." WHERE times='{$visits}' GROUP BY vdate ORDER BY vdate DESC LIMIT $offset,$pageSize");
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
else
{
	if (!isset($fdate) && !isset($ldate))
	{
		$fdate = date('Y-m-01');
		$ldate = date('Y-m-d');
	}
	$res = $db -> query("SELECT COUNT(*),times FROM ".TABLE_STAT_VISITOR." WHERE TO_DAYS(etime) BETWEEN TO_DAYS('$fdate') AND TO_DAYS('$ldate') GROUP BY times ORDER BY times DESC");
	if ($db->num_rows($res) > 0)
	{
		$total_pv = 0;
		$maxpv = 0;
		$newpv = 0;
		$resault = array();
		while ($row = $db -> fetch_row($res))
		{
			$resault[] = $row;
			if ($row[1] == 1)
			{
				$newpv = $row[0];
			}
			if ($row[0] > $maxpv)
			{
				$maxpv = $row[0];
			}
			$total_pv += $row[0];
		}
	}
}
?>