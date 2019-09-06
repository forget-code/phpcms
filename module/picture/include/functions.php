<?php
function attach_del($pictureurls)
{
	global $f;
	if(!$pictureurls) return false;
	$pictureurls = explode("\n",$pictureurls);
	if(!is_array($pictureurls)) return false;
	$pictureurls = array_map("trim",$pictureurls);
	foreach($pictureurls as $pictureurl)
	{
		$pictureurl = explode("|",$pictureurl);
		$filepath = $pictureurl[1];
		if(!preg_match("|://|",$filepath)) @$f->unlink($filepath);
	}
	return true;
}
?>