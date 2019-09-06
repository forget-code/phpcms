<?php
require './include/common.inc.php';

if(!$_userid) showmessage($LANG['please_login'], $MOD['linkurl'].'login.php?forward='.urlencode($PHP_URL));

if($dosubmit)
{
	$result = $member->editpassword($oldpassword, $password);
	if(!$result) showmessage($LANG['original_password_not_correct'], $PHP_REFERER);
    $member->login($password);
	showmessage($LANG['operation_success'], $PHP_REFERER);
}
else
{
	$head['title'] = $LANG['member_profile_edit'];
	$head['keywords'] = $LANG['member_profile_edit'];
	$head['description'] = $LANG['member_profile_edit'];

    include template('member', 'editpassword');
}
?>