<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!$forward) $forward = HTTP_REFERER;
if($dosubmit)
{
	if(!isset($setting['allow_add_news'])) $setting['allow_add_news'][] = 0;
	if(!isset($setting['allow_add_product'])) $setting['allow_add_product'][] = 0;
	if(!isset($setting['allow_add_buy'])) $setting['allow_add_buy'][] = 0;
	if(!isset($setting['allow_add_job'])) $setting['allow_add_job'][] = 0;
	if(!isset($setting['allow_add_stat'])) $setting['allow_add_stat'][] = 0;
	if(!isset($setting['allow_add_cert'])) $setting['allow_add_cert'][] = 0;
	unset($setting['url']);
	module_setting($mod, $setting);
	showmessage($LANG['save_setting_success'], $forward);
}
else
{
	@extract(new_htmlspecialchars($M));
	unset($GROUP[2],$GROUP[3]);
    include admin_tpl('setting');
}
?>