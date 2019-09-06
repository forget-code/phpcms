<?php
defined('IN_PHPCMS') or exit('Access Denied');
define('MOD_ROOT', PHPCMS_ROOT . "/" . $mod);
$skinid = isset($skinid) ? $skinid : 'default';
$skindir = PHPCMS_PATH . 'templates/' . $CONFIG['defaulttemplate'] . '/skins/' . $skinid;
if (!@include_once(MOD_ROOT . "/admin/" . $file . ".inc.php")) showmessage($LANG['illegal_operation']);

?>