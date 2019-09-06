<?php
define('MOD_ROOT', substr(dirname(__FILE__), 0, -4));

$mod = 'pay';
require substr(MOD_ROOT, 0, -strlen($mod)).'/include/common.inc.php';
require_once MOD_ROOT.'/include/pay.func.php';
require_once PHPCMS_ROOT.'/include/form.class.php';
$pay_code = 'chinabank';

$plugin_file = PHPCMS_ROOT.'pay/include/payment/'.$pay_code.'.php';
if (is_file($plugin_file))
{
	include_once( $plugin_file );
	$payment = new $pay_code();
	$result = $payment->respond();
	if ($result)
	{
		exit("ok");
	}
	else if($payment->err)
	{
		exit("error");
	}
	else
	{
		exit("error");
	}
}
else
{
	exit("error");
}
?>