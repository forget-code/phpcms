<?php 
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));

$mod = 'vote';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';

if(!isset($keyid)) $keyid = 0;

$head['title'] = $MOD['name'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];
?>