<?php
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));
$mod = 'digg';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';
$session = new phpcms_session();
require MOD_ROOT.'/include/global.func.php';


?>