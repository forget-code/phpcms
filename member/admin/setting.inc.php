<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!$forward) $forward = HTTP_REFERER;
if($dosubmit)
{
	module_setting($mod, $setting);
	showmessage($LANG['save_setting_success'], $forward);
}
else
{
	@extract(new_htmlspecialchars($M));
    include admin_tpl('setting');
}
?>