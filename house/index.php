<?php
require './include/common.inc.php';
if($MOD['ishtml'] && file_exists($PHPCMS['index'].'.'.$PHPCMS['fileext']))
{
	header('location:'.$PHPCMS['index'].'.'.$PHPCMS['fileext']);
	exit;
}
$head['title'] = $MOD['seo_title'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];

include template($mod, 'index');
?>