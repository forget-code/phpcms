<?php
function attach_del($downurls)
{
	global $f;
	if(!$downurls) return false;
	$downurls = explode("\n",$downurls);
	if(!is_array($downurls)) return false;
	$downurls = array_map("trim",$downurls);
	foreach($downurls as $downurl)
	{
		$downurl = explode("|",$downurl);
		$filepath = $downurl[1];
		if(!preg_match("/^(http|ftp):\/\//i",$filepath)) @$f->unlink($filepath);
	}
	return true;
}
?>