<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($dosubmit)
{
	$setting['categoryUrlRuleid'] = $category;
	$setting['showUrlRuleid'] = $show;
	$tpl_path = PHPCMS_ROOT.'templates/'.TPL_NAME.'/ask/tag_config.inc.php';
	if(!is_writable($tpl_path)) showmessage($tpl_path.'不可写');
	$data = file_get_contents($tpl_path);
	$data = str_replace("\'urlruleid\' => \'$hiddenShowUrlRuleid\'","\'urlruleid\' => \'$setting[showUrlRuleid]\'",$data);
	$data = str_replace("\'urlruleid\' => \'$hiddenCategoryUrlRuleid\'","\'urlruleid\' => \'$setting[categoryUrlRuleid]\'",$data);
	file_put_contents($tpl_path,$data);
	tags_update();
	module_setting($mod, $setting);
	showmessage($LANG['save_setting_success'],$forward);
}
else
{
	@extract(new_htmlspecialchars($M));
    include admin_tpl('setting');
}
?>