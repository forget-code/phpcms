<?php
/**
* 兑换点数
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage class
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
require_once("common.php");

if(!$_userid) message("请登录！","login.php?referer=index.php");

switch($action)
{
	case 'getpoint':
		if($save)
	    {
			if($changetype)
			{
				if($_money < $money) message("对不起，余额不足！当前余额为 $_money 元。","goback");
				$money = intval($money);
				$point = floor($money*$_PHPCMS['money2point']);
				$db->query("UPDATE ".TABLE_MEMBER." SET money=money-$money,point=point+$point WHERE userid='$_userid'");
				$db->query("INSERT INTO ".TABLE_EXCHANGE." (type,username,point,money,credit,note,inputer,addtime) VALUES('资金换点数','$_username','$point','$money','$credit','$note','$_username','$timestamp')");
				message('操作成功！',$PHP_REFERER);
			}
			else
			{
				if($_credit < $credit) message("对不起，积分不足！当前积分为 $user[credit] 分。","goback");
				$credit = intval($credit);
				$point = floor($credit*$_PHPCMS['credit2point']);
				$db->query("UPDATE ".TABLE_MEMBER." SET credit=credit-$credit,point=point+$point WHERE userid='$_userid'");
				$db->query("INSERT INTO ".TABLE_EXCHANGE." (type,username,point,money,credit,note,inputer,addtime) VALUES('积分换点数','$_username','$point','$money','$credit','$note','$_username','$timestamp')");
				message('操作成功！',$PHP_REFERER);
			}
		}
		else
	    {
			$meta_title = "兑换点数";
		    include template("member","getpoint");
		}
		break;
	case 'gettime':
		if($save)
	    {
			if($changetype)
			{
				if($_money < $money) message("对不起，余额不足！当前余额为 $_money 元。","goback");
				$money = intval($money);
				$day = floor($money*$_PHPCMS['money2time']);
				$date->set_date($_enddate);
				$date->dayadd($day);
				$_enddate = $date->get_date();
				$db->query("UPDATE ".TABLE_MEMBER." SET money=money-$money,enddate='$_enddate' WHERE userid='$_userid'");
				$db->query("INSERT INTO ".TABLE_EXCHANGE." (type,username,money,day,note,inputer,addtime) VALUES('资金换有效期','$_username','$money','$day','$note','$_username','$timestamp')");
				message('操作成功！',$PHP_REFERER);
			}
			else
			{
				if($_credit < $credit) message("对不起，积分不足！当前积分为 $_credit 分。","goback");
				$credit = intval($credit);
				$day = floor($credit*$_PHPCMS['credit2time']);
				$date->set_date($_enddate);
				$date->dayadd($day);
				$_enddate = $date->get_date();
				$db->query("UPDATE ".TABLE_MEMBER." SET credit=credit-$credit,enddate='$_enddate' WHERE userid='$_userid'");
				$db->query("INSERT INTO ".TABLE_EXCHANGE." (type,username,credit,day,note,inputer,addtime) VALUES('积分换有效期','$_username','$credit','$day','$note','$_username','$timestamp')");
				message('操作成功！',$PHP_REFERER);
			}
		}
		else
	    {
			$meta_title = "兑换有效期";
		    include template("member","gettime");
		}
		break;
	case 'sendpoint':
		if($save)
	    {
	        if(!user_exists($username)) message("对不起，".$username."不存在！","goback");

			$point = intval($point);
			if($_point < $point) message("对不起，点数不足！当前点数为 $_point 点。","goback");
			$_point = $_point - $point;
			$db->query("UPDATE ".TABLE_MEMBER." SET point=$_point WHERE userid='$_userid'");
			$db->query("UPDATE ".TABLE_MEMBER." SET point=point+$point WHERE username='$username'");
			$db->query("INSERT INTO ".TABLE_EXCHANGE." (type,username,point,money,credit,note,inputer,addtime) VALUES('赠送点数','$username','$point','0','0','','$_username','$timestamp')");
			message('操作成功！',$PHP_REFERER);
		}
		else
	    {
			$meta_title = "赠送点数";
		    include template("member","sendpoint");
		}
		break;

		case 'paycard':
			if($save)
			{
				if(!preg_match("/^[0-9a-z]{8,20}$/i",$cardid)) message("卡号不符合规范！","goback");
				if(!preg_match("/^[0-9]{4,10}$/i",$password)) message("密码不符合规范！","goback");

				$r = $db->get_one("SELECT * FROM ".TABLE_PAYCARD." WHERE cardid='$cardid' AND password='$password' AND regtime=0 LIMIT 0,1");
				if(!$r['id']) message("卡号和密码不匹配或者该卡号已经过期！"); 

				$db->query("UPDATE ".TABLE_MEMBER." SET money=money+$r[price] WHERE username='$_username'");
				$db->query("UPDATE ".TABLE_PAYCARD." SET username='$_username',regtime=$timestamp,regip='$PHP_IP' WHERE id='$r[id]'");

				message('充值成功！',$PHP_REFERER);
			}
			else
			{
			    $meta_title = "支付卡充值";
				include template("member","paycard");
			}
			break;
}
?>