<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once 'admin/model.class.php';
require_once 'admin/model_field.class.php';
$model = new model();
$model->cache();
foreach($MODEL as $modelid=>$v)
{
	if($v['modeltype'] == 0)
	{
		$field = new model_field($modelid);
		$field->cache();
	}
}

require_once PHPCMS_ROOT.'member/admin/include/model_member.class.php';
$model = new member_model();
$model->cache();
require_once PHPCMS_ROOT.'member/admin/include/model_member_field.class.php';
foreach($MODEL as $modelid=>$v)
{
	if($v['modeltype'] == 2)
	{
		$member_field = new member_model_field($modelid);
		$member_field->cache();
	}
}

if(isset($MODULE['formguide']))
{
	require_once PHPCMS_ROOT.'formguide/admin/include/formguide_admin.class.php';
	require_once PHPCMS_ROOT.'formguide/admin/include/formguide_fields.class.php';
	$formguide_admin = new formguide_admin();
	$formguide_admin->cache();
	$FORMGUIDE = cache_read('formguide.php');
	foreach($FORMGUIDE as $formid=>$v)
	{
		$form_field = new formguide_fields($formid);
		$form_field->cache();
	}
}

cache_all();
showmessage($LANG['all_cache_update_success']);
?>