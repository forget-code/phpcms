<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	module_setting($mod, $setting);
	showmessage($LANG['setting_save_success'],$PHP_REFERER);
}
else
{
	@extract(new_htmlspecialchars($MOD));	
    include admintpl('setting');
}
?>