<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	if($setting['ishtml'] == 1)
	{
		$setting['type_urlruleid'] = $setting['type_urlruleid_1'];
		$setting['show_urlruleid'] = $setting['show_urlruleid_1'];
	}
	else
	{
		$setting['type_urlruleid'] = $setting['type_urlruleid_0'];
		$setting['show_urlruleid'] = $setting['show_urlruleid_0'];
	}
	unset($setting['type_urlruleid_1'], $setting['show_urlruleid_1'], $setting['type_urlruleid_0'], $setting['show_urlruleid_0']);
	module_setting($mod, $setting);
	showmessage($LANG['save_setting_success'], HTTP_REFERER);
}
else
{
	@extract(new_htmlspecialchars($M));
	if(!isset($ishtml)) $ishtml = $PHPCMS['ishtml'];
    include admin_tpl('setting');
}
?>