<?php
/**
* 会员登录
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage member
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
require_once("common.php");

if(!$_userid) message("请登录！","login.php?referer=index.php");

@extract($db->get_one("SELECT COUNT(*) AS inbox_new_num FROM ".TABLE_PM." WHERE tousername='$_username' and new=1 and send=1 and recycle=0","CACHE")); //新信件数量

@extract($db->get_one("SELECT * FROM ".TABLE_MEMBER." m, ".TABLE_MEMBERINFO." i WHERE m.userid=i.userid AND m.userid=$_userid","CACHE")); //会员信息

$chargetype = $chargetype==1 ? "有效期" : "扣点数";
$_GROUP['enableaddalways'] = $_GROUP['enableaddalways']==1 ? "<font color='red'>是</font>" : "否";
$gender = $gender==1 ? "男" : "女";
$regtime = $regtime ? date("Y-m-d H:i:s",$regtime) : "";
$lastlogintime = $lastlogintime ? date("Y-m-d H:i:s",$lastlogintime) : '';
$begindate = $begindate > "0000-00-00" ? $begindate : "";
$enddate = $enddate > "0000-00-00" ? $enddate : "";
if($birthday > "0000-00-00")
{
	$date->set_date($birthday);
	$old = date("Y")-$date->get_year();
}
$locked = $locked ? "<font color='red'>已被锁定</font>" : "正常";

$meta_title = "会员资料";

include template("member","index");
?>