<?php
require './include/common.inc.php';
if(!$forward) $forward = HTTP_REFERER;
if($PHPCMS['enableserverpassport'])
{
	$verify = substr(md5($PHPCMS['passport_serverkey']),0,8);
	$logouturl = $PHPCMS['passport_serverurl'].$PHPCMS['passport_logouturl'];
	$addstr = QUERY_STRING ? QUERY_STRING : '';
	$logouturl .= (strpos($logouturl, '?') ? '&' : '?').$addstr.'&verify='.$verify;
	header('location:'.$logouturl);
	exit;
}

if(!isset($action)) $action = '';

$member->logout();

if($PHPCMS['enablepassport'])
{
	if($action == 'logout_ajax')
	{
		$forward = url($M['url'], 1).'logout.php?action=ajax_message';
	}
	else
	{
		$forward = isset($forward) ? url($forward, 1) : SITE_URL;
	}
	$action = 'logout';
	require MOD_ROOT.'api/passport_server_'.$PHPCMS['passport_file'].'.php';
	header('location:'.$url);
	exit;
}

if($action == 'ajax')
{
	if($PHPCMS['uc'])
	{
		$action = 'logout';
		require MOD_ROOT.'api/passport_server_ucenter.php';
	}
	echo 1;
	exit;
}
elseif($PHPCMS['uc'])
{
	$action = 'logout';
	require MOD_ROOT.'api/passport_server_ucenter.php';
}

if(!$forward) $forward = SITE_URL;
showmessage($LANG['logout_success'].$ucsynlogout, $forward);
?>