<?php
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));
$mod = "spider";

require substr(MOD_ROOT, 0, - strlen($mod)) . 'include/common.inc.php';

require MOD_ROOT . "/include/functions.func.php";
require MOD_ROOT . "/include/extension.inc.php";

?>