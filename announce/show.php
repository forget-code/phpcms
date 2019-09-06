<?php
require './include/common.inc.php';
$announceid = isset($announceid) ? intval($announceid) : 0;
if(!$announceid) showmessage($LANG['illegal_parameters']);
$today = date('Y-m-d');
$r = $db->get_one("SELECT * FROM ".TABLE_ANNOUNCE." WHERE announceid=$announceid AND passed=1 AND (todate='0000-00-00' OR todate>=$today)");
if(!$r) showmessage($LANG['not_exist_announce']);
extract($r);
$addtime = date('Y-m-d H:i:s', $addtime);
$todate = $todate == '0000-00-00' ? $LANG['unrestricted'] : $todate;
$db->query("UPDATE ".TABLE_ANNOUNCE." SET hits=hits+1 WHERE announceid=$announceid");
include template('announce', 'show');
?>