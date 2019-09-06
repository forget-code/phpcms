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
	array("所有充值卡", "?mod=".$mod."&file=".$file."&action=manage"),
	array("未使用的充值卡", "?mod=".$mod."&file=".$file."&action=manage&status=notused"),
	array("已使用的充值卡", "?mod=".$mod."&file=".$file."&action=manage&status=used"),
	array("已失效的充值卡", "?mod=".$mod."&file=".$file."&action=manage&status=timeout"),
	array("批量产生充值卡", "?mod=".$mod."&file=".$file."&action=add")
);

$menu = adminmenu("充值卡管理",$submenu);

$today = date("Y-m-d");

$action=$action ? $action : 'manage';

switch($action){

case 'manage':
	$page = intval($page)>0 ? $page : 1;
	$offset=($page-1)*$_PHPCMS['pagesize'];

	if($status=="notused")
	{
	    $condition .= " where regtime=0 and enddate>='$today'";
	}
	elseif($status=="used")
	{
	    $condition .= " where regtime>0";
	}
	elseif($status=="timeout")
	{
	    $condition .= " where regtime=0 and enddate<'$today'";
	}

	$r = $db->get_one("select count(*) as num from ".TABLE_PAYCARD." $condition");
	$pages = phppages($r["num"],$page,$_PHPCMS['pagesize']);

	$result=$db->query("SELECT * FROM ".TABLE_PAYCARD." $condition order by id desc limit $offset,$_PHPCMS[pagesize]");
	while($r=$db->fetch_array($result))
	{
		$r['status'] = $r['regtime'] ? "<font color='red'>已使用</font>" : (  ($r['enddate']!='0000-00-00' && $r['enddate'] < $today) ? "已过期" : "<font color='blue'>未使用</font>" );
		$r['regtime'] = $r['regtime'] ? date("Y-m-d H:i:s",$r['regtime']) : "";
		$r['enddate'] = $r['enddate']=='0000-00-00' ? "无限期" : $r['enddate'];
		$paycards[]=$r;
	}
	include admintpl('paycard_manage');
	break;

case 'add':
	if($save)
	{
	    $paycardlen = intval($paycardlen);
		if($paycardlen>20 || $paycardlen<8) showmessage("卡号不得少于8个字符超过20个字符！");

	    $passwordlen = intval($passwordlen);
		if($passwordlen>10 || $passwordlen<4) showmessage("支付卡密码不得少于4个字符大于10个字符！");

	    $prefixlen = strlen($paycardprefix);
		if($prefixlen>6 || $prefixlen<1) showmessage("卡号前缀不得少于1个字符超过6个字符！");

	    $strnum = $paycardlen - strlen($paycardprefix);
        $paycards = array();
        for($i=0;$i<$paycardnum;$i++)
		{
			$cardid = $paycardprefix.random($strnum);
			$password = random($passwordlen);
			$adddate = date('Y-m-d');

			$paycards[] = array($cardid,$password);

			$db->query("INSERT INTO ".TABLE_PAYCARD." (cardidprefix,cardid,password,price,inputer,adddate,enddate) VALUES('$paycardprefix','$cardid','$password','$paycardprice','$_username','$adddate','$enddate')");
		}
	    include admintpl('paycard_view');
	}
	else
	{
	    include admintpl('paycard_add');
	}
	break;

case 'delete':
      if(empty($id)){
         showmessage('非法参数！请返回！');
      }
      $ids=is_array($id) ? implode(',',$id) : $id;
      $db->query("DELETE FROM ".TABLE_PAYCARD." WHERE id IN ($ids)");
      $db->affected_rows()>0 ? showmessage('操作成功！',$PHP_REFERER) : showmessage('操作失败！请返回！');
     break;

case 'deletetimeout':
      $db->query("DELETE FROM ".TABLE_PAYCARD." WHERE regtime=0 AND enddate<$today");
      $db->affected_rows()>0 ? showmessage('操作成功！',$PHP_REFERER) : showmessage('操作失败！请返回！');
     break;

case 'deleteused':
      $db->query("DELETE FROM ".TABLE_PAYCARD." WHERE regtime>0");
      $db->affected_rows()>0 ? showmessage('操作成功！',$PHP_REFERER) : showmessage('操作失败！请返回！');
     break;
}
?>