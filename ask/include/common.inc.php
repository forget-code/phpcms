<?php 
$mod = 'ask';
define('MOD_ROOT', substr(dirname(__FILE__), 0, -7));

require substr(MOD_ROOT, 0, -1-strlen($mod)).'include/common.inc.php';
require MOD_ROOT.'include/global.func.php';
require_once MOD_ROOT.'include/output.func.php';
require_once 'form.class.php';
$C = subcat('ask');
?>