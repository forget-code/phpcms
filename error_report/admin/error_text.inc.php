<?php
defined('IN_PHPCMS') or exit('Access Denied');
$submenu = array(
	array($LANG['error_list'],"?mod=$mod&file=error_report"),
);
$menu = adminmenu($LANG['error_name'],$submenu);
$forward="?mod=$mod&file=error_report";
if($dosubmit)
{
	if($error_id && $radiobutton)
	{
		$sql="UPDATE ".TABLE_ERROR_REPORT." SET status = '$radiobutton' WHERE error_id='$error_id'";
		$db->query($sql);
		showmessage($LANG['operation_success'],$forward);
	}
	else
	{
		showmessage($LANG['illegal_operation'],$PHP_REFERER );
	}
}
if($error_id)
{
	$sql="SELECT * FROM ".TABLE_ERROR_REPORT." WHERE error_id=$error_id";
	$error_text=$db->get_one($sql);
}
else
{
	showmessage($LANG['illegal_operation'],$PHP_REFERER );
}
include admintpl('error_text');
?>