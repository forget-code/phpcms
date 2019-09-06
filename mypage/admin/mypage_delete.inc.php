<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(empty($mypageid))
{
	showmessage($LANG['select_page']);
}
$mypageids=is_array($mypageid) ? implode(',',$mypageid) : $mypageid;
$db->query("DELETE FROM ".TABLE_MYPAGE." WHERE mypageid IN ($mypageids)");
if($db->affected_rows()>0)
{
	showmessage($LANG['operation_success'],$PHP_REFERER);
}
else
{
	showmessage($LANG['operation_failure']);
}
?>