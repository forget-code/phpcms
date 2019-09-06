<?php
/**
* 会员资料修改
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage member
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
require_once("common.php");

if(!$_userid) message("请登录！","login.php?referer=index.php");

if($save)
{
	if(!is_email($email)) message("请输入有效的邮件地址！","goback");
	$gender = $gender==1 ? 1 : 0;
	$showemail = $showemail==1 ? 1 : 0;
	$byear = $byear==19 ? 0000 : $byear;

	$birthday = $byear."-".$bmonth."-".$bday;
	if(!is_date($birthday)) $birthday = "0000-00-00";

	if(!empty($msn) && ( strlen($msn)>50 || !ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$msn) )){
	   message("请输入有效的MSN地址！","goback");
	}
	if(!empty($qq) && (!is_numeric($qq) || strlen($qq)>20 || strlen($qq)<5)){
	   message("请输入正确的QQ号！","goback");
	}
	if(!empty($postid) && (!is_numeric($postid) || strlen($postid)!=6)){
	   message("请输入正确的邮编！","goback");
	}
	if(strlen($truename)>50 || strlen($telephone)>50 || strlen($address)>255 || strlen($homepage)>100){
	   message("真实姓名、电话、地址和主页都不要太长！","goback");
	}
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

	$addquery = $password ? "password='".md5($password)."'," : "";
	$addquery .= $answer ? "answer='".md5($answer)."'," : "";
	
	$db->query("update ".TABLE_MEMBER." set $addquery email='$email',showemail='$showemail',question='$question' where userid=$_userid");
	$db->query("update ".TABLE_MEMBERINFO." set truename='$truename',gender='$gender',birthday='$birthday',idtype='$idtype',idcard='$idcard',province='$province',city='$city',industry='$industry',edulevel='$edulevel',occupation='$occupation',income='$income',telephone='$telephone',mobile='$mobile',address='$address',postid='$postid',homepage='$homepage',qq='$qq',msn='$msn',icq='$icq',skype='$skype',alipay='$alipay',paypal='$paypal',userface='$userface',facewidth='$facewidth',faceheight='$faceheight',sign='$sign' where userid=$_userid");
	message('操作成功！',$PHP_REFERER);
}
else
{
    $r=$db->get_one("select * from ".TABLE_MEMBER." m,".TABLE_MEMBERINFO." i where m.userid=i.userid AND m.userid='$_userid'");
	
	@extract(dhtmlspecialchars($r));

	$birthday = explode("-",$birthday);
	$byear = $birthday[0]=="0000" ? "19" : $birthday[0];
    $month = $birthday[1];
    $bmonth[$month] = "selected";
    $day = $birthday[2];
	$bday[$day] = "selected";

	$meta_title = "会员资料修改";
    include template("member","modify");
}
?>