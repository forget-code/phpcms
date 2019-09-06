<?php 
$mod = 'search';
define('MOD_ROOT', substr(dirname(__FILE__), 0, -7));
require substr(MOD_ROOT, 0, -1-strlen($mod)).'include/common.inc.php';

require MOD_ROOT.'include/search.class.php';
$search = new search();
?>