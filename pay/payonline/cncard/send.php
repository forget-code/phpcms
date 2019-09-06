<?PHP
defined('IN_PHPCMS') or exit('Access Denied');
$c_mid		=$partnerid;						//商户编号，在申请商户成功后即可获得，可以在申请商户成功的邮件中获取该编号
$c_order	= trim($orderid);					    //商户网站依照订单号规则生成的订单号，不能重复
//$c_name		= "张三";						//商户订单中的收货人姓名
//$c_address	= "北京市朝阳区XX";				//商户订单中的收货人地址
//$c_tel		= "010-12345678";				//商户订单中的收货人电话
//$c_post		= "100001";						//商户订单中的收货人邮编
//$c_email	= "YourEmail@HostName.com";		//商户订单中的收货人Email
$c_orderamount =trim($amount);					//商户订单总金额
$c_ymd		= date('Ymd');					//商户订单的产生日期，格式为"yyyymmdd"，如20050102
$c_moneytype= "0";							//支付币种，0为人民币
$c_retflag	= "1";							//商户订单支付成功后是否需要返回商户指定的文件，0：不用返回 1：需要返回
$c_paygate	= "";							//如果在商户网站选择银行则设置该值，具体值可参见《云网支付@网技术接口手册》附录一；如果来云网支付@网选择银行此项为空值。
$c_returl	= $receiveurl;	//如果c_retflag为1时，该地址代表商户接收云网支付结果通知的页面，请提交完整文件名(对应范例文件：GetPayNotify.php)
$c_memo1	= "ABCDE";						//商户需要在支付结果通知中转发的商户参数一
$c_memo2	= "123456";						//商户需要在支付结果通知中转发的商户参数二
$c_pass		= $keycode;						//支付密钥，请登录商户管理后台，在帐户信息-基本信息-安全信息中的支付密钥项
$notifytype	= "1";							//0普通通知方式/1服务器通知方式，空值为普通通知方式
$c_language	= "0";							//对启用了国际卡支付时，可使用该值定义消费者在银行支付时的页面语种，值为：0银行页面显示为中文/1银行页面显示为英文

$srcStr = $c_mid . $c_order . $c_orderamount . $c_ymd . $c_moneytype . $c_retflag . $c_returl . $c_paygate . $c_memo1 . $c_memo2 . $notifytype  . $c_pass;
//说明：如果您想指定支付方式(c_paygate)的值时，需要先让用户选择支付方式，然后再根据用户选择的结果在这里进行MD5加密，也就是说，此时，本页面应该拆分为两个页面，分为两个步骤完成。

//--对订单信息进行MD5加密
//商户对订单信息进行MD5签名后的字符串
$c_signstr	= md5($srcStr);
$link=$sendurl.'c_mid='.$c_mid . '&c_order='.$c_order . '&c_orderamount='.$c_orderamount . '&c_ymd='.$c_ymd . '&c_moneytype='.$c_moneytype . '&c_retflag='.$c_retflag . '&c_returl='.$c_returl . '&c_paygate='.$c_paygate . '&c_memo1='.$c_memo1 . '&c_memo2='.$c_memo2 . '&notifytype='.$notifytype .'&c_signstr='.$c_signstr;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8'charset']?>">
<title>正在跳转到支付平台...</title>
<meta http-equiv="refresh" content="0;URL=<?=$link?>" method="post">
</head>
<body>
正在跳转到支付平台...
</body>
</html>