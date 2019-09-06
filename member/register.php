<?php
/**
* 会员注册
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage member
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
require_once("common.php");

if($_userid) message("不可重复注册，您已经是注册用户了！","goback");

$referer = $referer ? $referer : ($forward ? $forward : $PHP_REFERER);

if($submit)
{
	if($_PHPCMS[enableregcheckcode] && getcookie('randomstr')!=$checkcode) message("验证码不正确！","goback");

	if(!is_username($username,2,30)) message("用户名不符合规范！","goback");
	if(strlen($password)<4 || strlen($password)>20) message("密码不得少于4个字符超过20个字符！","goback");
	if(!is_email($email)) message("请输入有效的E-mail地址！","goback");
	if(empty($question) || strlen($question)>50) message("请输入密码提示问题！","goback");
	if(empty($answer) || strlen($answer)>50) message("请输入密码提示问题答案！","goback");
	$gender = $gender==1 ? 1 : 0;
	$showemail = $showemail==1 ? 1 : 0;
	$byear = intval($byear);
	$byear = $byear==19 ? '0000' : $byear;
	$bmonth = intval($bmonth);
	$bday = intval($bday);

	$birthday = $byear."-".$bmonth."-".$bday;
	if(!is_date($birthday)) $birthday = "0000-00-00";

    if($msn && !is_email($msn)) message("请输入有效的MSN地址！","goback");
	if(!empty($qq) && (!is_numeric($qq) || strlen($qq)>20 || strlen($qq)<5)){
		  message("请输入正确的QQ号！","goback");
	}
	if(!empty($postid) && (!is_numeric($postid) || strlen($postid)!=6)){
		  message("请输入正确的邮编！","goback");
	}
	if(strlen($truename)>50 || strlen($telephone)>50 || strlen($address)>255 || strlen($homepage)>100){
		  message("真实姓名、电话、地址和主页都不要太长！","goback");
	}

	if(user_exists($username)) message($username."已经被别人注册了！","goback");

	$question=dhtmlspecialchars($question);
	$email=dhtmlspecialchars($email);
	$msn=dhtmlspecialchars($msn);
	$truename=dhtmlspecialchars($truename);
	$telephone=dhtmlspecialchars($telephone);
	$address=dhtmlspecialchars($address);
	$homepage=dhtmlspecialchars($homepage);
	$userface=dhtmlspecialchars($userface);
	$sign=dhtmlspecialchars($sign);
	$skype=dhtmlspecialchars($skype);
	$alipay=dhtmlspecialchars($alipay);
	$paypal=dhtmlspecialchars($paypal);

    $groupid = $_PHPCMS['enablecheckuser'] ? 3 : 4;
	$r=$db->get_one("select * from ".TABLE_USERGROUP." where groupid=$groupid");
	@extract($r);

	$begindate = date("Y-m-d");
	$date->dayadd($defaultvalidday);
	$enddate = $defaultvalidday == -1 ? "0000-00-00" : $date->get_date();

	$db->query("insert into ".TABLE_MEMBER."(username,password,question,answer,email,showemail,groupid,chargetype,point,begindate,enddate,locked,regip,regtime) values('$username','".md5($password)."','$question','".md5($answer)."','$email','$showemail','$groupid','$chargetype','$defaultpoint','$begindate','$enddate','0','$PHP_IP','$timestamp')");
	if($db->affected_rows()>0)
	{
		$userid = $db->insert_id();
		$db->query("insert into ".TABLE_MEMBERINFO."(userid,truename,gender,birthday,idtype,idcard,province,city,industry,edulevel,occupation,income,telephone,mobile,address,postid,homepage,qq,msn,icq,skype,alipay,paypal,userface,facewidth,faceheight,sign) values ('$userid','$truename','$gender','$birthday','$idtype','$idcard','$province','$city','$industry','$edulevel','$occupation','$income','$telephone','$mobile','$address','$postid','$homepage','$qq','$msn','$icq','$skype','$alipay','$paypal','$userface','$facewidth','$faceheight','$sign')");
		if($_PHPCMS['enablecheckuser'])
		{
			message("资料提交成功！请等待管理员审批！",PHPCMS_PATH);
		}
		else
		{
			mkcookie('password',$password);
			message("您已经注册成功，正以会员身份登录...","login.php?loginsubmit=1&username=".urlencode($username)."&phpcms_user=".$phpcms_user."&referer=".urlencode($referer));
		}
	}
	else
	{
		mkcookie('phpcms_auth','');
		mkcookie('phpcms_admin','');
		mkcookie('phpcms_user','');
		message("注册失败！","goback");
	}
}
else
{
	$meta_title = "会员注册";
	$referer = $referer ? $referer : $PHP_REFERER;
    include template("member","register");
}
?>