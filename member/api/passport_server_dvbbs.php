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

$m = $member->get($userid, 'm.userid, m.username, m.password, m.email, m.amount, m.point', 1);

$userinfo['uid']		= $m['userid'];
$userinfo['username']	= $m['username'];
$userinfo['password']	= $m['password'];
$userinfo['email']	= $m['email'];
$userinfo['money']	= $m['amount'];
$userinfo['credit']	= $m['point'];
$userinfo['time']		= TIME;
$userinfo['cktime']	= $cookietime > 0 ? (TIME + $cookietime) : 0;
$userdb_encode = '';
foreach($userinfo as $key=>$val)
{
	$userdb_encode .= $userdb_encode ? "&$key=$val" : "$key=$val";
}

$db_hash = md5($passport_key);
$userdb_encode = strCode($userdb_encode, $db_hash);

if(substr($jumpurl, -1, 1) != '/') $jumpurl .= '/';
if($action=='login')
{
	$verify = md5("login$userdb_encode$forward$passport_key");
	$url = $jumpurl."passport_client.php?action=login&userinfo=".$userdb_encode."&forward=".rawurlencode($forward)."&verify=".rawurlencode($verify);
}
elseif($action == 'logout')
{
	$verify = md5("logout$userdb_encode$forward$passport_key");
	$url = $jumpurl."passport_client.php?action=logout&userinfo=".$userdb_encode."&forward=".rawurlencode($forward)."&verify=".rawurlencode($verify);
}

function strCode($txt, $key)
{
	$code = '';
	$len = strlen($key);
	for($i=0; $i<strlen($txt); $i++)
	{
		$k		= $i % $len;
		$code  .= $txt[$i] ^ $key[$k];
	}
	return base64_encode($code);
}
?>