<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	$mypageid or showmessage($LANG['illegal_parameters']);
	$seo_title or showmessage($LANG['name_null']);
	$db->query("UPDATE ".TABLE_MYPAGE." SET seo_title='$seo_title',seo_keywords='$seo_keywords',seo_description='$seo_description',templateid='$templateid',skinid='$skinid' WHERE mypageid='$mypageid'");

	showmessage($LANG['operation_success'],"?mod=".$mod."&file=".$file."&action=manage");
}
else
{
	$mypageid or showmessage($LANG['illegal_parameters']);
	@extract($db->get_one("select * from ".TABLE_MYPAGE." where mypageid='$mypageid'"));
	$name or showmessage($LANG['page_not_exists']);
	$showskin = showskin('skinid',$skinid);
	$showtpl = showtpl($mod,'mypage','templateid',$templateid);
	include admintpl('mypage_edit');
}
?>