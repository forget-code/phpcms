<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	$setting['enabledkey'] = ',';
	foreach($enabledkeys as $key)
	{
		$setting['enabledkey'] .= $key.",";
	}
	module_setting($mod, $setting);
	showmessage($LANG['save_setting_success'], HTTP_REFERER);
}
else
{
	@extract(new_htmlspecialchars($M));
	include admin_tpl('setting');
}
?>