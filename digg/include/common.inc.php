<?php 
$mod = 'digg';
define('MOD_ROOT', substr(dirname(__FILE__), 0, -7));

require substr(MOD_ROOT, 0, -1-strlen($mod)).'include/common.inc.php';
require MOD_ROOT.'include/digg.class.php';
$digg = new digg();
?>