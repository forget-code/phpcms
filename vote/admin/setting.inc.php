<?php

defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	module_setting($mod, $setting);
	showmessage($LANG['save_setting_success'], $forward);
}
else
{	
	@extract(new_htmlspecialchars($MOD));	
    include admintpl('setting');
}
?>