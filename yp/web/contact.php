<?php
define('IN_YP_ADMIN', TRUE);
$rootdir = substr(dirname(__FILE__), 0, -3);

echo $rootdir.'/admin/include/global.func.php';
require $rootdir.'/include/common.inc.php';

?>