<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
if($PHP_DOMAIN && $PHP_REFERER && !preg_match("/".$PHP_DOMAIN."/i",$PHP_REFERER)) showmessage($LANG['content_from'].'<a href="'.$channelurl.'" >'.$channelurl.'</a> ,'.$LANG['enter_download']);
if(!isset($auth)) showmessage($LANG['illegal_parameters']);
$authkey = $PHPCMS['authkey'] ? $PHPCMS['authkey'] : 'PHPCMS';
$auth = phpcms_auth($auth, 'DECODE', $authkey);
parse_str($auth);
if(!isset($movieid)) showmessage($LANG['illegal_parameters']);
if(!isset($fileurl)) showmessage($LANG['illegal_parameters']);
if(!isset($starttime)) showmessage($LANG['illegal_parameters']);
if(!isset($ip)) showmessage($LANG['illegal_parameters']);
if(!isset($downurl)) showmessage($LANG['illegal_parameters']);
if(!$movieid || empty($fileurl) || !preg_match("/[0-9]{10}/", $starttime) || !preg_match("/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/", $ip) || $ip != $PHP_IP) showmessage($LANG['illegal_parameters']);
if($MOD['expire'])
{
	$endtime = $PHP_TIME - $starttime;
	if($endtime > $MOD['expire']*60) showmessage($LANG['url_spent']);
}
if($MOD['enable_virtualwall'])
{
	require MOD_ROOT.'/include/vsid.func.php';
	$fileurl = $fileurl.'?vsid='.getvsid();
}

header("Location: ".$downurl.$fileurl);

?>