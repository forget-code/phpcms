<?php
defined('IN_PHPCMS') or exit('Access Denied');
$announceid = intval($announceid);
$res = $db->query("SELECT title,content,hits,fromdate,todate,username,addtime FROM ".TABLE_ANNOUNCE." WHERE announceid=$announceid");
if ($db->num_rows($res) > 0)
{
	$row = $db->fetch_row($res);
}
?>