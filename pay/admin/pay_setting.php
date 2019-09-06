<?php
defined('IN_PHPCMS') or exit('Access Denied');

$submenu = array
(
	array($LANG['parameter_setting'], "?mod=".$mod."&file=pay_setting"),
	array($LANG['all_payment_record'], "?mod=".$mod."&file=pay&action=all"),
	array($LANG['success_record'], "?mod=".$mod."&file=pay&action=success"),
	array($LANG['fail_record'], "?mod=".$mod."&file=pay&action=fail"),
	array($LANG['today_payment_record'], "?mod=".$mod."&file=pay&action=today")
);

$menu = adminmenu($LANG['online_payment_manage'],$submenu);

$today = date("Y-m-d");

if($submit)
{
	foreach($enable as $id=>$v)
	{
		$db->query("UPDATE ".TABLE_PAY_SETTING." SET enable='$enable[$id]',name='$name[$id]',logo='$logo[$id]',sendurl='$sendurl[$id]',receiveurl='$receiveurl[$id]',partnerid='$partnerid[$id]',keycode='$keycode[$id]',percent='$percent[$id]' where id='$id'");
	}
	cache_paysetting();
	showmessage($LANG['operation_success'],$PHP_REFERER);
}
else
{
	$result = $db->query("SELECT * FROM ".TABLE_PAY_SETTING." ORDER BY id");
	while($r = $db->fetch_array($result))
	{
		$settings[]=$r;
	}
	include admintpl('pay_setting');
}

function cache_paysetting()
{
	global $db;
	$result = $db->query("SELECT * FROM ".TABLE_PAY_SETTING." WHERE enable=1 ORDER BY id");
	while($r = $db->fetch_array($result))
	{
		$data[$r['paycenter']] = $r;
	}
	return cache_array($data,"\$PAY_SETTINGS",PHPCMS_CACHEDIR."pay_settings.php");
}
?>