<?php
defined('IN_PHPCMS') or exit('Access Denied');

$orderid = $out_trade_no;
$amount = $total_fee;

parse_str($PHP_QUERYSTRING, $URL);

$arg = array();
foreach($URL as $key=>$val)
{
	if($key != 'sign' && $key != 'sign_type' && $val != '')
	{
        $arg[] = $key.'='.$val;
	}
}
$arg = implode('&', $arg);
$get_sign = md5($arg.$keycode);

$result = @file('http://notify.alipay.com/trade/notify_query.do?partner='.$partnerid.'&notify_id='.$notify_id);
if($get_sign == $sign)
{
	if(trim($result[0]) == 'true')
	{
		$info = dopay($orderid, $amount, $pmode);
        if($info)
		{
			$paystatus = 1;
			extract($info, EXTR_OVERWRITE);
		}
	}
	else
	{
		$paystatus = 2;
	}
}
else
{
	$paystatus = 0;
}
?>