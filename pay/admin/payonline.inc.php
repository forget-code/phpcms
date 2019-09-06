<?php
defined('IN_PHPCMS') or exit('Access Denied');

$submenu = array
(
	array($LANG['parameter_setting'], "?mod=$mod&file=$file&action=setting"),
	array($LANG['all_payment_record'], "?mod=$mod&file=$file"),
	array($LANG['success_record'], "?mod=$mod&file=$file&status=1"),
	array($LANG['fail_record'], "?mod=$mod&file=$file&status=2"),
	array($LANG['unknown_record'], "?mod=$mod&file=$file&status=0"),
	array($LANG['today_payment_record'], "?mod=$mod&file=$file&date=".date('Y-m-d'))
);
$menu = adminmenu($LANG['online_payment_manage'], $submenu);

$STATUS = array(0=>'<font color="blue">'.$LANG['unknown_record'].'</font>', 1=>'<font color="red">'.$LANG['pay_success'].'</font>', 2=>$LANG['pay_fail']);

$today = date('Y-m-d');

if($action == 'setting')
{
	if($dosubmit)
	{
		function cache_payonline()
		{
			global $db;
			$data = array();
			$result = $db->query("SELECT * FROM ".TABLE_PAY_SETTING." WHERE enable=1 ORDER BY id");
			while($r = $db->fetch_array($result))
			{
				$data[$r['paycenter']] = $r;
			}
			return cache_write('payonline_setting.php', $data);
		}

		foreach($name as $id=>$v)
		{
			$db->query("UPDATE ".TABLE_PAY_SETTING." SET enable='$enable[$id]',name='$name[$id]',logo='$logo[$id]',sendurl='$sendurl[$id]',receiveurl='$receiveurl[$id]',partnerid='$partnerid[$id]',keycode='$keycode[$id]',percent='$percent[$id]' where id='$id'");
		}
		cache_payonline();
		showmessage($LANG['operation_success'],$PHP_REFERER);
	}
	else
	{

		$settings = array();
		$result = $db->query("SELECT * FROM ".TABLE_PAY_SETTING." ORDER BY id");
		while($r = $db->fetch_array($result))
		{
			$receiveurl = linkurl($MOD['linkurl'], 1).$r['paycenter'].".php";
			if($r['receiveurl'] == '') $r['receiveurl'] = $receiveurl;
			$settings[] = $r;
		}
		include admintpl('payonline_setting');
	}
}
elseif($action == 'check')
{
	$payid = intval($payid);
	$r = $db->get_one("SELECT * FROM ".TABLE_PAY_ONLINE." WHERE payid=$payid");
	if(!$r) showmessage($LANG['order_not_exist']);
	if($r['status'] == 1) showmessage($LANG['order_pay_success_no_need_verify']);
	$amount = $r['amount'];
	$username = $r['username'];
	$db->query("UPDATE ".TABLE_PAY_ONLINE." SET status=1, receivetime='$PHP_TIME', bank='".$LANG['manual_work_verify']."' WHERE payid=$payid");
	money_add($username, $amount, 'onlinepay check');

	$r = $db->get_one("SELECT money FROM ".TABLE_MEMBER." WHERE username='$username'");
	$money = $r['money'];
	$year = date('Y', $PHP_TIME);
	$month = date('m', $PHP_TIME);
	$date = date('Y-m-d', $PHP_TIME);
	$db->query("INSERT INTO ".TABLE_PAY."(typeid,note,paytype,amount,balance,username,year,month,date,inputtime,inputer,ip) VALUES('1','".$LANG['payment_for_charge']."','".$LANG['online_payment']."','$amount','$money','$username','$year','$month','$date','$PHP_TIME','$_username','$PHP_IP')");
	showmessage($LANG['order_verify_success'], $forward);
}
elseif($action == 'delete')
{
	$payid = is_array($payid) ? implode(',', $payid) : intval($payid);
	$db->query("DELETE FROM ".TABLE_PAY_ONLINE." WHERE payid IN($payid)");
	showmessage($LANG['order_delete_success'], $forward);
}
elseif($action == 'view')
{
	$payid = intval($payid);
	$r = $db->get_one("SELECT * FROM ".TABLE_PAY_ONLINE." WHERE payid=$payid");
	if(!$r) showmessage($LANG['order_not_exist']);
    extract($r);
	$sendtime = date('Y-m-d h:i:s', $sendtime);
	$receivetime = $receivetime ? date('Y-m-d h:i:s', $receivetime) : '';
	include admintpl('payonline_view');
}
else
{
	$page = isset($page) ? intval($page) : 1;
	$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 30;
	$offset = ($page-1)*$pagesize;

	$sql = isset($status) ? ($status ? " WHERE status=$status " : " WHERE status=0 ") : '';
	if(isset($date))
	{
		$todaytime = strtotime($date.' 00:00:00');
		$tomorrowtime = strtotime($date.' 23:59:59');
	    $sql .= $sql ? " and sendtime>=$todaytime and sendtime<=$tomorrowtime" : " where sendtime>=$todaytime and sendtime<=$tomorrowtime";
	}

	$r = $db->get_one("SELECT count(*) as number FROM ".TABLE_PAY_ONLINE." $sql");
	$pages = phppages($r['number'], $page, $pagesize);

	$pays = array();
	$result = $db->query("SELECT * FROM ".TABLE_PAY_ONLINE." $sql ORDER BY payid DESC LIMIT $offset,$pagesize");
	while($r = $db->fetch_array($result))
	{
		$pays[] = $r;
	}
	include admintpl('payonline');
}
?>