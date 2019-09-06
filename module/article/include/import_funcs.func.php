<?php 
function get_catid($catid)
{
	global $setting;
	$catids = $setting['catids'];
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
	return $setting['defaultcatid'];
}
?>