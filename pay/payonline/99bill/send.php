<?PHP
defined('IN_PHPCMS') or exit('Access Denied');
$merchant_id = $partnerid;		///商户编号
$merchant_key = $keycode;		///商户密钥
$orderid =trim($orderid);		///订单编号
$amount = trim($amount);		///订单金额
$curr = '1';		///货币类型,1为人民币
$isSupportDES = '2';		///是否安全校验,2为必校验,推荐
$merchant_url = $receiveurl;		///支付结果返回地址
$pname = $_username;		///支付人姓名
$commodity_info = $LANG['account_charge'];		///商品信息
$merchant_param = 'phpcms';		///商户私有参数
$pemail=trim($email);		///传递email到快钱网关页面
$pid='phpcms';		///代理/合作伙伴商户编号
//生成加密串,注意顺序
$ScrtStr='merchant_id='.$merchant_id.'&orderid='.$orderid.'&amount='.$amount.'&merchant_url='.$merchant_url.'&merchant_key='.$merchant_key;
$mac = strtoupper(md5($ScrtStr));
$link=$sendurl.$ScrtStr.'&mac='.$mac.'&merchant_url='.$merchant_url.'&pname='.$pname.'&commodity_info='.$commodity_info.'&merchant_param='.$merchant_param.'&pemail='.$pemail.'&pid='.$pid;
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