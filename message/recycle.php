<?php
require './include/common.inc.php';
if ($dosubmit)
{
	$mids0 = '';
	$mids1 = '';
	foreach ($mid as $value)
	{
		$arrTmp = explode('|', $value);
		if ($arrTmp[1] == 0)
		{
			$mids0 .= intval($arrTmp[0]) . ',';
		}
		elseif ($arrTmp[1] == 1)
		{
			$mids1 .= intval($arrTmp[0]) . ',';
		}
	}
	if (!empty($mids0))
	{
		$mids0 = substr($mids0, 0, -1);
		if (isset($restore))
		{
			$db->query("UPDATE ".TABLE_MESSAGE_INBOX." SET forsake=0 WHERE id IN ($mids0) AND receiver='$_username' AND forsake=1 AND types=0");
		}
		else
		{
			$db->query("DELETE FROM ".TABLE_MESSAGE_INBOX." WHERE id IN ($mids0) AND receiver='$_username' AND forsake=1 AND types=0");
		}
	}
	if (!empty($mids1))
	{
		$mids1 = substr($mids1, 0, -1);
		if (isset($restore))
		{
			$db->query("UPDATE ".TABLE_MESSAGE_OUTBOX." SET forsake=0 WHERE id IN ($mids1) AND sender='$_username' AND forsake=1");
		}
		else
		{
			$db->query("DELETE FROM ".TABLE_MESSAGE_OUTBOX." WHERE id IN ($mids1) AND sender='$_username' AND forsake=1");
		}
	}
}
elseif (isset($action) && $action == 'empty')
{
	$db->query("DELETE FROM ".TABLE_MESSAGE_INBOX." WHERE receiver='$_username' AND types=0 AND forsake=1");
	$db->query("DELETE FROM ".TABLE_MESSAGE_OUTBOX." WHERE sender='$_username' AND forsake=1");
	showmessage($LANG['operation_success'], $PHP_REFERER);
}
include(MOD_ROOT.'/include/global.inc.php');
include template('message','recycle');
?>