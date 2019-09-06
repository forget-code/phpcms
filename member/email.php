<?php
require './include/common.inc.php';
if(!isset($forward)) $forward = HTTP_REFERER;
if(!$M['enablemailcheck']) showmessage('没有开启邮件验证', $forward);

if($dosubmit)
{
		if(!$member->is_username($username)) showmessage($member->msg());
		if(!is_email($email)) showmessage($LANG['input_valid_email']);
		$userid = $member->match_user_email($username, $email);
		if(!$userid) showmessage($member->msg());
		if(!class_exists('sendmail'))
		{
			$sendmail = load('sendmail.class.php');
		}
		$memberinfo = array('username'=>$username);
		$authstr = $member->make_authcode($memberinfo);
		$title = $PHPCMS['sitename'].$LANG['member_register_email_verify'];
		$authurl = SITE_URL.$M['url']."register.php?action=activate&userid=$userid&authcode=$authstr";
		$content = tpl_data($mod, 'register_mailcheck');
		$sendmail->send($email, $title, stripslashes($content), $PHPCMS['mail_user']);
		showmessage($LANG['profile_post_success'], $forward);
}
else 
{
	include template('member', 'email');
}
?>