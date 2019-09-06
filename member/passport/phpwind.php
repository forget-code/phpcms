<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if(!$forward) $forward = $PHP_REFERER ? $PHP_REFERER : $PHP_SITEURL;
$passport_key = $PHPCMS['passport_key'];
$userdb = array();
if(strpos($PHPCMS['passport_url'], ',') !== FALSE)
{
	$clienturl = explode(',', $PHPCMS['passport_url']);
	$jumpurl = array_shift($clienturl);
	$userdb['url'] = implode(',', $clienturl);
}
else
{
	$jumpurl = $PHPCMS['passport_url'];
}

$m = $db->get_one("SELECT m.userid,m.username,m.password,m.email,m.money,m.credit FROM ".TABLE_MEMBER." as m LEFT JOIN ".TABLE_MEMBER_INFO." as i on (m.userid=i.userid) WHERE m.userid='$userid'");

$userdb['uid']		= $m['uid'];
$userdb['username']	= $m['username'];
$userdb['password']	= $m['password'];
$userdb['email']	= $m['email'];
$userdb['money']	= $m['money'];
$userdb['credit']	= $m['credit'];
$userdb['time']		= $PHP_TIME;
$userdb['cktime']	= $cookietime > 0 ? ($PHP_TIME + $cookietime) : 0;

$userdb_encode = '';
foreach($userdb as $key=>$val)
{
	$userdb_encode .= $userdb_encode ? "&$key=$val" : "$key=$val";
}
$db_hash = $passport_key;
$userdb_encode = str_replace('=', '', StrCode($userdb_encode));

if(substr($jumpurl, -1, 1) != '/') $jumpurl .= '/';
if($action=='login')
{
	$verify = md5("login$userdb_encode$forward$passport_key");
	$url = $jumpurl."passport_client.php?action=login&userdb=".rawurlencode($userdb_encode)."&forward=".rawurlencode($forward)."&verify=".rawurlencode($verify);
}
elseif($action=='logout')
{
	$verify = md5("quit$userdb_encode$forward$passport_key");
    $url = $jumpurl."passport_client.php?action=quit&userdb=".rawurlencode($userdb_encode)."&forward=".rawurlencode($forward)."&verify=".rawurlencode($verify);
}

function StrCode($string,$action='ENCODE')
{
	$key	= substr(md5($_SERVER["HTTP_USER_AGENT"].$GLOBALS['db_hash']),8,18);
	$string	= $action == 'ENCODE' ? $string : base64_decode($string);
	$len	= strlen($key);
	$code	= '';
	for($i=0; $i<strlen($string); $i++)
	{
		$k		= $i % $len;
		$code  .= $string[$i] ^ $key[$k];
	}
	$code = $action == 'DECODE' ? $code : base64_encode($code);
	return $code;
}
?>