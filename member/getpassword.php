<?php
require './include/common.inc.php';

if($_userid) showmessage($LANG['you_have_logined']);

if($PHPCMS['enableserverpassport'])
{
	$getpasswordurl = $PHPCMS['passport_serverurl'].$PHPCMS['passport_getpasswordurl'];
	$addstr = $PHP_QUERYSTRING ? $PHP_QUERYSTRING : 'forward='.$PHP_REFERER;
	$getpasswordurl .= (strpos($getpasswordurl, '?') ? '&' : '?').$addstr;
	header('location:'.$getpasswordurl);
	exit;
}

$seo_title = $LANG['get_password_back'];

$step = isset($step) ? intval($step) : 1;

if($step == 1)
{
    include template($mod, 'getpassword');
}
elseif($step == 2)
{
	if(is_badword($username)) showmessage($LANG['username_not_accord_with_critizen']);
	if(!is_email($email)) showmessage($LANG['email_not_accord_with_critizen']);

    $r = $db->get_one("SELECT userid,question FROM ".TABLE_MEMBER." WHERE username='$username' AND email='$email' LIMIT 0,1");
	if(!$r) showmessage($LANG['username_and_email_not_match']);
	@extract($r);

    include template($mod, 'getpassword');
}
elseif($step == 3)
{
	if(is_badword($username)) showmessage($LANG['username_not_accord_with_critizen']);
	if(!is_email($email)) showmessage($LANG['email_not_accord_with_critizen']);
	if(empty($answer)) showmessage($LANG['password_clue_question_not_null']);

	$answer = md5($answer);

    $r = $db->get_one("SELECT userid FROM ".TABLE_MEMBER." WHERE username='$username' AND email='$email' AND answer='$answer' LIMIT 0,1");
	if(!$r['userid']) showmessage($LANG['password_clue_answer_not_right']);

	$authstr = $member->make_authstr($username);
	$authurl = linkurl($MOD['linkurl'], 1)."getpassword.php?step=4&username=".urlencode($username)."&authstr=$authstr";
	$title = $PHPCMS['sitename'].$LANG['get_password_back'];
	$content = tpl_data($mod, 'getpassword_mailcheck');

	require PHPCMS_ROOT.'/include/mail.inc.php';
	sendmail($email, $title, stripslashes($content));

    include template($mod, 'getpassword');
}
elseif($step == 4)
{
	if(is_badword($username)) showmessage($LANG['username_not_accord_with_critizen']);
	$authstr = trim($authstr);
    if(strlen($authstr) != 32) showmessage($LANG['verify_string_not_correct']);

	if(!$member->check_authstr($username, $authstr)) showmessage($LANG['verify_string_not_correct']);

    include template($mod, 'getpassword');
}
elseif($step == 5)
{
	if(is_badword($username)) showmessage($LANG['username_not_accord_with_critizen']);
	$authstr = trim($authstr);
    if(strlen($authstr) != 32) showmessage($LANG['verify_string_not_correct']);

	if(strlen($password)<4 || strlen($password)>20) showmessage($LANG['password_not_less_than_4_longer_than_20']);
    $password = md5($password);
    
	$r = $db->query("UPDATE ".TABLE_MEMBER." SET password='$password' WHERE username='$username' AND authstr='$authstr' ");
	$member->make_authstr($username);
	$db->affected_rows()==1 ? showmessage($LANG['new_password_set_success'], $MOD['linkurl'].'login.php') : showmessage($LANG['new_password_set_fail'], $MOD['linkurl'].'login.php');
}
?>