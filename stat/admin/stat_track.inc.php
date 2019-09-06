<?php
defined('IN_PHPCMS') or exit('Access Denied');
if (isset($ip))
{
	$res = $db->query("SELECT ".TABLE_STAT_VISITOR.".vid FROM ".TABLE_STAT_VISITOR.",".TABLE_STAT_AREA.",".TABLE_STAT_VPAGES." WHERE ".TABLE_STAT_AREA.".vip=".TABLE_STAT_VISITOR.".vip AND ".TABLE_STAT_VISITOR.".vip='$ip'	AND ".TABLE_STAT_VPAGES.".vid=".TABLE_STAT_VISITOR.".vid GROUP BY ".TABLE_STAT_VPAGES.".vid	ORDER BY ".TABLE_STAT_VPAGES.".vid DESC,".TABLE_STAT_VPAGES.".pid");
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
		$res = $db->query("SELECT ".TABLE_STAT_VISITOR.".vid AS id,DATE_FORMAT(".TABLE_STAT_VISITOR.".etime,'%Y-%m-%d %H:%i:%s') AS etime,DATE_FORMAT(".TABLE_STAT_VISITOR.".ltime,'%Y-%m-%d %H:%i:%s') AS ltime,UNIX_TIMESTAMP(".TABLE_STAT_VISITOR.".ltime)-UNIX_TIMESTAMP(".TABLE_STAT_VISITOR.".etime) AS stay,".TABLE_STAT_VISITOR.".beon AS beon,".TABLE_STAT_AREA.".address AS address,".TABLE_STAT_VPAGES.".refurl AS refurl,".TABLE_STAT_VPAGES.".rdomain AS rdomain,".TABLE_STAT_VPAGES.".keyword AS keyword,".TABLE_STAT_VPAGES.".pageurl AS pageurl FROM ".TABLE_STAT_VISITOR.",".TABLE_STAT_AREA.",".TABLE_STAT_VPAGES." WHERE ".TABLE_STAT_AREA.".vip=".TABLE_STAT_VISITOR.".vip AND ".TABLE_STAT_AREA.".vip='$ip' AND ".TABLE_STAT_VPAGES.".vid=".TABLE_STAT_VISITOR.".vid GROUP BY ".TABLE_STAT_VPAGES.".vid	ORDER BY ".TABLE_STAT_VPAGES.".vid DESC,	".TABLE_STAT_VPAGES.".pid LIMIT $offset,$pageSize");
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
} elseif (isset($id) && intval($id) > 0)
{
	$res = $db->query("SELECT ".TABLE_STAT_VISITOR.".vip AS ip,".TABLE_STAT_VISITOR.".times AS times,".TABLE_STAT_VISITOR.".osys AS osys,".TABLE_STAT_VISITOR.".lang AS lang,".TABLE_STAT_VISITOR.".broswer AS broswer,".TABLE_STAT_VISITOR.".screen AS screen,".TABLE_STAT_VISITOR.".color AS color,".TABLE_STAT_VISITOR.".alexa AS alexa,".TABLE_STAT_VISITOR.".times AS times,DATE_FORMAT(".TABLE_STAT_VISITOR.".etime,'%Y-%m-%d %H:%i:%s') AS etime,DATE_FORMAT(".TABLE_STAT_VISITOR.".ltime,'%Y-%m-%d %H:%i:%s') AS ltime,(UNIX_TIMESTAMP(".TABLE_STAT_VISITOR.".ltime)-UNIX_TIMESTAMP(".TABLE_STAT_VISITOR.".etime)) AS stay,".TABLE_STAT_VISITOR.".beon AS beon,".TABLE_STAT_AREA.".address AS address,".TABLE_STAT_VPAGES.".refurl AS refurl,".TABLE_STAT_VPAGES.".rdomain AS rdomain,".TABLE_STAT_VPAGES.".keyword AS keyword,".TABLE_STAT_VPAGES.".pageurl AS pageurl,COUNT(DISTINCT ".TABLE_STAT_VPAGES.".pid) AS pages FROM ".TABLE_STAT_VISITOR.",".TABLE_STAT_AREA.",".TABLE_STAT_VPAGES." WHERE ".TABLE_STAT_VISITOR.".vid='$id' AND ".TABLE_STAT_AREA.".vip=".TABLE_STAT_VISITOR.".vip	AND ".TABLE_STAT_VPAGES.".vid=".TABLE_STAT_VISITOR.".vid GROUP BY ".TABLE_STAT_VPAGES.".pid ORDER BY ".TABLE_STAT_VPAGES.".pid");
	$row = $db->fetch_array($res);
}
?>