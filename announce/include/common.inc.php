<?php
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));
$mod = 'announce';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';
$head['title'] = $LANG['the_front_page_of_announce'];
$head['keywords'] = $LANG['the_front_page_of_announce'];
$head['description'] = $LANG['the_front_page_of_announce'];
?>