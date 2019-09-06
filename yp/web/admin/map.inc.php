<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET templateid='$tpl'");
	createhtml('index',PHPCMS_ROOT.'/yp/web');
	createhtml('introduce',PHPCMS_ROOT.'/yp/web');
	showmessage($LANG['operation_success'],$forward);
}
elseif($action=='update')
{
	$map = $x.'|'.$y.'|'.$z;
	$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET map='$map' WHERE username='$_username'");
	createhtml('introduce',PHPCMS_ROOT.'/yp/web');
	echo 1;
}
else
{
	@extract($db->get_one("SELECT map FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"));
	if($map!='')
	{
		$maps = explode('|',$map);
		$x = $maps[0];
		$y = $maps[1];
		$z = $maps[2];
	}
	include managetpl('map');
}
?>