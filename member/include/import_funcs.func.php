<?php 
function get_groupid($groupid)
{
	global $setting;
	$groupids = $setting['groupids'];
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
	return $setting['defaultgroupid'];
}
?>