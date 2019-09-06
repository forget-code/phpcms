<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(!$articleids) showmessage($LANG['illegal_parameters']);
$typeid = intval($typeid);
$articleids = is_array($articleids) ? implode(',', $articleids) : $articleids;
$db->query("UPDATE ".channel_table('article', $channelid)." SET typeid=$typeid WHERE articleid IN($articleids)");
showmessage($LANG['operation_success'], $forward);
?>