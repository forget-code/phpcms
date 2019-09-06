<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if(!$forward) $forward = HTTP_REFERER ? HTTP_REFERER : SITE_URL;
$passport_key = $PHPCMS['passport_key'];

$arr_member = $member->get($userid, '*', 1);
if(strpos($PHPCMS['passport_url'], ',') !== FALSE)
{
	$clienturl = explode(',', $PHPCMS['passport_url']);
	$jumpurl = array_shift($clienturl);
	$arr_member['url'] = implode(',', $clienturl);
}
else
{
	$jumpurl = $PHPCMS['passport_url'];
}

$member_encode = '';

foreach($arr_member as $key=>$val)
{
	$userdb_encode .= $userdb_encode ? "&$key=$val" : "$key=$val";
}
$userdb_encode .= '&time='.TIME.'&cktime='.$cookietime;

$auth = phpcms_auth($userdb_encode, 'ENCODE', $PHPCMS['passport_key']);
if($action == 'login')
{
	
	$verify = md5('login'.$auth.$forward.$PHPCMS['passport_key']);
	$url = $jumpurl.'member/api/passport_client.php?action=login&userdb='.urlencode($auth).'&forward='.urlencode($forward).'&verify='.$verify;
}
elseif($action == 'logout')
{
	$verify = md5('logout'.$auth.$forward.$PHPCMS['passport_key']);
	$url = $jumpurl.'member/api/passport_client.php?action=logout&userdb='.urlencode($auth).'&forward='.urlencode($forward).'&verify='.$verify;
}
?>