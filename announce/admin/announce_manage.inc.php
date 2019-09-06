<?php
defined('IN_PHPCMS') or exit('Access Denied');
if ($dosubmit)
{
	$item = '';
	foreach ($announceid as $value)
	{
		$item .= "$value,";
	}
	$item = substr($item, 0, -1);
	if (isset($remove))
	{
		$db->query("DELETE FROM ".TABLE_ANNOUNCE." WHERE announceid IN ($item)");
	}
	else
	{
		$value = abs($passed - 1);
		$db->query("UPDATE ".TABLE_ANNOUNCE." set passed='$value' WHERE announceid IN ($item)");
	}
	showmessage($LANG['operation_success'], $PHP_REFERER);
}
$today = date('Y-m-d', time());
$sql = "SELECT COUNT(*) FROM ".TABLE_ANNOUNCE." WHERE keyid='$keyid'";
$sql .= isset($passed) ? " AND passed='$passed'" : null;
$sql .= isset($timeout) ? " AND todate<'$today' AND todate>0" : null;
$res = $db->query($sql);
$row = $db->fetch_row($res);
$total = $row[0];
if ($total)
{
	$pagesize = 20;
	$page = isset($page) ? $page : 1;
	$offset = ($page - 1) * $pagesize;
	$sql = str_replace('COUNT(*)', 'announceid,title,hits,fromdate,todate,username,addtime', $sql) . " ORDER BY announceid DESC LIMIT $offset,$pagesize";
	$res = $db->query($sql);
	$resailt = array();
	while ($row = $db->fetch_row($res))
	{
		$row[6] = date('Y-m-d H:i:s', $row[6]);
		$row[4] = $row[4] == '0000-00-00' ? $LANG['unrestricted'] : $row[4];
		$resailt[] = $row;
	}
	$referer = "$curUri&page=$page";
}
?>