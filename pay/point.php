<?php
require './include/common.inc.php';
include_once PHPCMS_ROOT.'/include/mail.inc.php';

if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));

if($dosubmit)
{
	$id = intval($id);
	$r = $db->get_one("SELECT * FROM ".TABLE_PAY_PRICE." WHERE id=$id LIMIT 0,1");
	if(!$r) showmessage($LANG['illegal_parameters'], $PHP_REFERER);
	$point = $r['point'];
	$price = $r['price'];
	if($type == 'money2point')
	{
		if($r['type'] != 0) showmessage($LANG['illegal_parameters'], $PHP_REFERER);
		if($r['price'] > $_money) showmessage($LANG['balance_not_enough'], $PHP_REFERER);
		money_diff($_username, $price, $LANG['money2point']);
    }
	else
	{
		if($r['type'] != 2) showmessage($LANG['illegal_parameters'], $PHP_REFERER);
		if($r['price'] > $_credit) showmessage($LANG['balance_not_enough'], $PHP_REFERER);
		credit_diff($_username, $price, $LANG['credit2point']);
	}
	point_add($_username, $point, $LANG[$type]);
	showmessage($LANG['buy_point_success'] , $forward);
}
else
{
	$head['title'] = $LANG['online_payment_charge'];

	$money2points = array();
	$result = $db->query("SELECT * FROM ".TABLE_PAY_PRICE." WHERE type=0 ORDER BY id");
	while($r = $db->fetch_array($result))
	{
		$money2points[$r['id']] = $r;
	}

	$credit2points = array();
	$result = $db->query("SELECT * FROM ".TABLE_PAY_PRICE." WHERE type=2 ORDER BY id");
	while($r = $db->fetch_array($result))
	{
		$credit2points[$r['id']] = $r;
	}

	include template($mod, 'point');
}
?>