<?php
require './include/common.inc.php';
if(!$forward) $forward = HTTP_REFERER;
if(!$M['allowregister']) showmessage('该网站不能注册，请与网站管理员联系');
if(!$_userid) showmessage($LANG['please_login'], $M['url'].'login.php?forward='.urlencode(URL));

if(!class_exists('member_form'))
{
	require CACHE_MODEL_PATH.'member_form.class.php';
}
$member_form = new member_form($_modelid);
if(count($member_form->fields) < 1) 
{
	header('Location:'.SITE_URL);
	exit;
}

if(!class_exists('member_input'))
{
	require CACHE_MODEL_PATH.'member_input.class.php';
}
$member_input = new member_input($_modelid);

if(!class_exists('member_update'))
{
	require CACHE_MODEL_PATH.'member_update.class.php';
}
$member_update = new member_update($_modelid, $_userid);

if(!class_exists('model_member_field'))
{
	MOD_ROOT.'admin/include/model_member_field.class.php';
}

if($dosubmit)
{
	$inputinfo = $member_input->get($info);
	$modelinfo = $inputinfo['model'];
	$modelinfo['userid'] = $_userid;
	$member_update->update($modelinfo);
	$member->edit_model($_modelid, $modelinfo);
	showmessage($LANG['operation_success'], SITE_URL);
}
else
{
	$data = $member->get_model_info($_userid, $_modelid);
	$forminfos = $member_form->get($data);
	if(!$forminfos) 
	{
		header('location:'.url(SITE_URL, 1));
	}
	include template($mod, 'register_model');
}
?>