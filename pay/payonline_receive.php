<?php
require './include/common.inc.php';

function dopay($orderid, $amount, $bank)
{
	global $db,$_username,$PHP_TIME,$LANG;
	$r = $db->get_one("SELECT * FROM ".TABLE_PAY_ONLINE." WHERE `orderid`='$orderid'");
	if(!$r) showmessage($LANG['payment_fail_order_not_exist']);
	if($r['amount']+$r['trade_fee'] != $amount) showmessage($LANG['payment_fail_sum_not_right']);
	if($r['username'] != $_username) showmessage($LANG['payment_fail_usename_not_consistent']);
	if($r['status'] > 0) showmessage($LANG['not_refresh']);
	$db->query("UPDATE ".TABLE_PAY_ONLINE." SET status=1, receivetime='$PHP_TIME', bank='$bank' WHERE `orderid`='$orderid'");
	money_add($_username, $amount, $LANG['onlinepay_add'].':'.$orderid, $orderid);
	if($r['trade_fee']) money_diff($_username, $r['trade_fee'], $LANG['onlinepay_diff'].':'.$orderid, $orderid);
	return $r;
}

$payonline_setting = cache_read('payonline_setting.php');

$paycenter = getcookie('paycenter');

array_key_exists($paycenter, $payonline_setting) or showmessage($paycenter.$LANG['illegal_parameters']);

@extract($payonline_setting[$paycenter]);

require MOD_ROOT.'/payonline/'.$paycenter.'/receive.php';

$total_amount = $amount + $trade_fee;

$head['title'] = $LANG['online_payment_result'];

include template($mod, 'payonline_receive');
?>