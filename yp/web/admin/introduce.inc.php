<?php 
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET introduce = '$introduce' WHERE username='$_username'");
	$templateid = $tplType.'-introduce';
	extract($db->get_one("SELECT banner,background FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"));
	if($background)
	{
		$backgrounds = explode('|',$background);
		$backgroundtype = $backgrounds[0];
		$background = $backgrounds[1];
	}
	createhtml('header',PHPCMS_ROOT.'/yp/web');
	createhtml('introduce',PHPCMS_ROOT.'/yp/web');
	createhtml('index',PHPCMS_ROOT.'/yp/web');
	showmessage($LANG['operation_success']);	
}
else
{
	@extract($db->get_one("SELECT username,introduce FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"));
	include managetpl('introduce');
}
?>