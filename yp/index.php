<?php
require './include/common.inc.php';
$strings = explode('/',$PHP_QUERYSTRING);
$enterprise = intval($strings[0]);
if(!$MOD['enableSecondDomain'] && $enterprise)
{
	$_userdir = substr($enterprise,0,2);
	$datafile = MOD_ROOT.'/web/userdata/'.$_userdir.'/'.$enterprise.'/index.php';
	file_exists($datafile) ? include $datafile : exit($LANG['site_no_exists']);
}
else
{
	$head['title'] = $MOD['seo_title'];
	$head['keywords'] = $MOD['seo_keywords'];
	$head['description'] = $MOD['seo_description'];

	$lastedittime = @filemtime('index_update.html');
	$lastedittime = $PHP_TIME-$lastedittime;
	$autoupdatetime = intval($MOD['autoupdate']);
	if(file_exists('index_update.html') && $lastedittime<$autoupdatetime)
	{	
		include 'index_update.html';
	}
	else
	{
		ob_start();
		include template($mod, 'index');
		$data .= ob_get_contents();
		ob_clean();
		file_put_contents('index_update.html', $data);
		@chmod('index_update.html', 0777);	
		echo $data;
	}
}
?>
