<?php
defined('IN_PHPCMS') or exit('Access Denied');
define('MOD_ROOT', PHPCMS_ROOT.'/'.$mod);
if(!(@include MOD_ROOT.'/admin/'.$file.'.inc.php')) showmessage($LANG['illegal_operation']);
?>