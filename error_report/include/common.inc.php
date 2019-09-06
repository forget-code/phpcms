<?php
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));
$mod = 'error_report';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';
$head['title'] = $MOD['name'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];
?>