<?php
defined('IN_PHPCMS') or exit('Access Denied');
//error_reporting(E_ALL);
if($action=='option')
{	
	require $file."_".$action.".inc.php";
	exit;
}

if($dosubmit)
{
	module_setting($mod, $setting);
	extract($setting);
	if($displaycreatetype_application)
	{
		if($displayishtml)
		{
			$displaylist_urlruleid = $displaylist_html_urlruleid;
			$displayitem_urlruleid = $displayitem_html_urlruleid;
		}
		else
		{
			$displaylist_urlruleid = $displaylist_php_urlruleid;
			$displayitem_urlruleid = $displayitem_php_urlruleid;
		}
		$db->query("UPDATE ".TABLE_HOUSE_DISPLAY." SET ishtml=$displayishtml,urlruleid=$displayitem_urlruleid WHERE 1");
		$PHP_REFERER = "?mod=$mod&&file=createhtml&action=urlhouse&referer=".urlencode("?mod=$mod&&file=setting");
	}
	if($housecreatetype_application)
	{
		if($houseishtml)
		{
			$houselist_urlruleid = $houselist_html_urlruleid;
			$houseitem_urlruleid = $houseitem_html_urlruleid;
		}
		else
		{
			$houselist_urlruleid = $houselist_php_urlruleid;
			$houseitem_urlruleid = $houseitem_php_urlruleid;
		}
		$db->query("UPDATE ".TABLE_HOUSE." SET ishtml=$houseishtml,urlruleid=$houseitem_urlruleid WHERE 1");
		$PHP_REFERER = "?mod=$mod&&file=createhtml&action=urlinfo&referer=".urlencode("?mod=$mod&&file=setting");
	}

	//$MOD['display_list_url'] = linkurl(display_list_url('url')); //缓存新楼盘列表地址
	//module_setting($mod, $MOD);

	cache_infocat();
	showmessage($LANG['save_setting_success'], $PHP_REFERER);
}
else
{
	$INFOtype = array();
	foreach ($PARS['infotype'] as $k=>$v)
	{
		if(strpos($k,'type_')>-1)
		{
			$INFOtype[] = $v;
		}
	}
	include_once(PHPCMS_ROOT.'/'.$mod.'/include/formselect.func.php');


	$MOD['display_list_url'] = linkurl(display_list_url('url')); //缓存新楼盘列表地址
	module_setting($mod, $MOD);

	@extract(new_htmlspecialchars($MOD));	

	$displaylist_html_urlruleid = isset($displaylist_html_urlruleid) ? $displaylist_html_urlruleid : 0;
	$displayitem_html_urlruleid = isset($displayitem_html_urlruleid) ? $displayitem_html_urlruleid : 0;
	$displaylist_php_urlruleid = isset($displaylist_php_urlruleid) ? $displaylist_php_urlruleid : 0;
	$displayitem_php_urlruleid = isset($displayitem_php_urlruleid) ? $displayitem_php_urlruleid : 0;
	$displaylist_html_urlrule = display_urlrule_select('setting[displaylist_html_urlruleid]','html','list', $displaylist_html_urlruleid);
	$displayitem_html_urlrule = display_urlrule_select('setting[displayitem_html_urlruleid]','html','item',$displayitem_html_urlruleid);
	$displaylist_php_urlrule = display_urlrule_select('setting[displaylist_php_urlruleid]','php','list',$displaylist_php_urlruleid);
	$displayitem_php_urlrule = display_urlrule_select('setting[displayitem_php_urlruleid]','php','item',$displayitem_php_urlruleid);
	
	$houselist_html_urlruleid = isset($houselist_html_urlruleid) ? $houselist_html_urlruleid : 0;
	$houseitem_html_urlruleid = isset($houseitem_html_urlruleid) ? $houseitem_html_urlruleid : 0;
	$houselist_php_urlruleid = isset($houselist_php_urlruleid) ? $houselist_php_urlruleid : 0;
	$houseitem_php_urlruleid = isset($houseitem_php_urlruleid) ? $houseitem_php_urlruleid : 0;
	$houselist_html_urlrule = house_urlrule_select('setting[houselist_html_urlruleid]','html','type', $houselist_html_urlruleid);
	$houseitem_html_urlrule = house_urlrule_select('setting[houseitem_html_urlruleid]','html','item',$houseitem_html_urlruleid);
	$houselist_php_urlrule = house_urlrule_select('setting[houselist_php_urlruleid]','php','type',$houselist_php_urlruleid);
	$houseitem_php_urlrule = house_urlrule_select('setting[houseitem_php_urlruleid]','php','item',$houseitem_php_urlruleid);
	$arrgroupid_browse = showgroup("checkbox", "setting[arrgroupid_browse][]", implode(",",$arrgroupid_browse));
	$showtpl = showtpl($mod,'index','setting[templateid]',$templateid);
	$showskin = showskin('setting[skinid]',$skinid);
	cache_infocat();
    include admintpl('setting');
}
?>