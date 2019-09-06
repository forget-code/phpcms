<?php 
defined('IN_PHPCMS') or exit('Access Denied');
define('MOD_ROOT', PHPCMS_ROOT.'/module/'.$mod);
require_once PHPCMS_ROOT.'/include/channel.inc.php';
require_once MOD_ROOT.'/include/global.func.php';
require_once MOD_ROOT.'/include/tag.func.php';
if($channelid) $channelid = intval($channelid);
$TYPE = cache_read('type_'.$channelid.'.php');
?>