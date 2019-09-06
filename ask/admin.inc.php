<?php
defined('IN_PHPCMS') or exit('Access Denied');

define('MOD_ROOT',PHPCMS_ROOT.'/'.$mod);

$TYPE = cache_read('type_'.$mod.'.php');
$STATUS = array($LANG['unsettled'], $LANG['under_dealing'], $LANG['dealed'], $LANG['reject_deal']);

require MOD_ROOT.'/include/global.func.php';
require MOD_ROOT.'/admin/include/global.func.php';

if(!@include_once(MOD_ROOT.'/admin/'.$file.'.inc.php')) showmessage($LANG['illegal_operation']);
?>