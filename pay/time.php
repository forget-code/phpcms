<?php
require './include/common.inc.php';

if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));

if($dosubmit)
{
	$id = intval($id);
	$r = $db->get_one("SELECT * FROM ".TABLE_PAY_PRICE." WHERE id=$id LIMIT 0,1");
	if(!$r) showmessage($LANG['illegal_parameters'], $PHP_REFERER);
	if($type == 'money2time')
	{
		if($r['type'] != 1) showmessage($LANG['illegal_parameters'], $PHP_REFERER);
		if($r['price'] > $_money) showmessage($LANG['balance_not_enough'], $PHP_REFERER);
		money_diff($_username, $r['price'], $LANG['money2time']);
    }
	else
	{
		if($r['type'] != 3) showmessage($LANG['illegal_parameters'], $PHP_REFERER);
		if($r['price'] > $_credit) showmessage($LANG['balance_not_enough'], $PHP_REFERER);
		credit_diff($_username, $r['price'], $LANG['credit2time']);
	}
	time_add($_username, $r['time'], $r['unit'], $LANG[$type]);
	showmessage($LANG['buy_period_of_validity_success'], $forward);
}
else
{
	$head['title'] = $LANG['online_payment_charge'];

	$units = array('y'=>$LANG['year'],'m'=>$LANG['month'],'d'=>$LANG['day']);

	$money2times = array();
	$result = $db->query("SELECT * FROM ".TABLE_PAY_PRICE." WHERE type=1 ORDER BY id");
	while($r = $db->fetch_array($result))
	{
		$money2times[$r['id']] = $r;
	}

	$credit2times = array();
	$result = $db->query("SELECT * FROM ".TABLE_PAY_PRICE." WHERE type=3 ORDER BY id");
	while($r = $db->fetch_array($result))
	{
		$credit2times[$r['id']] = $r;
	}

	include template($mod, 'time');
}
?>