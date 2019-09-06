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
	array("充值消费流水", "?mod=".$mod."&file=".$file."&action=manage"),
	array("资金换点数", "?mod=".$mod."&file=".$file."&action=money2point"),
	array("积分换点数", "?mod=".$mod."&file=".$file."&action=credit2point"),
	array("赠送点数", "?mod=".$mod."&file=".$file."&action=addpoint"),
	array("消费扣点", "?mod=".$mod."&file=".$file."&action=diffpoint"),
);

$menu = adminmenu("点数兑换管理",$submenu);

$action=$action ? $action : 'manage';

switch($action){

case 'manage':
	$page = intval($page)>0 ? $page : 1;
	$offset=($page-1)*$_PHPCMS['pagesize'];
    $fromtime = $fromdate ? strtotime($fromdate) : 0;
    $totime = $todate ? strtotime($todate)+86400 : 0;
    $keywords = trim($keywords);

	$condition .= $type ? " and type='$type' " : "";
	$condition .= $frompoint ? " and point >= $frompoint " : "";
	$condition .= $topoint ? " and point <= $topoint " : "";
	$condition .= $fromtime ? " and addtime >= $fromtime " : "";
	$condition .= $totime ? " and addtime <= $totime " : "";
	$condition .= $keywords ? " and $searchtype like '%$keywords%' " : "";

	$r = $db->get_one("select count(*) as num from ".TABLE_EXCHANGE." where 1 $condition");
	$number=$r["num"];
	$pages = phppages($number,$page,$_PHPCMS['pagesize']);

	$result=$db->query("SELECT * FROM ".TABLE_EXCHANGE." where 1 $condition order by exchangeid desc limit $offset,$_PHPCMS[pagesize]");
	while($r=$db->fetch_array($result)){
		$r[addtime] = date("Y-m-d H:i:s",$r[addtime]);
		${md5($r[type])} += $r[point]; 
		$r[type] = $r[type] == "消费扣点" ? "<font color='red'>消费扣点</font>" : $r[type];
		$r[payment] = ($r[money] || $r[credit]) ? ($r[money] ? $r[money]."元" : $r[credit]."分") : "";
		$r[exchange] = $r[point] ? $r[point]."点" : $r[day]."天";
		$exchanges[]=$r;
	}
	if(!isset($fromdate) && !isset($todate))
	{
		$date->set_date(date("Y-m-d"));
		$todate = $date->get_date();
		$date->dayadd(-7);
		$fromdate = $date->get_date();
	}
	$frompoint = isset($frompoint) ? $frompoint : 0;
	$topoint = isset($topoint) ? $topoint : 10000;
	include admintpl('exchange_manage');
	break;

case 'money2point':
	if($save)
	{
	    if(!$user = user_exists($username)) showmessage("用户名不存在！请返回");
		if($user[money] < $money) showmessage("对不起，余额不足！当前余额为 $user[money] 元。请返回");
		$credit=0;
		$money = intval($money);
		$point = floor($money*$_PHPCMS['money2point']);
        $db->query("UPDATE ".TABLE_MEMBER." SET money=money-$money,point=point+$point WHERE username='$username'");
        $db->query("INSERT INTO ".TABLE_EXCHANGE." (type,username,point,money,credit,note,inputer,addtime) VALUES('$type','$username','$point','$money','$credit','$note','$_username','$timestamp')");
		showmessage('操作成功！',$PHP_REFERER);
	}
	else
	{
	    include admintpl('exchange_money2point');
	}
	break;

case 'credit2point':
	if($save)
	{
	    if(!$user = user_exists($username)) showmessage("用户名不存在！请返回");
		if($user[credit] < $credit) showmessage("对不起，积分不足！当前积分为 $user[credit] 分。请返回");
		$money=0;
		$credit = intval($credit);
		$point = floor($credit*$_PHPCMS['credit2point']);
        $db->query("UPDATE ".TABLE_MEMBER." SET credit=credit-$credit,point=point+$point WHERE username='$username'");
        $db->query("INSERT INTO ".TABLE_EXCHANGE." (type,username,point,money,credit,note,inputer,addtime) VALUES('$type','$username','$point','$money','$credit','$note','$_username','$timestamp')");
		showmessage('操作成功！',$PHP_REFERER);
	}
	else
	{
	    include admintpl('exchange_credit2point');
	}
	break;

case 'addpoint':
	if($save)
	{
	    if(!$user = user_exists($username)) showmessage("用户名不存在！请返回");
		$money = 0;
		$credit = 0;
		$point = intval($point);
        $db->query("UPDATE ".TABLE_MEMBER." SET point=point+$point WHERE username='$username'");
        $db->query("INSERT INTO ".TABLE_EXCHANGE." (type,username,point,money,credit,note,inputer,addtime) VALUES('$type','$username','$point','$money','$credit','$note','$_username','$timestamp')");
		showmessage('操作成功！',$PHP_REFERER);
	}
	else
	{
	    include admintpl('exchange_addpoint');
	}
	break;

case 'diffpoint':
	if($save)
	{
	    if(!$user = user_exists($username)) showmessage("用户名不存在！请返回");
		$money = 0;
		$credit = 0;
		$point = intval($point);
		if($user[point] < $point) showmessage("点数不够，当前可用点数为 $user[point] 点！请返回");
        $db->query("UPDATE ".TABLE_MEMBER." SET point=point-$point WHERE username='$username'");
        $db->query("INSERT INTO ".TABLE_EXCHANGE." (type,username,point,money,credit,note,inputer,addtime) VALUES('$type','$username','$point','$money','$credit','$note','$_username','$timestamp')");
		showmessage('操作成功！',$PHP_REFERER);
	}
	else
	{
	    include admintpl('exchange_diffpoint');
	}
	break;

case 'delete':
      if(empty($exchangeid)){
         showmessage('非法参数！请返回！');
      }
      $exchangeids=is_array($exchangeid) ? implode(',',$exchangeid) : $exchangeid;
      $db->query("DELETE FROM ".TABLE_EXCHANGE." WHERE exchangeid IN ($exchangeids)");
      if($db->affected_rows()>0){
            showmessage('操作成功！',$PHP_REFERER);
      }else{
            showmessage('操作失败！请返回！');
      }
     break;

}
?>