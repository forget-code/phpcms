<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function quescrypt($questionid, $answer)
{
	return $questionid > 0 && $answer != '' ? substr(md5($answer.md5($questionid)), 16, 8) : '';
}
$PHPCMS['passport_key'] = trim($PHPCMS['passport_key']);
if($action == 'login')
{
	$isadmin = ($groupid == 1) ? 1 : 0;
	if($gender==0)	$gender = 2;
	$txt = "time=".TIME."&cookietime=$cookietime&groupid=$groupid&secques=".quescrypt(1,'phpcms')."&username=$username&password=$password&secques=".quescrypt(1,'phpcms')."&gender=$gender&email=$email&isadmin=$isadmin&regip=$regip&regdate=$regtime";
	$auth = passport_encrypt($txt, $PHPCMS['passport_key']);
	$verify = md5('login'.$auth.$forward.$PHPCMS['passport_key']);
	$url = $PHPCMS['passport_url'].'?action=login&auth='.urlencode($auth).'&forward='.urlencode($forward).'&verify='.$verify;
}
elseif($action == 'logout')
{
	$auth = passport_encrypt('', $PHPCMS['passport_key']);
	$verify = md5('logout'.$auth.$forward.trim($PHPCMS['passport_key']));
	$url = $PHPCMS['passport_url'].'?action=logout&auth='.urlencode($auth).'&forward='.urlencode($forward).'&verify='.$verify;
}

function passport_encrypt($txt, $key) {
	srand((double)microtime() * 1000000);
	$encrypt_key = md5(rand(0, 32000));
	$ctr = 0;
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
	}
	return base64_encode(passport_key($tmp, $key));
}

function passport_decrypt($txt, $key) {
	$txt = passport_key(base64_decode($txt), $key);
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
		$md5 = $txt[$i];
		$tmp .= $txt[++$i] ^ $md5;
	}
	return $tmp;
}

function passport_key($txt, $encrypt_key) {
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}
?>