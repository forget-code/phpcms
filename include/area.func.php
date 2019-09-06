<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function province()
{
	global $db;
	$provinces = array();
	$result = $db->query("SELECT province FROM ".TABLE_PROVINCE." ORDER BY provinceid");
	while($r = $db->fetch_array($result))
	{
		$provinces[] = $r['province'];
	}
	$db->free_result($result);
	return $provinces;
}

function city($province)
{
	global $db;
	$citys = array();
	$result = $db->query("SELECT DISTINCT city FROM ".TABLE_CITY." WHERE province='$province' ORDER BY cityid");
	while($r = $db->fetch_array($result))
	{
		$citys[] = $r['city'];
	}
	$db->free_result($result);
	return $citys;
}

function area($province, $city)
{
	global $db;
	$areas = array();
	$result = $db->query("SELECT area FROM ".TABLE_CITY." WHERE city='$city' AND province='$province' ORDER BY cityid");
	while($r = $db->fetch_array($result))
	{
		$areas[] = $r['area'];
	}
	$db->free_result($result);
	return $areas;
}
?>