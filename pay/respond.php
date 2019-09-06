<?php
require './include/common.inc.php';
$pay_code = trim($code);
if(empty($pay_code) || !in_array($pay_code,array('alipay','bank','chinabank','post','tenpay')))
{
	showmessage('校验失败');
}
else
{
	$plugin_file = PHPCMS_ROOT.'pay/include/payment/'.$pay_code.'.php';
	if (is_file($plugin_file))
	{
		include_once( $plugin_file );
		$payment = new $pay_code();
		$result = $payment->respond();
		if ($result)
		{
            $forward = get_cookie('orderid')?get_cookie('orderid'):'pay/online.php';
            showmessage('支付成功',$forward);
		}
		else if($payment->err)
		{
			showmessage($payment->err);
		}
		else
		{
			showmessage('支付失败');
		}
	}
	else
	{
		showmessage("支付方式不存在");
	}
}
?>
