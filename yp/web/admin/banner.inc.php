<?php 
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET banner = '$banner',logo = '$logo' WHERE companyid=$companyid");
	createhtml('header',PHPCMS_ROOT.'/yp/web');
	createhtml('index',PHPCMS_ROOT.'/yp/web');
	createhtml('introduce',PHPCMS_ROOT.'/yp/web');
	showmessage($LANG['operation_success'],$forward);
	
}
else
{
	@extract($db->get_one("SELECT banner,logo FROM ".TABLE_MEMBER_COMPANY." WHERE username='$_username'"));
	include managetpl('banner');
}
?>