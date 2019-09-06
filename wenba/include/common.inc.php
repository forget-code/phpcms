<?php 
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));
$mod = 'wenba';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';
require MOD_ROOT.'/include/global.func.php';
require MOD_ROOT.'/include/tag.func.php';

$head['title'] = $MOD['name'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];
?>