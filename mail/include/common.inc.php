<?php 
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));

$mod = 'mail';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';

include PHPCMS_ROOT.'/include/mail.inc.php';
include PHPCMS_ROOT."/$mod/include/global.func.php";

$head['title'] = $LANG['send_email'];
$head['keywords'] = $LANG['send_email'];
$head['description'] = $LANG['send_email'];
?>