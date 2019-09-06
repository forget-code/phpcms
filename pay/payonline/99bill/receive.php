<?PHP
defined('IN_PHPCMS') or exit('Access Denied');
$merchant_key =trim($keycode);		///商户密钥
$merchant_id =trim($partnerid);			///获取商户编号
$orderid = trim($orderid);		///获取订单编号
$amount =trim($amount);	///获取订单金额
$dealdate = trim($date);		///获取交易日期
$succeed = trim($succeed);	///获取交易结果,Y成功,N失败
$mac = trim($mac);		///获取安全加密串
$merchant_param = trim($merchant_param);		///获取商户私有参数
//生成加密串,注意顺序
$ScrtStr = 'merchant_id='.$merchant_id.'&orderid='.$orderid.'&amount='.$amount.'&date='.$dealdate.'&succeed='.$succeed.'&merchant_key='.$merchant_key;
$mymac = md5($ScrtStr);
$succeed=='Y'?$status=2:$status=0;
if(strtoupper($mac)==strtoupper($mymac))
{
	if($succeed=='Y')
	{	///支付成功
		$info = dopay($orderid, $amount, '未知');
	    if($info)
		{
			$paystatus = 1;
			extract($info, EXTR_OVERWRITE);
		}
	}
}
else
{
	$paystatus = 0;
}
?>