<?php
$mod = 'yp';
define('MOD_ROOT', substr(dirname(__FILE__), 0, -7));
require substr(MOD_ROOT, 0, -1-strlen($mod)).'include/common.inc.php';

require MOD_ROOT.'include/global.func.php';
$head['title'] = $M['name'];
$head['keywords'] = $LANG['member_center'];
$head['description'] = $LANG['member_center'];
define('BUSINESSDIR', $M['url'].$M['businessdir'].'/');
require_once MOD_ROOT.'include/output.func.php';
?>