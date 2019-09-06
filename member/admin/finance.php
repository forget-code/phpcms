<?php
/**
* 财务管理
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage member
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
defined('IN_PHPCMS') or exit(FORBIDDEN);

$submenu = array
(
	array("财务流水", "?mod=".$mod."&file=".$file."&action=manage"),
	array("汇款入帐", "?mod=".$mod."&file=".$file."&action=account&type=".urlencode("汇款入帐")),
	array("退款出帐", "?mod=".$mod."&file=".$file."&action=account&type=".urlencode("退款出帐")),
	array("退款入帐", "?mod=".$mod."&file=".$file."&action=account&type=".urlencode("退款入帐")),
	array("业务扣款", "?mod=".$mod."&file=".$file."&action=account&type=".urlencode("业务扣款"))
);

$notes = array(
	md5("汇款入帐") => "若客户通过邮政或银行汇入款项，需要通过此操作把资金增加到客户帐户里",
	md5("退款出帐") => "如果某客户不再需要购买服务，要求把帐户里的钱退回，可用此方式",
	md5("退款入帐") => "若客户对产品不满意，要退款，则通过此操作退回未使用的资金，录入到客户帐户里",
	md5("业务扣款") => "客户作了购买服务，用此方式进行手工扣款，请填写完整，以便系统自动统计"
);

$menu = adminmenu("财务管理",$submenu);

$action=$action ? $action : 'manage';

switch($action){

case 'manage':
	$page = intval($page)>0 ? $page : 1;
	$offset=($page-1)*$_PHPCMS['pagesize'];
    $fromtime = $fromdate ? strtotime($fromdate) : 0;
    $totime = $todate ? strtotime($todate)+86400 : 0;
    $keywords = trim($keywords);

	$condition .= $type ? " and type='$type' " : "";
	$condition .= $frommoney ? " and money >= $frommoney " : "";
	$condition .= $tomoney ? " and money <= $tomoney " : "";
	$condition .= $fromtime ? " and addtime >= $fromtime " : "";
	$condition .= $totime ? " and addtime <= $totime " : "";
	$condition .= $keywords ? " and $searchtype like '%$keywords%' " : "";

	$r = $db->get_one("select count(*) as num from ".TABLE_FINANCE." where 1 $condition");
	$number=$r["num"];
	$pages = phppages($number,$page,$_PHPCMS['pagesize']);

	$result=$db->query("SELECT * FROM ".TABLE_FINANCE." where 1 $condition order by financeid desc limit $offset,$_PHPCMS[pagesize]");
	while($r=$db->fetch_array($result)){
		${md5($r[type])} += $r[money]; 
		$r[type] = $r[type]=="汇款入帐" ? "<font color='red'>汇款入帐</font>" : $r[type];
		$r[addtime] = date("Y-m-d H:i:s",$r[addtime]);
		$finances[]=$r;
	}
	if(!isset($fromdate) && !isset($todate))
	{
		$date->set_date(date("Y-m-d"));
		$todate = $date->get_date();
		$date->dayadd(-7);
		$fromdate = $date->get_date();
	}
	$frommoney = isset($frommoney) ? $frommoney : 0;
	$tomoney = isset($tomoney) ? $tomoney : 10000;
	include admintpl('finance_manage');
	break;
case 'account':
	if($save)
	{
	    if(!user_exists($username)) showmessage("用户名不存在！请返回");
	    $pmoney = ($type=='汇款入帐' || $type=='退款入帐') ? $money : -$money;
        $db->query("UPDATE ".TABLE_MEMBER." SET money=money+$pmoney WHERE username='$username'");
        $db->query("INSERT INTO ".TABLE_FINANCE." (type,username,money,bank,idcard,note,inputer,addtime) VALUES('$type','$username','$money','$bank','$idcard','$note','$_username','$timestamp')");
		showmessage('操作成功！',$PHP_REFERER);
	}
	else
	{
		$typekey = md5($type);
	    include admintpl('finance_account');
	}
	break;
case 'delete':
      if(empty($financeid)){
         showmessage('非法参数！请返回！');
      }
      $financeids=is_array($financeid) ? implode(',',$financeid) : $financeid;
      $db->query("DELETE FROM ".TABLE_FINANCE." WHERE financeid IN ($financeids)");
      if($db->affected_rows()>0){
            showmessage('操作成功！',$PHP_REFERER);
      }else{
            showmessage('操作失败！请返回！');
      }
     break;

}
?>