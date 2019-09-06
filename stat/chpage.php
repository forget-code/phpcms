<?php
include './include/common.inc.php';
if(!$vid) exit;
$row = $db->get_one("SELECT pid FROM ".TABLE_STAT_VPAGES." WHERE vid=$vid AND refurl='$refurl' AND pageurl='$pageurl' AND UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(ltime)<$interval ORDER BY pid DESC");
if($row)
{
	$db->query("UPDATE ".TABLE_STAT_VPAGES." SET ftime=null WHERE pid=$row[pid]");
	$pid = $row['pid'];
}
else
{
	if($refurl)
	{
		$temp = parse_url($refurl);
		if(strtolower(substr($temp['host'], 0, 4)) == 'www.')
		{
			$rdomain = substr($temp['host'], 4);
		}
		else
		{
			$rdomain = $temp['host'];
		}
		include("./include/keyword.func.php");
		$keyword = keyWord($refurl);
	}
	else
	{
		$refurl = $LANG['location_column_input'];
		$rdomain = "&nbsp;";
		$keyword = "&nbsp;";
	}
	$db->query("INSERT INTO ".TABLE_STAT_VPAGES." (vid,refurl,rdomain,keyword,pageurl,filen,ftime) VALUES('$vid','$refurl','$rdomain','$keyword','$pageurl','$filename',NOW())");
	$pid = $db->insert_id();
}
mkcookie('vid', $vid, $PHP_TIME + $interval);
mkcookie('pid', $pid, $PHP_TIME + $interval);
?>