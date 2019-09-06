<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$db_hash = $PHPCMS['passport_key'];

if($action == 'login')
{
	$cktime = $_cookietime > 0 ? ($PHP_TIME + $_cookietime) : 0;
	$txt = "time=$PHP_TIME&cktime=$cktime&username=$username&password=$password&email=$email";
	$userdb = StrCode($txt, 'ENCODE');
	$verify = md5($action.$userdb.$forward.$PHPCMS['passport_key']);
	$url = $PHPCMS['passport_url'].'?action=login&userdb='.urlencode($userdb).'&forward='.urlencode($forward).'&verify='.$verify;
}
elseif($action == 'logout')
{
	$userdb = StrCode('', 'ENCODE');
	$verify = md5('quit'.$userdb.$forward.$PHPCMS['passport_key']);
	$url = $PHPCMS['passport_url'].'?action=quit&userdb='.urlencode($userdb).'&forward='.urlencode($forward).'&verify='.$verify;
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