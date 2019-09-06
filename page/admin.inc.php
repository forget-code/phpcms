<?php
defined('IN_PHPCMS') or exit('Access Denied');

define('MOD_ROOT', PHPCMS_ROOT.'/'.$mod);

require MOD_ROOT.'/include/tag.func.php';
if(!@include_once(MOD_ROOT.'/admin/'.$file.'.inc.php')) showmessage($LANG['illegal_operation']);
?>