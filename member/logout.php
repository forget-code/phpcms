<?php
require './include/common.inc.php';

if(!isset($action)) $action = '';

if($action == 'ajax_message')
{
	echo $LANG['logout_success'];
	exit;
}

$member->logout();

if($PHPCMS['enablepassport'])
{
	if($action == 'logout_ajax')
	{
		$forward = linkurl($MOD['linkurl'], 1).'logout.php?action=ajax_message';
	}
	else
	{
		$forward = isset($forward) ? linkurl($forward, 1) : $PHP_SITEURL;
	}
	$action = 'logout';
	require MOD_ROOT.'/passport/'.$PHPCMS['passport_file'].'.php';
	header('location:'.$url);
	exit;
}

if($action == 'logout_ajax')
{
	echo $LANG['logout_success'];
	exit;
}

if(!$forward) $forward = $PHP_SITEURL;
showmessage($LANG['logout_success'], $forward);
?>