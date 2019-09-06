<?php
function page_list($templateid = '', $keyid = 'phpcms', $num = 0)
{
	$pages = cache_read('definedpage_'.$keyid.'.php');
	if($num)
	{
		$tmp_pages = array();
		for($i = 0; $i < $num; $i++)
		{
			$tmp_pages[$i] = $pages[$i];
		}
		unset($pages);
		$pages = $tmp_pages;
	}
	$templateid = $templateid ? $templateid : 'tag_page_list';
	include template('page', $templateid);
}
?>