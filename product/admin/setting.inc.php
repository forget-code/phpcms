<?php

defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	module_setting($mod, $setting);
	extract($setting);
	if($createtype_application)
	{
		if($ishtml)
		{
			$cat_urlruleid = $cat_html_urlruleid;
			$item_urlruleid = $item_html_urlruleid;
		}
		else
		{
			$cat_urlruleid = $cat_php_urlruleid;
			$item_urlruleid = $item_php_urlruleid;
		}
		$db->query("UPDATE ".TABLE_CATEGORY." SET ishtml=$ishtml,urlruleid=$cat_urlruleid,item_html_urlruleid=$item_html_urlruleid,item_php_urlruleid=$item_php_urlruleid WHERE module='$mod'");
		$db->query("UPDATE ".TABLE_PRODUCT." SET ishtml=$ishtml,urlruleid=$item_urlruleid WHERE 1");
		foreach($CATEGORY as $catid=>$cat)
		{
			cache_category($catid);
		}
		cache_categorys($mod);
		$forward = '?mod=phpcms&file=linkurl&action=updatemodule&module='.$mod;
	}
	showmessage($LANG['save_setting_success'], $forward);
}
else
{
	include_once(PHPCMS_ROOT.'/'.$mod.'/include/formselect.func.php');
	@extract(new_htmlspecialchars($MOD));	

	$cat_html_urlruleid = isset($cat_html_urlruleid) ? $cat_html_urlruleid : 0;
	$item_html_urlruleid = isset($item_html_urlruleid) ? $item_html_urlruleid : 0;
	$cat_php_urlruleid = isset($cat_php_urlruleid) ? $cat_php_urlruleid : 0;
	$item_php_urlruleid = isset($item_php_urlruleid) ? $item_php_urlruleid : 0;
	$cat_html_urlrule = product_urlrule_select('setting[cat_html_urlruleid]','html','cat', $cat_html_urlruleid);
	$item_html_urlrule = product_urlrule_select('setting[item_html_urlruleid]','html','item',$item_html_urlruleid);
	$cat_php_urlrule = product_urlrule_select('setting[cat_php_urlruleid]','php','cat',$cat_php_urlruleid);
	$item_php_urlrule = product_urlrule_select('setting[item_php_urlruleid]','php','item',$item_php_urlruleid);
	$showtpl = showtpl($mod,'index','setting[templateid]',$templateid);
	$showskin = showskin('setting[skinid]',$skinid);
    include admintpl('setting');
}
?>