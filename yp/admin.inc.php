<?php
defined('IN_PHPCMS') or exit('Access Denied');

define('MOD_ROOT', PHPCMS_ROOT.'/'.$mod);

$CATEGORY = cache_read("categorys_".$mod.".php");
$TYPE = cache_read("type_".$mod.".php");
if(!@include_once(MOD_ROOT.'/admin/'.$file.'.inc.php')) showmessage($LANG['illegal_operation']);
?>