<?php
function announce_list($templateid, $keyid, $page, $announcenum, $width, $height, $subjectlen = 30, $datetype = 1, $showauthor = 1, $target = 1)
{
	global $db,$PHP_TIME,$MODULE;
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$page = isset($page) ? $page : 1;
	$offset = $page ? ($page - 1) * $announcenum : 0;
	$limit = $announcenum ? ' LIMIT '.$offset.','.$announcenum : '';
	$today = date('Y-m-d', $PHP_TIME);
	$sql = $pages = '';
	if($keyid) $sql = " AND keyid='$keyid'";
	$sql .= " AND (todate>='$today' OR todate='0000-00-00') ";
	if($page)
	{
	    $r = $db->get_one("SELECT COUNT(*) AS number FROM ".TABLE_ANNOUNCE." WHERE passed=1 $sql");
	    $pages = phppages($r['number'], $page, $announcenum);
	}
	$announces = array();
	$result = $db->query("SELECT * FROM ".TABLE_ANNOUNCE." WHERE passed=1 $sql ORDER BY announceid DESC $limit ");
	while($r = $db->fetch_array($result))
	{
		$announce['addtime'] = $datetype ? date($datetypes[$datetype], $r['addtime']) : '';
		$announce['announceid'] = $r['announceid'];
		$announce['username'] = $r['username'];
		$announce['linkurl'] = $MODULE['announce']['linkurl'].'index.php?keyid='.$keyid.'&announceid='.$r['announceid'];
		$announce['title'] = $subjectlen ? str_cut($r['title'], $subjectlen) : '';
		$announces[] = $announce;
	}
	if(!$templateid) $templateid = 'tag_announce_list';
	include template('announce', $templateid);
}
?>