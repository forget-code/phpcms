<?php
defined('IN_PHPCMS') or exit('Access Denied');
parse_str($PHP_QUERYSTRING);
if (isset($delall)) {
	$db -> query("TRUNCATE ".TABLE_STAT_HISTORY);
} elseif (isset($delone)) {
	$db -> query("DELETE FROM ".TABLE_STAT_HISTORY." WHERE url='$history'");
	$db -> query("OPTIMIZE TABLE ".TABLE_STAT_HISTORY);
}
if (isset($save)) {
	$url = str_replace('&save=1', '', $_SERVER['REQUEST_URI']);
	$db->query("INSERT INTO ".TABLE_STAT_HISTORY." (content,url) VALUES ('$search','$url')");
}
if (!isset($fdate)) {
	$fdate = date('Y-m-d');
}
if (!isset($ldate)) {
	$ldate = date('Y-m-d');
}
$res = $db->query("SELECT content,url FROM ".TABLE_STAT_HISTORY);
if ($db->num_rows($res) > 0) {
	$resault = array();
	$uri = str_replace("&save=1", '', $_SERVER['REQUEST_URI']);
	while ($row = $db->fetch_row($res)) {
		$resault[] = $row;
	}
}
if (isset($search) && isset($stype)) {
	$search = $stype == 'filen' ? substr($search, 0, strpos($search, '.')) : $search;
	$res = $db->query("SELECT ".TABLE_STAT_VISITOR.".vid FROM ".TABLE_STAT_VISITOR.",".TABLE_STAT_AREA.",".TABLE_STAT_VPAGES." WHERE ".TABLE_STAT_AREA.".vip=".TABLE_STAT_VISITOR.".vip AND ".TABLE_STAT_VPAGES.".vid=".TABLE_STAT_VISITOR.".vid AND ".TABLE_STAT_VPAGES.".$stype='$search' AND TO_DAYS(".TABLE_STAT_VPAGES.".ftime) BETWEEN TO_DAYS('$fdate') AND TO_DAYS('$ldate') GROUP BY ".TABLE_STAT_VPAGES.".vid ORDER BY ".TABLE_STAT_VPAGES.".vid DESC,".TABLE_STAT_VPAGES.".pid");
	$record = $db->num_rows($res);
	if ($record > 0) {
		$pageSize = 5;
		$pageCount = ceil($record / $pageSize);
		if (isset($page) && intval($page) > 0) {
			$curPage = intval($page);
			if ($curPage > $pageCount) {
				$curPage = $pageCount;
			}
		} else {
			$curPage = 1;
		}
		$offset = ($curPage - 1) * $pageSize;
		$res = $db -> query("SELECT ".TABLE_STAT_VISITOR.".vid AS id,".TABLE_STAT_VISITOR.".vip AS ip,DATE_FORMAT(".TABLE_STAT_VISITOR.".etime,'%Y-%m-%d %H:%i:%s') AS etime,UNIX_TIMESTAMP(".TABLE_STAT_VISITOR.".ltime)-UNIX_TIMESTAMP(".TABLE_STAT_VISITOR.".etime) AS stay,".TABLE_STAT_VISITOR.".beon AS beon,".TABLE_STAT_AREA.".address AS address,".TABLE_STAT_VPAGES.".refurl AS refurl,".TABLE_STAT_VPAGES.".rdomain AS rdomain,".TABLE_STAT_VPAGES.".keyword AS keyword,".TABLE_STAT_VPAGES.".pageurl AS pageurl FROM ".TABLE_STAT_VISITOR.",".TABLE_STAT_AREA.",".TABLE_STAT_VPAGES." WHERE ".TABLE_STAT_AREA.".vip=".TABLE_STAT_VISITOR.".vip AND ".TABLE_STAT_VPAGES.".vid=".TABLE_STAT_VISITOR.".vid AND ".TABLE_STAT_VPAGES.".$stype='$filename' AND TO_DAYS(".TABLE_STAT_VPAGES.".ftime) BETWEEN TO_DAYS('$fdate') AND TO_DAYS('$ldate') GROUP BY ".TABLE_STAT_VPAGES.".vid ORDER BY ".TABLE_STAT_VPAGES.".vid DESC,".TABLE_STAT_VPAGES.".pid	LIMIT $offset,$pageSize");
		$stay = array();
		$query = array();
		while ($row = $db->fetch_row($res)) {
			$second = $row[3] % 60;
			if ($second > 0) {
				$second .= $LANG['second'];
			} else {
				$second = '';
			}
			$minutes = intval($row[3] / 60);
			$minute = $minutes % 60;
			if ($minute > 0) {
				$minute .= $LANG['minute'];
			} else {
				$minute = '';
			}
			$hours = intval($minutes / 60);
			if ($hours > 0) {
				$hours .= $LANG['hour'];
			} else {
				$hours = '';
			}
			$stay[] = $hours . $minute . $second;
			$query[] = $row;
		}
	}
}
?>