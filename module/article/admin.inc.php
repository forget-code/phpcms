<?php
defined('IN_PHPCMS') or exit('Access Denied');
define('MOD_ROOT', PHPCMS_ROOT.'/module/'.$mod);

if($_grade > 1) require MOD_ROOT.'/admin/include/checkpurview.inc.php';

if($channelid) require PHPCMS_ROOT.'/include/channel.inc.php';
require MOD_ROOT.'/include/global.func.php';
require MOD_ROOT.'/include/tag.func.php';

$job = isset($job) ? $job : '';

$TYPE = cache_read('type_'.$channelid.'.php');

if(!@include(MOD_ROOT.'/admin/'.$file.'.inc.php')) showmessage($LANG['access_denied']);
?>