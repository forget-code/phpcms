<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function quescrypt($questionid, $answer)
{
	return $questionid > 0 && $answer != '' ? substr(md5($answer.md5($questionid)), 16, 8) : '';
}

if($action == 'login')
{
	$isadmin = 0;
	if($groupid == 1)
	{
		$isadmin = 1;
		$a = $db->get_one("SELECT grade FROM ".TABLE_ADMIN." WHERE userid=$userid limit 0,1");
		if(!$a || $a['grade'] > 0) $isadmin = 0;
	}
	$txt = "time=$PHP_TIME&cookietime=$cookietime&username=$username&password=$password&secques=".quescrypt(1,'phpcms')."&gender=$gender&email=$email&isadmin=$isadmin&regip=$regip&regdate=$regtime&oicq=$qq&msn=$msn&showemail=$showemail&bday=$birthday&site=$homepage&location=".substr($address, 0, 30);
	$auth = phpcms_auth($txt, 'ENCODE', $PHPCMS['passport_key']);
	$verify = md5('login'.$auth.$forward.$PHPCMS['passport_key']);
	$url = $PHPCMS['passport_url'].'?action=login&auth='.urlencode($auth).'&forward='.urlencode($forward).'&verify='.$verify;
}
elseif($action == 'logout')
{
	$auth = phpcms_auth('', 'ENCODE', $PHPCMS['passport_key']);
	$verify = md5('logout'.$auth.$forward.$PHPCMS['passport_key']);
	$url = $PHPCMS['passport_url'].'?action=logout&auth='.urlencode($auth).'&forward='.urlencode($forward).'&verify='.$verify;
}
?>