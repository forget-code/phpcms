<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(!$pictureids) showmessage($LANG['illegal_parameters']);
$typeid = intval($typeid);
$pictureids = is_array($pictureids) ? implode(',', $pictureids) : $pictureids;
$db->query("UPDATE ".channel_table('picture', $channelid)." SET typeid=$typeid WHERE pictureid IN($pictureids)");
showmessage($LANG['operation_success'], $forward);
?>