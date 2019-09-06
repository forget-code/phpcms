<?php 
require './include/common.inc.php';
if(isset($auth))
{
	$type=1;
	$code = $auth;
}
else if(isset($drawback))
{
	$type=2;
	$code = $drawback;
}
else
{
	showmessage($LANG['illegal_parameters'],"goback");
}

$authkey = $PHPCMS['authkey'] ? $PHPCMS['authkey'] : 'PHPCMS';
$code = phpcms_auth($code, 'DECODE', $authkey);
$email_time = explode('|',$code);
if(count($email_time)!=2) showmessage($LANG['illegal_parameters'],"goback");
else 
{
	$email = $email_time[0];
	$time = $email_time[1];
	if(comparetime($time)) showmessage($LANG['out_of_30_days'],"goback");
	else 
	{
		if($type == 1) //激活
		{
			$query = "UPDATE ".TABLE_MAIL_EMAIL." SET authcode='' WHERE email='$email'";
			$db->query($query);
			showmessage($LANG['operation_success_email_activation'],"goback");
		}
		else if($type==2) //退订
		{
			$query = "DELETE FROM ".TABLE_MAIL_EMAIL." WHERE email='$email'";
			$db->query($query);
			showmessage($LANG['peration_success_email_out'],"goback");
		}
	}	
}
?>