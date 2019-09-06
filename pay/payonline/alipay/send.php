<?php
$interfaceurl	 =	"https://www.alipay.com/cooperate/gateway.do?";
$service         =  $MOD['alipay_service'];
$partner		 =  $partnerid;		//partner		合作伙伴ID			保留字段
$sign_type       =  "MD5";
$subject		 =	$LANG['account_charge'];		//subject		商品名称
$body			 =	$LANG['account_charge'];			//body			商品描述
$out_trade_no    =  $orderid;
$total_fee		 =	$amount;				//price			商品单价			0.01～50000.00
$discount        =  "0.00";
$show_url        =  $PHP_SITEURL;
$quantity        =  "1";
$payment_type    =  $MOD['alipay_service'] == 'trade_create_by_buyer' ? '1' : '2';
$seller_email    =  $MOD['alipay'];             //支付宝帐号
$key             =  $keycode;  //支付宝安全校验码
$notify_url      =  $receiveurl; //支付宝通知页面
$return_url      =  $receiveurl;    //支付宝跳转页面
$receive_name    =  $contactname;
$buyer_email     =  $email;
$receive_phone   =  $telephone;
$logistics_type  =  $MOD['alipay_service'] == 'trade_create_by_buyer' ? 'EXPRESS' : 'VIRTUAL';

$geturl	= new alipay_payto;
$url	= $geturl->geturl($service,$sign_type,$subject,$body,$out_trade_no,$total_fee,$discount,$show_url,$quantity,$payment_type,$seller_email,$notify_url,$return_url,$key,$partner,$interfaceurl,$receive_name,$buyer_email,$receive_phone,$logistics_type);

class alipay_payto
{
	function geturl($s1,$s2,$s3,$s4,$s5,$s6,$s7,$s8,$s9,$s10,$s17,$s18,$s19,$s20,$s21,$s22,$s23,$s24,$s25,$s26)
	{
		$parameter = array(
				'service'			=> 'service='.$s1."&",
				'subject'			=> 'subject='.$s3,
				'body'		        => 'body='.$s4."&",
				'out_trade_no'		=> 'out_trade_no='.$s5."&",
				'total_fee'			=> 'price='.$s6."&",
				'discount'			=> 'discount='.$s7."&",
				'show_url'		=> 'show_url='.$s8."&",
				'quantity'		=> 'quantity='.$s9."&",
				'payment_type'	=> 'payment_type='.$s10."&",
			    'seller_email'=> 'seller_email='.$s17."&",
				'notify_url'	=> 'notify_url='.$s18."&",
				'return_url'	=> 'return_url='.$s19."&",
				'partner'	=> 'partner='.$s21."&",
				'receive_name'	=> 'receive_name='.$s23."&",
				'buyer_email'	=> 'buyer_email='.$s24."&",
				'receive_phone'	=> 'receive_phone='.$s25."&",
		);
		if($s1 == 'trade_create_by_buyer')
		{
			$parameter['logistics_type'] = 'logistics_type='.$s26.'&';
			$parameter['logistics_fee'] = 'logistics_fee=0&';
			$parameter['logistics_payment'] = 'logistics_payment=SELLER_PAY&';
		}
		asort($parameter);
		foreach($parameter as $key => $value){
			if($value){
					$mystr  .= $value;
			}
		}
		$url = $s22.$mystr;
		$mystr=$mystr.$s20;
		$url  .= "&sign=".md5($mystr)."&sign_type=".$s2;
		return $url;
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8'charset']?>">
<title>正在跳转到支付平台...</title>
<meta http-equiv="refresh" content="0;URL=<?=$url?>">
</head>
<body>
</body>
</html>