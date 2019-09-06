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
require_once("common.php");

if($submit)
{
	if($_PHPCMS['gbook_checkuser'] && !$_userid)
	{
		message('抱歉！本站禁止游客留言！','goback');
	}
	if($_PHPCMS['gbook_checkcode'] && getcookie('randomstr')!=$checkcode)
	{
		message('验证码不正确！','goback');
	}
	if($gender!=0 && $gender!=1)
	{
		message('参数错误！','goback'); 
	}
	if(strlen($username)>20 || strlen($email)>50 || strlen($homepage)>255)
	{
		message('参数错误！','goback');
	}
	if(strlen($content)>$_PHPCMS['gbook_maxcontent'])
	{
		message('留言内容最多'.$_PHPCMS['gbook_maxcontent'].'个字符！','goback'); 
	}
	if(empty($username))
	{
		message('请输入姓名！','goback');
	}
	if(empty($title))
	{
		message('请输入留言主题！','goback');
	}
	if(empty($content))
	{
		message('请输入留言内容');
	}
	if($hidden!=0 && $hidden!=1)
	{
		message('参数错误！','goback'); 
	}

	$username = $_username ? $_username : $username;
	$inputstring=dhtmlspecialchars(array('title'=>$title,'username'=>$username,'gender'=>$gender,'head'=>$headimg,'email'=>$email,'homepage'=>$homepage,'hidden'=>$hidden));
	extract($inputstring,EXTR_OVERWRITE);
	$content = $_PHPCMS['gbook_usehtml'] ? str_safe($content) : htmlspecialchars($content);
	if($_PHPCMS['gbook_checkpass'])
	{
		$passed=0;
		$message="留言发表成功！请等待管理员审核！";
	}
	else
	{
		$passed=1;
		$message="留言发表成功！";
	}

	$query = "insert into ".TABLE_GUESTBOOK."(channelid,title,content,username,gender,head,email,qq,homepage,hidden,addtime,passed,ip) values('$channelid','$title','$content','$_username','$gender','$head','$email','$qq','$homepage','$hidden','$timestamp','$passed','$PHP_IP')";
	$db->query($query);
	if($db->affected_rows()>0)
	{
		message($message,"./index.php?channelid=".$channelid);
	}
	else
	{
		message('留言发表失败！请联系管理员！','goback');
	}
}
else
{
	$meta_title = "签写留言";
	include template("guestbook","add"); 
}
?>