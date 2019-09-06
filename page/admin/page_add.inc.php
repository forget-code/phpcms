<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	if(empty($title))  showmessage($LANG['title_not_null_return']);
	if(!$linkurl && empty($content)) showmessage($LANG['link_and_content_not_null']);
	if(!$linkurl)
	{
		if(empty($fpath) || empty($fname)) showmessage($LANG['deposit_path_or_filename_not_null']);
		if(!preg_match("/^[0-9a-z\/]+$/i", $fpath)) showmessage($LANG['illegal_deposit_path']);
		if(!preg_match("/^[0-9a-z\_]+\.[a-z]{3,}$/i", $fname)) showmessage($LANG['illegal_filename']);
		$fpath = $fpath.$fname;
		$r = $db->get_one("select pageid from ".TABLE_PAGE." where filepath='$fpath' ");
		if($r['pageid']) showmessage($LANG['filename_exist_return']);
		$query = "INSERT INTO ".TABLE_PAGE." (keyid,title,username,seo_title,seo_keywords,seo_description,content,templateid,skinid,addtime,filepath) VALUES ('$keyid','$title','$_username','$seo_title','$seo_keywords','$seo_description', '$content','$templateid','$skinid','$PHP_TIME','$fpath')";
	}
	else
	{
		$query = "INSERT INTO ".TABLE_PAGE." (keyid,title,username,linkurl,addtime) VALUES ('$keyid','$title','$_username','$linkurl','$PHP_TIME')";
	}
	$db->query($query);
	$pageid = $db->insert_id();
	if(!$linkurl) createhtml('page');
	showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=manage&keyid='.$keyid);
}
else
{
	$showskin = showskin('skinid');
	$showtpl = showtpl($mod, 'page', 'templateid');
	$r = $db->get_one("select max(pageid) as maxpageid from ".TABLE_PAGE." where 1 limit 0,1");
	$pageid = $r['maxpageid'] +1 ;
	$default_filepath = $mod.'/';
	$default_filename = $mod.'_'.$pageid.'.'.$PHPCMS['fileext'];
	include admintpl('page_add');
}
?>