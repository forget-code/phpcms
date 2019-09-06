<?php
defined('IN_PHPCMS') or exit('Access Denied');
$res = $db->query("SELECT ".TABLE_STAT_VISITOR.".vid FROM ".TABLE_STAT_VISITOR.",".TABLE_STAT_AREA.",".TABLE_STAT_VPAGES." WHERE ".TABLE_STAT_AREA.".vip=".TABLE_STAT_VISITOR.".vip AND ".TABLE_STAT_VPAGES.".vid=".TABLE_STAT_VISITOR.".vid AND UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(".TABLE_STAT_VISITOR.".ltime)<=3600 GROUP BY ".TABLE_STAT_VPAGES.".vid");
$record = $db->num_rows($res);
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
	$res = $db->query("SELECT ".TABLE_STAT_VISITOR.".vid,".TABLE_STAT_VISITOR.".vip,DATE_FORMAT(".TABLE_STAT_VISITOR.".etime,'%Y-%m-%d %H:%i:%s'),UNIX_TIMESTAMP(".TABLE_STAT_VISITOR.".ltime)-UNIX_TIMESTAMP(".TABLE_STAT_VISITOR.".etime),	".TABLE_STAT_VISITOR.".beon,".TABLE_STAT_AREA.".address,".TABLE_STAT_VPAGES.".refurl,".TABLE_STAT_VPAGES.".rdomain,".TABLE_STAT_VPAGES.".keyword,".TABLE_STAT_VPAGES.".pageurl FROM ".TABLE_STAT_VISITOR.",".TABLE_STAT_AREA.",".TABLE_STAT_VPAGES." WHERE ".TABLE_STAT_AREA.".vip=".TABLE_STAT_VISITOR.".vip AND ".TABLE_STAT_VPAGES.".vid=".TABLE_STAT_VISITOR.".vid AND UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(".TABLE_STAT_VISITOR.".ltime)<=3600	GROUP BY ".TABLE_STAT_VPAGES.".vid ORDER BY ".TABLE_STAT_VPAGES.".vid DESC,".TABLE_STAT_VPAGES.".pid	LIMIT $offset,$pageSize");
	$stay = array();
	$resault = array();
	while ($row = $db->fetch_row($res))
	{
		$second = $row[3] % 60;
		if ($second > 0)
		{
			$second .= $LANG['second'];
		}
		else
		{
			$second = "";
		}
		$minutes = intval($row[3] / 60);
		$minute = $minutes % 60;
		if ($minute > 0)
		{
			$minute .= $LANG['minute'];
		}
		else
		{
			$minute = "";
		}
		$hours = intval($minutes / 60);
		if ($hours > 0)
		{
			$hours .= $LANG['hour'];
		}
		else
		{
			$hours = "";
		}
		$stay[] = $hours . $minute . $second;
		$resault[] = $row;
	}
}
?>