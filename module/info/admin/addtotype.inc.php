<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(!$infoids) showmessage($LANG['illegal_parameters']);
$typeid = intval($typeid);
$infoids = is_array($infoids) ? implode(',', $infoids) : $infoids;
$db->query("UPDATE ".channel_table('info', $channelid)." SET typeid=$typeid WHERE infoid IN($infoids)");
showmessage($LANG['operation_success'], $forward);
?>