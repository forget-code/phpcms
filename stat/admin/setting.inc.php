<?php
defined('IN_PHPCMS') or exit('Access Denied');
if ($dosubmit) {
	$setting = array(
		'disabled' => $disabled,
		'savetime' => $savetime,
		'interval' => $interval,
		'username' => $username,
		'passwd' => $passwd
	);
	module_setting($mod, $setting);
	showmessage($LANG['operation_success'],$PHP_REFERER);
}
@extract($MOD);
include admintpl('setting');
?>