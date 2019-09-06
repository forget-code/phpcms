<?php
require './include/common.inc.php';
require 'form.class.php';

if(!$_userid) showmessage($LANG['please_login_or_register']);
$avatar = avatar($_userid);
$type = empty($type) ? 1 : intval($type);
$states = array();
$c_ads->updatearea($adsid);
$adsid = intval($adsid);
$r = $db->get_one("SELECT adsid FROM ".DB_PRE."ads WHERE adsid='$adsid' AND username='$_username'");
if(!$r) showmessage('你没有此广告位');
$states = $c_ads->stat($adsid, $type, $from, $end);
$info_ads = $c_ads->get_info($adsid,$_username);
include template($mod, 'stat');
?>