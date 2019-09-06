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
		@unlink(PHPCMS_ROOT.'special/index.html');
	}
	unset($setting['type_urlruleid_1'], $setting['show_urlruleid_1'], $setting['type_urlruleid_0'], $setting['show_urlruleid_0']);
	module_setting($mod, $setting);
	showmessage($LANG['save_setting_success'], '?mod=special&file=setting&update_type_url=1');
}
elseif($update_type_url)
{
	require_once 'admin/type.class.php';
	$type = new type($mod);
	require_once MOD_ROOT.'include/url.class.php';
	$typeurl = new url();
	$result = $db->query("SELECT `typeid` FROM `".DB_PRE."type` WHERE `module`='special'");
	while($r = $db->fetch_array($result))
	{
		$url = $typeurl->type($r['typeid']);
		$db->query("UPDATE `".DB_PRE."type` SET `url`='$url' WHERE `typeid`='$r[typeid]'");
	}
	$type->cache();
	showmessage('分类链接更新成功', '?mod=special&file=setting&update_url=1');
}
elseif($update_url)
{
	require_once MOD_ROOT.'include/special.class.php';
   
	$special = new special();
	$special->update_urls();
	showmessage('专题链接更新成功', '?mod=special&file=setting');
}
else
{
	@extract(new_htmlspecialchars($M));
	if(!isset($ishtml)) $ishtml = $PHPCMS['ishtml'];
    include admin_tpl('setting');
}
?>