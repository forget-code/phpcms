<?php
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));
$mod = 'stat';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';

@extract($MOD);
if($disabled) exit;

$vid = intval(getcookie('vid'));
$times = intval(getcookie('visits'));
$pid = intval(getcookie('pid'));
?>