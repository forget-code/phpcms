<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	$arrgroupidview_apply = isset($arrgroupidview_apply) && is_array($arrgroupidview_apply) ? implode(',',$arrgroupidview_apply) : "";
	$setting['arrgroupidview_apply'] = $arrgroupidview_apply;
	$arrgroupidview_post = isset($arrgroupidview_post) && is_array($arrgroupidview_post) ? implode(',',$arrgroupidview_post) : "";
	$setting['arrgroupidview_post'] = $arrgroupidview_post;
	module_setting($mod, $setting);
	if($createtype_application)
	{
		if($setting['ishtml'])
		{
			$cat_urlruleid = $setting['cat_html_urlruleid'];
		}
		else
		{
			$cat_urlruleid = $setting['cat_php_urlruleid'];
		}
		$db->query("UPDATE ".TABLE_CATEGORY." SET ishtml=$setting[ishtml],urlruleid=$cat_urlruleid WHERE module='$mod'");
		foreach($CATEGORY as $catid=>$cat)
		{
			cache_category($catid);
		}
		cache_categorys($mod);
	}
	$TYPE = cache_read('type_yp.php');
	foreach($TYPE AS $k=>$temp)
	{
		if($setting['tohtml'])
		{
			$TYPE[$k]['linkurl'] = $MOD['linkurl'].$setting['article_dir'].'/'.$TYPE[$k]['type'].'-'.$k.'.'.$PHPCMS['fileext'];
		}
		else
		{
			$TYPE[$k]['linkurl'] = $MOD['linkurl'].'article.php?action=list&catid='.$k;
		}
	}
	cache_write('yp_article_cat.php', $TYPE);
	showmessage($LANG['save_setting_success'], $forward);
}
else
{
	include_once(PHPCMS_ROOT.'/'.$mod.'/include/formselect.func.php');
	@extract(new_htmlspecialchars($MOD));	
	$arrgroupidview_apply = showgroup("checkbox","arrgroupidview_apply[]",$arrgroupidview_apply);
	$arrgroupidview_post = showgroup("checkbox","arrgroupidview_post[]",$arrgroupidview_post);

	$cat_html_urlruleid = isset($cat_html_urlruleid) ? $cat_html_urlruleid : 0;
	$cat_php_urlruleid = isset($cat_php_urlruleid) ? $cat_php_urlruleid : 0;
	$cat_html_urlrule = yp_urlrule_select('setting[cat_html_urlruleid]','html','cat', $cat_html_urlruleid);
	$cat_php_urlrule = yp_urlrule_select('setting[cat_php_urlruleid]','php','cat',$cat_php_urlruleid);
	$showtpl = showtpl($mod,'index','setting[templateid]',$templateid);
	$showskin = showskin('setting[skinid]',$skinid);

    include admintpl('setting');
}
?>