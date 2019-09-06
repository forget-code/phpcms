<?PHP
defined('IN_PHPCMS') or exit('Access Denied');
$c_pass =trim($keycode);
$srcStr = $c_mid . $c_order . $c_orderamount . $c_ymd . $c_transnum . $c_succmark . $c_moneytype . $c_memo1 . $c_memo2 . $c_pass;
$r_signstr	= md5($srcStr);
//--校验商户网站对通知信息的MD5加密的结果和云网支付网关提供的MD5加密结果是否一致
if($r_signstr==$c_signstr)
{
	$info = dopay($c_order,$c_orderamount, '未知');
	if($info)
	{
		$paystatus = 1;
		extract($info, EXTR_OVERWRITE);
	}
}
else
{
	$paystatus = 0;
}
?>