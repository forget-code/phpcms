<?php
defined('IN_PHPCMS') or exit('Access Denied');
$announceid = intval($announceid);
if ($dosubmit)
{
	$db->query("UPDATE ".TABLE_ANNOUNCE." SET title='$atitle',content='$content',fromdate='$fromdate',todate='$todate',passed='$passed',templateid='$templateid',skinid='$skinid' WHERE announceid='$announceid'");
	$referer = "?mod=$mod&file=$file&action=manage&passed=$passed&keyid=$keyid";
	showmessage($LANG['operation_success'], $referer);
}
$res = $db->query("SELECT title,content,fromdate,todate,passed,templateid,skinid FROM ".TABLE_ANNOUNCE." WHERE announceid=$announceid");
if ($db->num_rows($res) > 0)
{
	$row = $db->fetch_row($res);
	$row[3] = $row[3] == '0000-00-00' ? null : $row[3];
}
?>