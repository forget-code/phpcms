<?php
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));

$mod = 'bill';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';
?>