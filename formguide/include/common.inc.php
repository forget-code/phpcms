<?php
$mod = 'formguide';
define('MOD_ROOT', substr(dirname(__FILE__), 0, -7));
require substr(MOD_ROOT, 0, -1-strlen($mod)).'include/common.inc.php';
require PHPCMS_ROOT.'include/form.class.php';
require MOD_ROOT.'include/formguide.class.php';
$formguide = new formguide();
$head['title'] = $M['name'];
$head['keywords'] = $LANG['member_center'];
$head['description'] = $LANG['member_center'];
$FORMGUIDE = cache_read('formguide.php');
?>