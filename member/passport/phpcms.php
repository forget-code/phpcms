<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$member_columns = array('username', 'password', 'question', 'answer', 'email', 'showemail', 'groupid', 'regip', 'regtime', 'truename', 'gender', 'birthday', 'province', 'city', 'area', 'telephone', 'mobile', 'address', 'postid', 'homepage', 'qq', 'msn', 'icq', 'skype', 'alipay', 'paypal');

if(!$forward) $forward = $PHP_REFERER ? $PHP_REFERER : $PHP_SITEURL;
$passport_key = $PHPCMS['passport_key'];

if(!is_array($info)) $info = array();
$member = array_filter($info);
if(strpos($PHPCMS['passport_url'], ',') !== FALSE)
{
	$clienturl = explode(',', $PHPCMS['passport_url']);
	$jumpurl = array_shift($clienturl);
	$member['url'] = implode(',', $clienturl);
}
else
{
	$jumpurl = $PHPCMS['passport_url'];
}
$member_encode = '';
foreach($member as $key=>$val)
{
	if($key == 'url' || in_array($key, $member_columns)) $member_encode .= "&$key=$val";
}
$txt = 'time='.$PHP_TIME.'&cookietime='.$cookietime.$member_encode;

if($action == 'login')
{
	$auth = phpcms_auth($txt, 'ENCODE', $PHPCMS['passport_key']);
	$verify = md5('login'.$auth.$forward.$PHPCMS['passport_key']);
	$url = $jumpurl.'/member/api/phpcms.php?action=login&auth='.urlencode($auth).'&forward='.urlencode($forward).'&verify='.$verify;
}
elseif($action == 'logout')
{
	$auth = phpcms_auth($txt, 'ENCODE', $PHPCMS['passport_key']);
	$verify = md5('logout'.$auth.$forward.$PHPCMS['passport_key']);
	$url = $jumpurl.'/member/api/phpcms.php?action=logout&auth='.urlencode($auth).'&forward='.urlencode($forward).'&verify='.$verify;
}
?>