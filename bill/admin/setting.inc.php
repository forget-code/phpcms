<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	$setting = array();
	$setting['type'] = $type;
	$setting['number'] = $number;
	$setting['domain'] = $domain;
	module_setting($mod, $setting);
	showmessage($LANG['operation_success'], $PHP_REFERER);
}
else
{
	@extract(new_htmlspecialchars($MOD));
	if (!isset($type)) $type = 'points';
	if (!isset($number)) $number = 0;
	if (!isset($domain)) $domain = "localhost,$PHP_DOMAIN";

	include admintpl('setting');
}
?>