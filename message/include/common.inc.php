<?php
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));

$mod = 'message';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';

if(!$_userid) showmessage($LANG['login_website'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));

$head['title'] = $MOD['name'];
$head['keywords'] = '';
$head['description'] = $LANG['message'];
?>