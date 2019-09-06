<?php
function get_groupid($groupid)
{
	global $import_info;
	$groupids = $import_info['groupids'];
	foreach($groupids as $k=>$v)
	{
		if($v == $groupid) return $k;
		if(!$v) continue;
		if(!is_numeric($v))
		{
			$v = explode(',', $v);
			if(in_array($groupid, $v)) return $k;
		}
	}
	return $import_info['defaultgroupid'];
}

function get_catid($catid)
{
	global $import_info;
	$catids = $import_info['catids'];
	foreach($catids as $k=>$v)
	{
		if($v == $catid) return $k;
		if(!$v) continue;
		if(!is_numeric($v))
		{
			$v = explode(',', $v);
			if(in_array($catid, $v)) return $k;
		}
	}
	return $import_info['defaultcatid'];
}
?>