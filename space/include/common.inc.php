<?php 
$mod = 'space';
define('MOD_ROOT', substr(dirname(__FILE__), 0, -7));
require substr(MOD_ROOT, 0, -1-strlen($mod)).'/include/common.inc.php';
require substr(MOD_ROOT, 0, -1-strlen($mod)).'/include/cache.func.php';
$space = load('space.class.php', 'space');
require 'attachment.class.php';
$attachment = new attachment($mod);
?>