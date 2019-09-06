<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
    $db->query("DELETE FROM ".TABLE_BILL." WHERE adddate<='$begindate'");
	showmessage($LANG['operation_success'], $PHP_REFERER);
}
else
{
	$begindate = date('Y-m').'-01';
	include admintpl('delete');
}
?>