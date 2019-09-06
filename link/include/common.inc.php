<?php 
$mod = 'link';
define('MOD_ROOT', substr(dirname(__FILE__), 0, -7));
require substr(MOD_ROOT, 0, -1-strlen($mod)).'include/common.inc.php';
$head['title'] = $MODULE['link']['name'];
$head['keywords'] = $M['seo_keywords'];
$head['description'] = $M['seo_description'];
?>