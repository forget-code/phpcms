<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	$head['title'] = '网站地图 - '.$PHPCMS['sitename'];
	$head['keywords'] = $PHPCMS['sitename'];
	ob_start();
	include template('phpcms', 'sitemap');
	$file = PHPCMS_ROOT.'sitemap.html';
	createhtml($file);
	showmessage('更新完成',$forward);
}
else
{
	include admin_tpl('sitemap');
}
?>