<?php
require './include/common.inc.php';

$payonline_setting = cache_read('payonline_setting.php');

array_key_exists($paycenter, $payonline_setting) or showmessage($LANG['illegal_parameters']);

@extract($payonline_setting[$paycenter]);

mkcookie('paycenter', $paycenter, $PHP_TIME + 3600*24*365);

$r = $db->get_one("SELECT payid FROM ".TABLE_PAY_ONLINE." WHERE `orderid`='$orderid'");
if($r) showmessage($LANG['not_refresh'], $MOD['linkurl'].'payonline.php');

$moneytype = 'CNY';
$amount = floatval($amount);
$trade_fee = floatval($trade_fee);
$db->query("INSERT INTO ".TABLE_PAY_ONLINE."(`paycenter`,`username`,`orderid`,`moneytype`,`amount`,`trade_fee`,`contactname`,`telephone`,`email`,`sendtime`,`ip`) VALUES('$paycenter','$_username','$orderid','$moneytype','$amount','$trade_fee','$contactname','$telephone','$email','$PHP_TIME','$PHP_IP')");

$amount = $amount + $trade_fee;
require MOD_ROOT.'/payonline/'.$paycenter.'/send.php';
?>