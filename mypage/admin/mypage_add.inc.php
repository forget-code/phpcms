<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	if(!preg_match("/^[0-9a-z_]+$/i",$name)) showmessage("<font color='red'>".$LANG['bad_name']."</font>");
	if(!$seo_title) showmessage($LANG['name_null']);

	$r = $db->get_one("SELECT * FROM ".TABLE_MYPAGE." WHERE name='$name'");
	if($r['name']) showmessage("<font color='red'>".$LANG['name_exists']."</font>");

	$db->query("INSERT INTO ".TABLE_MYPAGE." (name,seo_title,seo_keywords,seo_description,templateid,skinid) VALUES ('$name','$seo_title','$seo_keywords','$seo_description','$templateid','$skinid')");

	showmessage($LANG['operation_success'],"?mod=".$mod."&file=".$file."&action=manage");
}
else
{
	$showskin = showskin('skinid');
	$showtpl = showtpl($mod,'mypage','templateid');
	include admintpl('mypage_add');
}
?>