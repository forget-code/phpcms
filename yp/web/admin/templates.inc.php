<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET templateid='$tpl' WHERE username='$_username'");
	
	if($backgroundmode == 1)
	{
		$background = $backgroundmode.'|'.$background;
	}
	elseif($backgroundmode == 2)
	{
		$background = $backgroundmode.'|'.$color;
	}
	else
	{
		$background = '';
	}
	$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET background = '$background' WHERE username='$_username'");
	createhtml('index',PHPCMS_ROOT.'/yp/web');
	createhtml('introduce',PHPCMS_ROOT.'/yp/web');
	$forward = "?file=cache&action=article,product,buy,sales,job";
	showmessage($LANG['operation_success'],$forward);
}
else
{
	@extract($db->get_one("SELECT background FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"));
	$backgroundcolor = '#000000';
	$backgroundimg = '';
	if($background != '')
	{
		$arraybackground = explode('|',$background);
		$backgroundmode = $arraybackground[0];
		if($background == 1) $backgroundimg = $arraybackground[1];
		if($background == 2) $backgroundcolor = $arraybackground[1];
	}
	else
	{
		$backgroundmode = 0;
	}
	include managetpl('companytpl');
}
?>