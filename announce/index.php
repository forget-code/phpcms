<?php
require './include/common.inc.php';

$announceid = isset($announceid) ? intval($announceid) : 0;
$sql = $announceid ? " AND announceid=$announceid " : " ORDER BY announceid DESC LIMIT 0,1";

$today = date('Y-m-d');

$r = $db->get_one("SELECT * FROM ".TABLE_ANNOUNCE." WHERE passed=1 AND (todate='0000-00-00' OR todate>='$today') $sql");
if(!$r) showmessage($LANG['not_exist_announce']);

extract($r);

if($todate == '0000-00-00') $todate = $LANG['indefinitely'];

$db->query("UPDATE ".TABLE_ANNOUNCE." SET hits=hits+1 WHERE announceid=$announceid");
include template($mod, 'index');
?>