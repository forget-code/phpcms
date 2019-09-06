<?php 
require './include/common.inc.php';

$logo = preg_match("/http:\/\//",$PHPCMS['logo']) ? $PHPCMS['logo'] : "http://".$PHP_DOMAIN."/".$PHPCMS['logo'];

$head['title'] = $LANG['mailsubscription'];
$head['keywords'] = $LANG['mail_email_subscription'];
$head['description'] = $LANG['mailsubscription_system'];

$TYPE = cache_read('type_'.$mod.'.php');
$useremail = $_userid ? $_email : '@';

if($dosubmit)
{
	if(!$cktypeid)
	{
		$cktypeid = $TYPE;
	}
	if(!is_email($email))
	{
		showmessage($LANG['input_valid_email'],"goback");
	}
	if($db->get_one("SELECT email FROM ".TABLE_MAIL_EMAIL." WHERE email='$email' limit 1"))
	{
		showmessage($LANG['have_subscription'],"goback");
	}
	$typeids = ',';
	foreach($cktypeid as $k=>$typeid)
	{
		$typeids.=$k.',';
	}
	$authkey = $PHPCMS['authkey'] ? $PHPCMS['authkey'] : 'PHPCMS';
	$auth = urlencode(phpcms_auth("$email|$PHP_TIME", 'ENCODE', $authkey));
	$authurl = $PHP_SITEURL.'/mail/auth.php?auth='.$auth;
	ob_start();
	include template($mod,'mailtpl');
	$data = ob_get_contents();
	ob_clean();
	
	if(sendmail($email,$PHPCMS['sitename'].$LANG['mailsubscription_active'],stripslashes($data)))
	{
		$query = "insert into ".TABLE_MAIL_EMAIL." (email,username,typeids,ip,addtime,disabled,authcode)".
				" VALUES('$email','$_username','$typeids','$PHP_IP','$PHP_TIME','0','$auth')";
		$db->query($query);
		showmessage($LANG['subscription_success_send_a_mail_to'].$email.$LANG['30_days_active_this_subscription'],'goback');
	}
	else 
	{
		showmessage($LANG['send_active_mail_fail'],'goback');
	}
}
else if(isset($dologout))
{
	if(!is_email($email))
	{
		showmessage($LANG['input_valid_email'],"goback");
	}
	if(!$db->get_one("SELECT email FROM ".TABLE_MAIL_EMAIL." WHERE email='$email' limit 1"))
	{
		showmessage($LANG['not_exist_mail_in_our_maillist'],"goback");
	}
	$authkey = $PHPCMS['authkey'] ? $PHPCMS['authkey'] : 'PHPCMS';
	$auth = urlencode(phpcms_auth("$email|$PHP_TIME", 'ENCODE', $authkey));
	$authurl = $PHP_SITEURL.'/mail/auth.php?drawback='.$auth;
	ob_start();
	include template($mod,'mailtpl');
	$data = ob_get_contents();
	ob_clean();
	
	if(sendmail($email,$PHPCMS['sitename'].$LANG['mail_subscription_checkcode'],stripslashes($data)))
	{
		showmessage($LANG['send_countermand_mail_success'].$email.$LANG['30_day_cancel_subscription'],'goback');
	}
	else 
	{
		showmessage($LANG['mailsubscription_cancel_mail_fail'],'goback');
	}	
	
}


include template($mod,"subscription");
?>