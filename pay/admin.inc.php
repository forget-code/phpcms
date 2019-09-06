<?php
defined('IN_PHPCMS') or exit('Access Denied');

define('MOD_ROOT', PHPCMS_ROOT.'/'.$mod);

require_once MOD_ROOT.'/admin/include/pay.func.php';
require_once MOD_ROOT.'/include/pay.func.php';

if(!(@include MOD_ROOT.'/admin/'.$file.'.inc.php')) showmessage($LANG['illegal_operation']);
?>