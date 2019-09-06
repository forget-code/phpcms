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
require "common.php";

require PHPCMS_ROOT."/include/ubb.php";

$pagesize= $_PHPCMS['pagesize'] ? $_PHPCMS['pagesize'] : 20;

$referer = $referer ? $referer : PHPCMS_PATH."link/?channelid=".$channelid;

switch($action){

case 'reg':

	if(!preg_match('/^[01]$/',$linktype))
	{
		message('参数错误！',"goback"); 
	}
	if($linktype==1 && (empty($logo) || $logo=='http://'))
	{
		message('你申请的是logo链接，请填写网站logo！',"goback");
	}
	if(empty($name))
	{
		message("请输入网站名称！","goback");
	}
	if(empty($url) || $url=='http://')
	{
		message("请输入网站地址！","goback");
	}
	if(empty($username))
	{
		message("请输入站长名称！","goback");
	}
	if(!is_email($email))
	{
		message("邮件格式不对！","goback");
	}
	if(empty($password))
	{
		message("请输入密码！","goback");
	}
	if($password != $pwdconfirm)
	{
		message("两次输入的密码不一致！","goback");
	}
	if($introduction=='网站简介：')
	{
		message("请输入网站简介！","goback");
	}
	$username = $_username ? $_username : $username;
	$inputstring=dhtmlspecialchars(array('linktype'=>$linktype,'name'=>$name,'url'=>$url,'logo'=>$logo,'introduction'=>$introduction,'username'=>$username,'email'=>$email,'password'=>$password));
	@extract($inputstring,EXTR_OVERWRITE);

	$password=md5($password);

	$db->query("insert into ".TABLE_LINK." (linktype,name,url,logo,introduction,username,email,password,passed,addtime) values('$linktype','$name','$url','$logo','$introduction','$username','$email','$password','0','$timestamp')");
	if($db->affected_rows()>0)
	{
		$siteid = $db->insert_id();
        $db->query("update ".TABLE_LINK." set `orderid`=$siteid where siteid=$siteid");
		message("友情链接申请成功！请等待管理员审批！",$referer);
	}
	else
	{
		message("友情链接申请失败！请联系管理员！","goback");
	}

break;

case 'edit':

	if(empty($username))
	{
		message("请输入站长名称！","goback");
	}
	if(empty($password))
	{
		message("请输入密码！","goback");
	}
	if(!preg_match('/^[01]$/',$linktype))
	{
		message('参数错误！',"goback"); 
	}
	if($linktype==1 && (empty($logo) || $logo=='http://'))
	{
		message('你修改的是logo链接，请填写网站logo！',"goback");
	}
	if(empty($name))
	{
		message("请输入网站名称！","goback");
	}
	if(empty($url) || $url=='http://')
	{
		message("请输入网站地址！","goback");
	}
	if($introduction=='网站简介：')
	{
		message("请输入网站简介！","goback");
	}
	$inputstring=dhtmlspecialchars(array('linktype'=>$linktype,'name'=>$name,'url'=>$url,'logo'=>$logo,'introduction'=>$introduction,'username'=>$username,'email'=>$email,'password'=>$password));
	@extract($inputstring,EXTR_OVERWRITE);

	$password=md5($password);

	$r = $db->get_one("select name from ".TABLE_LINK." where username='$username' and password='$password' limit 0,1");
	if(!$r[name])
	{
		message("抱歉！无法修改！请检查用户名和密码！","goback");
	}
	else
	{
		$db->query("update ".TABLE_LINK." set linktype='$linktype',name='$name',url='$url',logo='$logo',introduction='$introduction',passed=0 where name='$r[name]'");
		message("友情链接修改成功！请等待管理员审批！",$referer);
	}

break;

default:
    $page = intval($page);
    $page = $page>0 ? $page : 1;
	$logo = preg_match("/http:\/\//",$_PHPCMS['logo']) ? $_PHPCMS['logo'] : "http://".$PHP_DOMAIN."/".$_PHPCMS['logo'];

	$meta_title = $_CHA['channelname']."友情链接";
	$meta_keywords = $_CHA['meta_keywords'].",友情链接";
	$meta_description = $_CHA['meta_description'];

	include template('link','link');
}
?>