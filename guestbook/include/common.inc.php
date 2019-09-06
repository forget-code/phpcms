<?php 
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));
$mod = 'guestbook';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';
$head['title'] = $MODULE[$mod]['name'];
$head['keywords'] = $M['seo_keywords'];
$head['description'] = $M['seo_description'];
?>