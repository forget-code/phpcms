<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/
defined('IN_PHPCMS') or exit('Access Denied');
include PHPCMS_ROOT."/module/article/common.php";
$head[title]=$keywords ? $keywords : "站内投稿";
$head[keywords]=$keywords ? $keywords : "站内投稿";
$head[description]=$keywords ? $keywords : "站内投稿";
$channelid = $_CHA[channelid];
//if(!$enablecontribute)
//{
//	message('对不起，本站不允许投稿！','goback'); 
//}


if($_userid)
{
	header('Location: '.PHPCMS_PATH.'member/myitem.php?module=article&channelid='.$channelid.'&action=add');
}
if(!$submit)
{
	$cat_select = cat_select('catid','请选择栏目',$catid);
	$special_select = special_select($channelid,'specialid',$specialid);
	include template('article','contribute');
	copyright($version);
}
else
{
	if($_PHPCMS['checkcodecontribute'] && getcookie('randomstr')!=$checkcode)
	{
		message('验证码不正确！','goback');
	}
	if(!preg_match('/^[0-9]+$/',$catid) || !preg_match('/^[0-9]+$/',$specialid))
	{
		message('参数错误！','goback'); 
	}
	if(!intval($catid))
	{
		message('请选择栏目！','goback');
	}
	if(!$_CAT[$catid][enableadd])
	{
		message('指定栏目不允许投稿，请返回！','goback');
	}
	if(empty($title))
	{
		message('请输入标题！','goback');
	}
	if(empty($content))
	{
		message('请输入内容！','goback');
	}

	if(strlen($catid)>11 || strlen($specialid)>11 || strlen($title)>100 || strlen($description)>1000 || strlen($keywords)>255 || strlen($author)>20 || strlen($authoremail)>50 || strlen($copyfromname)>20 || strlen($copyfromurl)>255 || strlen($content)>100000 || strlen($savepathfilename)>1000 || strlen($thumb)>255)
	{
		message('参数错误！','goback');
	}
	$inputstring=dhtmlspecialchars(array('title'=>$title,'keywords'=>$keywords,'author'=>$author,'authoremail'=>$authoremail,'copyfromname'=>$copyfromname,'copyfromurl'=>$copyfromurl,'savepathfilename'=>$savepathfilename,'thumb'=>$thumb));
	extract($inputstring,EXTR_OVERWRITE);
	$description = str_safe($description);
	$content = str_safe($content);

	if($_PHPCMS['articlecheck'])
	{
		$status=1;
		$message="文章发表成功！请等待管理员审核！";
	}
	else
	{
		$status=3;
		$message="文章发表成功！";
	}
	$db->query("insert into ".TABLE_ARTICLE."(catid,specialid,title,description,keywords,author,authoremail,copyfromname,copyfromurl,content,savepathfilename,thumb,status,username,addtime) values('$catid','$specialid','$title','$description','$keywords','$author','$authoremail','$copyfromname','$copyfromurl','$content','$savepathfilename','$thumb','$status','$_username','$timestamp')");
	message($message,'contribute.php');	
}
?>