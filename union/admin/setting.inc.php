<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	module_setting($mod, $setting);
	showmessage($LANG['save_setting_success'],$PHP_REFERER);
}
else
{
	@extract(new_htmlspecialchars($MOD));
    if(!isset($MOD['forward']) || !$MOD['forward']) $forward = $PHP_SITEURL;
    include admintpl('setting');
}
?>