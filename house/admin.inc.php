<?php
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/house/include/common.inc.php';
require PHPCMS_ROOT.'/include/area.func.php';

if(!@include_once(MOD_ROOT.'/admin/'.$file.'.inc.php')) showmessage($LANG['illegal_operation']);
?>