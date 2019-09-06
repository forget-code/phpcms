<?php 
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));

$mod = 'pay';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';
require_once MOD_ROOT.'/include/pay.func.php';

$head['title'] = $LANG['payment_center'];
$head['keywords'] = $LANG['payment_center'];
$head['description'] = $LANG['payment_center'];
?>