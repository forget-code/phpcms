<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	if($setting['alipay_service']!='trade_create_by_buyer')
	{
		$setting['logistics_type'] = '';
		$setting['logistics_payment'] = '';
		$setting['logistics_fee'] = '';
	}
	module_setting($mod, $setting);
	showmessage($LANG['save_setting_success'],$PHP_REFERER);
}
else
{
	@extract(new_htmlspecialchars($MOD));	
	
    include admintpl('setting');
}
?>