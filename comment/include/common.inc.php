<?php 
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));

$mod = 'comment';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';

$itemid = intval($itemid);

$head['title'] = $LANG['comment'];
$head['keywords'] = $LANG['comment'];
$head['description'] = $LANG['comment'];

$SMILIES = cache_read('smilies_list.php');

include MOD_ROOT.'/include/global.func.php';
?>