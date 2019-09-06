<?php
require './include/common.inc.php';
require 'form.class.php';

if(!$_userid) showmessage($LANG['please_login_or_register']);
$avatar = avatar($_userid);
$type = empty($type) ? 1 : intval($type);
$states = array();
$c_ads->updatearea($adsid);
$states = $c_ads->stat($adsid, $type, $from, $end);
$info_ads = $c_ads->get_info($adsid);
include template($mod, 'stat');
?>