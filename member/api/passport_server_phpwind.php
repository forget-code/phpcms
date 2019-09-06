<?php 
defined('IN_PHPCMS') or exit('Access Denied');
if(!$forward) $forward = HTTP_REFERER ? HTTP_REFERER : SITE_URL;
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

if(!$userid) $userid = $member->get_userid($username);
$m = $member->get($userid, 'm.userid, m.username, m.password, m.email, m.amount, m.point', 1);

$userdb['uid']		= $m['userid'];
$userdb['username']	= $m['username'];
$userdb['password']	= $password;
$userdb['email']	= $m['email'];
$userdb['money']	= $m['amount'];
$userdb['credit']	= $m['point'];
$userdb['time']		= TIME;
$userdb['cktime']	= $cookietime > 0 ? (TIME + $cookietime) : 0;

$userdb_encode = '';
foreach($userdb as $key=>$val)
{
	$userdb_encode .= $userdb_encode ? "&$key=$val" : "$key=$val";
}

$db_hash = $passport_key;
$userdb_encode = str_replace('=', '', StrCode($userdb_encode));

if(substr($jumpurl, -1, 1) != '/') $jumpurl .= '/';

if($action=='login' || $action=='register')
{
	if($action == 'register')
	{
		if($memberinfo['modelid'] && $M['choosemodel'] && !$M['enablemailcheck'] && !$M['enableadmincheck'])
		{
			$result = $member->login($username, $memberinfo['password']);
			$forward = $PHPCMS['siteurl'].'member/register_model.php';
		}
	}
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