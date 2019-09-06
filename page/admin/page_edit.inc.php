<?php
defined('IN_PHPCMS') or exit('Access Denied');
$pageid = isset($pageid) ? intval($pageid) : 0;
$pageid or showmessage($LANG['page_id_not_null']);
if($dosubmit)
{
	if(empty($title))  showmessage($LANG['title_not_null_return']);
	if(!$linkurl && empty($content)) showmessage($LANG['link_and_content_not_null']);
	if(!$linkurl)
	{
		if(empty($fpath) || empty($fname)) showmessage($LANG['deposit_path_or_filename_not_null']);
		if(!preg_match("/^[0-9a-z\/]+$/i", $fpath)) showmessage($LANG['illegal_deposit_path']);
		if(!preg_match("/^[0-9a-z\_]+\.[a-z]{3,}$/i", $fname)) showmessage($LANG['illegal_filename']);
		$filepath = $fpath.$fname;
		$r = $db->get_one("select pageid from ".TABLE_PAGE." where filepath='$filepath' and pageid!=$pageid ");//
		if($r['pageid']) showmessage($LANG['filename_exist_return']);
		if($oldpath) unlink(PHPCMS_ROOT.'/'.$oldpath);
		$query = "UPDATE ".TABLE_PAGE." SET title='$title',username='$_username',linkurl='',seo_title='$seo_title',seo_keywords='$seo_keywords',seo_description='$seo_description',content='$content',templateid='$templateid',skinid='$skinid',filepath='$filepath',edittime='$PHP_TIME' WHERE pageid=$pageid AND keyid='$keyid'";
	}
	else
	{
		$query = "UPDATE ".TABLE_PAGE." SET title='$title',linkurl='$linkurl',edittime='$PHP_TIME',username='$_username' WHERE pageid=$pageid AND keyid='$keyid'";
	}
	$db->query($query);
	if(!$linkurl) createhtml('page');
	showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=manage&keyid='.$keyid);
}
else
{
	$r = $db->get_one("select * from ".TABLE_PAGE." where pageid=$pageid and keyid='$keyid' ");
	if(!$r['pageid']) showmessage($LANG['appoint_page_not_exist_or_no_permission']);
	extract($r);
	$showskin = showskin('skinid', $skinid);
	$showtpl = showtpl($mod, 'page', 'templateid', $templateid);
	$fpath = $filepath ? dirname($filepath).'/' : '';
	$fname = $filepath ? basename($filepath) : '';
	include admintpl('page_edit');
}
?>