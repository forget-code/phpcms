<?php
require './include/common.inc.php';
include_once PHPCMS_ROOT.'/include/mail.inc.php';

if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));

if($dosubmit)
{
	if(!preg_match("/^[0-9a-z]{8,20}$/i", $cardid)) showmessage($LANG['card_number_not_accord_with_criterion'], $PHP_REFERER);
	if(!preg_match("/^[0-9]{4,10}$/i", $password)) showmessage($LANG['password_not_accord_with_criterion'], $PHP_REFERER);

	$r = $db->get_one("SELECT * FROM ".TABLE_PAY_CARD." WHERE cardid='$cardid' LIMIT 0,1");
	if(!$r) showmessage($LANG['card_number_not_exist'], $PHP_REFERER);
    if($r['password'] != $password) showmessage($LANG['password_error'], $PHP_REFERER);
    if($r['regtime'] > 0) showmessage($LANG['this_card_in_use'], $PHP_REFERER);
    if($r['enddate'] != '0000-00-00' && $r['enddate'] < date('Y-m-d')) showmessage($LANG['this_card_out_or_date'], $PHP_REFERER);

    $id = $r['id'];
	$price = $r['price'];
	$db->query("UPDATE ".TABLE_PAY_CARD." SET username='$_username',regtime=$PHP_TIME,regip='$PHP_IP' WHERE id=$id");
    money_add($_username, $price, $LANG['paycard2money'].':'.$cardid);
	showmessage($LANG['charge_success'], $forward);
}
else
{
	$head['title'] = $LANG['online_payment_charge'];

	include template($mod, 'paycard');
}
?>