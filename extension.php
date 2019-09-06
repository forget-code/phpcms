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

//动态网页分页函数
function phppages($total,$page=1,$perpage=20,$url='')
{
	 global $PHP_QUERYSTRING;
	 $url = $url ? $url : '?'.preg_replace("/(.*)(&page=[0-9]*)(.*)/i","\\1\\3",$PHP_QUERYSTRING); 
	 $pages = ceil($total/$perpage);
	 $page = min($pages,$page);
	 $prepg = $page-1;
	 $nextpg = $page==$pages ? 0 : ($page+1);
	 if($total<1) return false;
	 $pagenav = "总数：<b>$total</b>&nbsp;&nbsp;&nbsp;&nbsp;";
	 $pagenav.= $prepg ? "<a href='$url&page=1'>首页</a>&nbsp;<a href='$url&page=$prepg'>上一页</a>&nbsp;" : "首页&nbsp;上一页&nbsp;";
	 $pagenav.= $nextpg ? "<a href='$url&page=$nextpg'>下一页</a>&nbsp;<a href='$url&page=$pages'>尾页</a>&nbsp;" : "下一页&nbsp;尾页&nbsp;";
	 $pagenav.="页次：<b><font color=red>$page</font>/$pages</b>&nbsp;&nbsp;转到：<select name='topage' size='1' onchange='window.location=\"$url&page=\"+this.value'>\n";
	 for($i=1;$i<=$pages;$i++){
		 $selected = $i==$page ? 'selected' : '';
		 $pagenav.="<option value='$i' $selected>第".$i."页</option>\n";
	 }
	 $pagenav.="</select>";
	 return $pagenav;
}

//前台信息列表分页函数
function listpages($total,$page=1,$perpage=20)
{
	global $p;
	$page = $page>0 ? $page : 1;
	$pages = ceil($total/$perpage);
	$page = min($pages,$page);
	$prepg = $page-1;
	$nextpg = $page==$pages ? 0 : ($page+1);
	if($total<1) return false;
	$pagenav = "总数：<b>$total</b>&nbsp;&nbsp;&nbsp;&nbsp;";
	$pagenav.= $prepg ? "<a href='".$p->get_listurl(1)."'>首页</a>&nbsp;<a href='".$p->get_listurl($prepg)."'>上一页</a>&nbsp;" : "首页&nbsp;上一页&nbsp;";
	$pagenav.= $nextpg ? "<a href='".$p->get_listurl($nextpg)."'>下一页</a>&nbsp;<a href='".$p->get_listurl($pages)."'>尾页</a>&nbsp;" : "下一页&nbsp;尾页&nbsp;";
	$pagenav.="页次：<b><font color=red>$page</font>/$pages</b>&nbsp;&nbsp;转到：<select name='topage' size='1' onchange='window.location=this.value'>\n";
	for($i=1;$i<=$pages;$i++)
	{
		$selected = $i==$page ? 'selected' : '';
		$pagenav.="<option value='".$p->get_listurl($i)."' $selected>第".$i."页</option>\n";
	}
	$pagenav.="</select>";
	return $pagenav;
}

//前台专题列表分页函数
function specialpages($total,$page=1,$perpage=20)
{
	global $p;
	$page = $page>0 ? $page : 1;
	$p->set_type("url");
	$pages = ceil($total/$perpage);
	$page = min($pages,$page);
	$prepg = $page-1;
	$nextpg = $page==$pages ? 0 : ($page+1);
	if($total<1) return false;
	$pagenav = "总数：<b>$total</b>&nbsp;&nbsp;&nbsp;&nbsp;";
	$pagenav.= $prepg ? "<a href='".$p->get_speciallisturl(1)."'>首页</a>&nbsp;<a href='".$p->get_speciallisturl($prepg)."'>上一页</a>&nbsp;" : "首页&nbsp;上一页&nbsp;";
	$pagenav.= $nextpg ? "<a href='".$p->get_speciallisturl($nextpg)."'>下一页</a>&nbsp;<a href='".$p->get_speciallisturl($pages)."'>尾页</a>&nbsp;" : "下一页&nbsp;尾页&nbsp;";
	$pagenav.="页次：<b><font color=red>$page</font>/$pages</b>&nbsp;&nbsp;转到：<select name='topage' size='1' onchange='window.location=this.value'>\n";
	for($i=1;$i<=$pages;$i++)
	{
		$selected = $i==$page ? 'selected' : '';
		$pagenav.="<option value='".$p->get_speciallisturl($i)."' $selected>第".$i."页</option>\n";
	}
	$pagenav.="</select>";
	return $pagenav;
}

//有效期验证
function charge_time()
{
	global $db,$_userid,$_username,$_chargetype,$_begindate,$_enddate;
	if($_userid==0 && $readpoint>0) message("请先登录！");
	if($_chargetype)
	{
		$today = date("Y-m-d");
		if($_begindate > $today) message("服务期还没有开始！","goback");
		if($_enddate!="0000-00-00" && $_enddate < $today) message("服务期已过，请续费！","goback");
	}
	return true;
}

//扣点数
function charge_point($readpoint=0,$note='')
{
	global $db,$timestamp,$_userid,$_username,$_chargetype,$_point;
	if($_userid==0 && $readpoint>0) message("请先登录！");
	if(!$_chargetype)
	{
		$readpoint = intval($readpoint);
		if($readpoint==0) return true;
		if($readpoint<0) message("非法参数！");
		if($readpoint > $_point) message("您的点数不够，请充值！","goback");
        $_point = $_point - $readpoint;
        $db->query("UPDATE ".TABLE_MEMBER." SET point=$_point WHERE userid=$_userid");
        $db->query("INSERT INTO ".TABLE_EXCHANGE."(type,username,point,note,inputer,addtime) VALUES('消费扣点','$_username','$readpoint','$note','$_username','$timestamp')");
	}
	return true;
}

//扣款
function exchange($money=0,$note='')
{
	global $db,$timestamp,$_userid,$_username,$_money;
	if($_userid==0) message("请先登录！");
	$money = intval($money);
	if($money==0) return true;
	if($money<0) message("非法参数！");
	if($money > $_money) message("帐户钱不够，请先入款！");
	$_money = $_money - $money;
	$db->query("UPDATE ".TABLE_MEMBER." SET money=$_money WHERE userid=$_userid");
	$db->query("INSERT INTO ".TABLE_FINANCE."(type,username,money,note,inputer,addtime) VALUES('业务扣款','$_username','$money','$note','$_username','$timestamp')");
}

//此文件可影响全站，如果需要其他模块能够调用，则可以在此包含一个文件。



?>