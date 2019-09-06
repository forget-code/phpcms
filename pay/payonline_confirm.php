<?php
require './include/common.inc.php';

$payonline_setting = cache_read('payonline_setting.php');

$amount = round(floatval($amount), 2);
if($amount < 0.01) showmessage($LANG['sum_not_less_than_001'], 'goback');
if(empty($contactname) || empty($telephone) || empty($email)) showmessage($LANG['payinfo_is_null']);

array_key_exists($paycenter, $payonline_setting) or showmessage($LANG['illegal_parameters']);
@extract($payonline_setting[$paycenter]);

if($percent)
{
	$percent = round(floatval($percent), 2);
    $trade_fee = round($amount*$percent/100, 2);
    if($trade_fee < 0.01) $trade_fee = 0.01;
}
else
{
    $trade_fee = 0;
}
$total_amount = $amount + $trade_fee;

require MOD_ROOT.'/payonline/'.$paycenter.'/confirm.php';


$head['title'] = $LANG['confirm_online_payment'];

include template($mod, 'payonline_confirm');
?>