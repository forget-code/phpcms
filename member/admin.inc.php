<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/include/date.class.php';
$date = new phpcms_date;

define('MOD_ROOT', PHPCMS_ROOT.'/'.$mod);
require MOD_ROOT.'/include/global.func.php';

$genders = array(0 => $LANG['female'], 1 => $LANG['male']);

if(!(@include MOD_ROOT.'/admin/'.$file.'.inc.php')) showmessage($LANG['illegal_operation']);
?>