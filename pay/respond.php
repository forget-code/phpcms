<?php
require './include/common.inc.php';
$pay_code = !empty($code) ? trim( $code ) : "";
if ( empty( $pay_code ) )
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
			//支付成功的处理信息
            $forward = get_cookie('orderid')?get_cookie('orderid'):'pay/online.php';
            showmessage('支付成功',$forward);
		}
		else if ( $payment->err )
		{
			$msg = $payment->err;
			showmessage($msg);
		}
		else
		{
			$msg = "支付失败";
			showmessage($msg);
		}
	}
	else
	{
		showmessage("支付方式不存在");
	}
}
?>
