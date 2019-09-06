<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/include/mail.inc.php';

function get_memberinfo($username)
{
	global $db;
	return $db->get_one("SELECT * FROM ".TABLE_MEMBER." WHERE username='$username'");
}

function is_exchanged($authid, $chargedays = 0)
{
	global $db, $PHP_TIME;
	$r = $db->get_one("SELECT addtime FROM ".TABLE_PAY_EXCHANGE." WHERE authid='$authid' ORDER BY exchangeid DESC");
	if(!$r) return FALSE;
	if($chargedays)
	{
		$chargedays = intval($chargedays);
		return $PHP_TIME < $r['addtime'] + $chargedays*24*3600;
	}
	else
	{
		return $PHP_TIME < $r['addtime'] + 180;
	}
}

function time_add($username, $number, $unit = 'd', $note = '')
{
	global $db, $_userid, $PHP_TIME, $PHP_IP, $PHP_URL, $MODULE, $LANG;
	if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));
	$note = addslashes($note);
	$number = intval($number);
	if($number < 0)	showmessage($LANG['illegal_parameters']);
	$r = get_memberinfo($username);
	if(!$r) showmessage($LANG['username_not_exist']);
    require_once PHPCMS_ROOT.'/include/date.class.php';
    $date = new phpcms_date;
    $date->set_date($r['enddate']);
	if($unit == 'y')
	{
		$date->yearadd($number);
	}
	elseif($unit == 'm')
	{
		$date->monthadd($number);
	}
	elseif($unit == 'd')
	{
		$date->dayadd($number);
	}
	else
	{
		return FALSE;
	}
    $enddate = $date->get_date();
	$db->query("UPDATE ".TABLE_MEMBER." SET enddate='$enddate' WHERE username='$username'");
	if($db->affected_rows() == 0) showmessage($LANG['operation_failure']);
	$db->query("INSERT INTO ".TABLE_PAY_EXCHANGE."(`username`,`type`,`value`,`unit`,`note`,`addtime`,`ip`) VALUES('$username','time','$number','$unit','$note','$PHP_TIME','$PHP_IP')");
}

function check_time()
{
	global $db,$MODULE,$PHP_URL,$_userid,$_username,$_chargetype,$_begindate,$_enddate,$LANG;
	if($_chargetype == 1)
	{
		$today = date('Y-m-d');
		if($_begindate > $today) showmessage($LANG['services_period_have_not_start']);
		if($_enddate != '0000-00-00' && $_enddate < $today) showmessage($LANG['out_of_services_period'], $MODULE['pay']['linkurl'].'time.php?forward='.urlencode($PHP_URL));
	}
	return TRUE;
}

function point_add($username, $number, $note = '')
{
	global $db, $PHP_TIME, $PHP_IP, $LANG;
	$number = intval($number);
	if($number < 0)	showmessage($LANG['illegal_parameters']);
	$note = addslashes($note);
	$db->query("UPDATE ".TABLE_MEMBER." SET point=point+$number WHERE username='$username'");
	if($db->affected_rows() == 0) showmessage($LANG['operation_failure']);
	$db->query("INSERT INTO ".TABLE_PAY_EXCHANGE."(`username`,`type`,`value`,`note`,`addtime`,`ip`) VALUES('$username','point','$number','$note','$PHP_TIME','$PHP_IP')");
}

function point_diff($username, $number, $note = '', $authid = '')
{
	global $db, $PHP_TIME, $PHP_IP, $PHP_URL, $PHP_SITEURL, $MODULE, $PHPCMS, $CONFIG,$LANG;
	$number = intval($number);
	if($number < 0)	showmessage($LANG['illegal_parameters']);
	$note = addslashes($note);
	$r = get_memberinfo($username);
	if(!$r) showmessage($LANG['username_not_exist']);
	extract($r);
	if($chargetype == 0)
	{
		if($number > $point) showmessage($LANG['your_point_not_enough_charge'], $MODULE['pay']['linkurl'].'point.php?point='.($number - $point).'&forward='.urlencode($PHP_URL));
        $db->query("UPDATE ".TABLE_MEMBER." SET point=point-$number WHERE username='$username'");
	    $db->query("INSERT INTO ".TABLE_PAY_EXCHANGE."(`username`,`type`,`value`,`note`,`addtime`,`ip`,`authid`) VALUES('$username','point','-".$number."','$note','$PHP_TIME','$PHP_IP','$authid')");
   		$member = cache_read('member_setting.php');
		if($member['ispointdiffemail'])
		{
		    $data = tpl_data('member','pointmailtpl');
			sendmail($email, $LANG['confirm_member_card_number_change_email'].'('.$PHPCMS['sitename'].')', stripslashes($data));
		}
	}
	return TRUE;
}

function credit_add($username, $number, $note = '')
{
	global $db, $PHP_TIME, $PHP_IP, $LANG;
	$number = intval($number);
	if($number < 0)	showmessage($LANG['illegal_parameters']);
	$note = addslashes($note);
	$db->query("UPDATE ".TABLE_MEMBER." SET credit=credit+$number WHERE username='$username'");
	if($db->affected_rows() == 0) showmessage($LANG['operation_failure']);
	$db->query("INSERT INTO ".TABLE_PAY_EXCHANGE."(`username`,`type`,`value`,`note`,`addtime`,`ip`) VALUES('$username','credit','$number','$note','$PHP_TIME','$PHP_IP')");
}

function credit_diff($username, $number, $note = '', $authid = '')
{
	global $db, $PHP_TIME, $PHP_IP, $LANG;
	$number = intval($number);
	if($number < 0)	showmessage($LANG['illegal_parameters']);
	$note = addslashes($note);
	$r = get_memberinfo($username);
	if(!$r) showmessage($LANG['username_not_exist']);
	extract($r);
	if($chargetype == 0)
	{
		if($number > $credit) showmessage($LANG['your_credit_not_enough_charge']);
        $db->query("UPDATE ".TABLE_MEMBER." SET credit=credit-$number WHERE username='$username'");
	    $db->query("INSERT INTO ".TABLE_PAY_EXCHANGE."(`username`,`type`,`value`,`note`,`addtime`,`ip`,`authid`) VALUES('$username','credit','-".$number."','$note','$PHP_TIME','$PHP_IP','$authid')");
	}
	return TRUE;
}

function money_add($username, $number, $note = '')
{
	global $db, $PHP_TIME, $PHP_IP, $LANG;
	$number = round(floatval($number) ,2);
	if($number < 0) showmessage($LANG['sum_not_less_than_0']);
	$note = addslashes($note);
	$r = get_memberinfo($username);
	if(!$r) showmessage($LANG['username_not_exist']);
	extract($r);
	$money = $money + $number;
	$db->query("UPDATE ".TABLE_MEMBER." SET money=$money WHERE username='$username'");
	if($db->affected_rows() == 0) showmessage($LANG['operation_failure']);
	$year = date('Y', $PHP_TIME);
	$month = date('m', $PHP_TIME);
	$date = date('Y-m-d', $PHP_TIME);
	$db->query("INSERT INTO ".TABLE_PAY."(typeid,note,paytype,amount,balance,username,year,month,date,inputtime,inputer,ip) VALUES('1','$note','".$LANG['account_deduction']."','$number','$money','$username','$year','$month','$date','$PHP_TIME','system','$PHP_IP')");
	$db->query("INSERT INTO ".TABLE_PAY_EXCHANGE."(`username`,`type`,`value`,`note`,`addtime`,`ip`) VALUES('$username','money','$number','$note','$PHP_TIME','$PHP_IP')");
	$member = cache_read('member_setting.php');
	if($member['ismoneydiffemail'])
	{
		$data = tpl_data('member','moneymailtpl');
		sendmail($email, $LANG['confirm_member_fund_change_email'].'('.$PHPCMS['sitename'].')', stripslashes($data));
	}
}

function money_diff($username, $number, $note = '', $authid = '')
{
	global $db, $PHP_TIME, $PHP_IP, $PHP_URL, $MODULE, $PHPCMS, $CONFIG, $PHP_SITEURL, $LANG;
	$number = round(floatval($number) ,2);
	if($number == 0) return TRUE;
	if($number < 0) showmessage($LANG['sum_not_less_than_0']);
	$note = addslashes($note);
	$r = get_memberinfo($username);
	if(!$r) showmessage($LANG['username_not_exist']);
	extract($r);
	if($number > $money) showmessage($LANG['account_fund_inadequate_please_charge'], $MODULE['pay']['linkurl'].'pay.php?amount='.($number - $money).'&forward='.urlencode($PHP_URL));
	$money = $money - $number;
	$db->query("UPDATE ".TABLE_MEMBER." SET money=$money,payment=payment+$number WHERE username='$username'");
	if($introducer && isset($MODULE['union'])) $db->query("UPDATE ".TABLE_UNION." SET settleexpendamount=settleexpendamount+$number WHERE userid=$introducer");
	$year = date('Y', $PHP_TIME);
	$month = date('m', $PHP_TIME);
	$date = date('Y-m-d', $PHP_TIME);
	$db->query("INSERT INTO ".TABLE_PAY."(typeid,note,paytype,amount,balance,username,year,month,date,inputtime,inputer,ip) VALUES('2','$note','".$LANG['account_deduction']."','$number','$money','$username','$year','$month','$date','$PHP_TIME','system','$PHP_IP')");
	$db->query("INSERT INTO ".TABLE_PAY_EXCHANGE."(`username`,`type`,`value`,`note`,`addtime`,`ip`,`authid`) VALUES('$username','money','-".$number."','$note','$PHP_TIME','$PHP_IP','$authid')");
	$member = cache_read('member_setting.php');
	if($member['ismoneydiffemail'])
	{
		$data = tpl_data('member','moneymailtpl');
		sendmail($email, $LANG['confirm_member_fund_change_email'].'('.$PHPCMS['sitename'].')', stripslashes($data));
	}
	return TRUE;
}
?>