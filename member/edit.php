<?php
require './include/common.inc.php';
if(!$_userid) showmessage($LANG['please_login'], $M['url'].'login.php?forward='.urlencode(URL));
if(!$forward) $forward = HTTP_REFERER;

if(!class_exists('member_form'))
{
	require CACHE_MODEL_PATH.'member_form.class.php';
}
$member_form = new member_form($_modelid);

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

if($dosubmit)
{
	if($PHPCMS['uc'])
	{
		$username = $_username;
		$email = $_email;
		$password = $_password;
		$action = 'editpwd';
		require MOD_ROOT.'api/passport_server_ucenter.php';
	}
	$inputinfo = $member_input->get($info);
	if(isset($info) && is_array($info))
	{
		if(!$member->edit($info)) showmessage($member->msg());
	}
	
	$modelinfo = $inputinfo['model'];
	if($modelinfo)
	{
		$modelinfo['userid'] = $_userid;
		$member_update->update($modelinfo);
		$member->edit_model($_modelid, $modelinfo);
	}
	showmessage($LANG['operation_success'], $forward);
}
else
{
	$memberinfo = $member->get($_userid, $fields = '*', 1);
	$memberinfo['avatar'] = avatar($_userid);
	@extract(new_htmlspecialchars($memberinfo));
	$data = $member->get_model_info($_userid, $_modelid);
	$forminfos = $member_form->get($data);

	$head['title'] = $LANG['member_profile_edit'];
	$head['keywords'] = $LANG['member_profile_edit'];
	$head['description'] = $LANG['member_profile_edit'];
	
    include template('member', 'edit');
}
?>