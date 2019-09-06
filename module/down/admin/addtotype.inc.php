<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(!$downids) showmessage($LANG['illegal_parameters']);
$typeid = intval($typeid);
$downids = is_array($downids) ? implode(',', $downids) : $downids;
$db->query("UPDATE ".channel_table('down', $channelid)." SET typeid=$typeid WHERE downid IN($downids)");
showmessage($LANG['operation_success'], $forward);
?>