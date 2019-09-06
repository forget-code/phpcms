<html>
<title>财付通支付转跳接口</title>
<meta http-equiv="Cache-Control" content="no-cache"/>
<body>
<?php
defined('IN_PHPCMS') or exit('Access Denied');
/*这里替换为您的实际商户号*/
$strSpid    =  $partnerid;
/*strSpkey是32位商户密钥, 请替换为您的实际密钥*/
$strSpkey   =  $keycode;
/*财付通支付为"1" (当前只支持 cmdno=1)*/
$strCmdNo   = '1';
/*交易日期 (yyyymmdd)*/
$strBillDate= date('Ymd');
/*银行类型:
  0		  财付通
		1001	招商银行
		1002	中国工商银行
		1003	中国建设银行
		1004	上海浦东发展银行
		1005	中国农业银行
		1006	中国民生银行
		1008	深圳发展银行
		1009	兴业银行   */
$strBankType= '0';
/*商品名称*/
$strDesc    =$LANG['account_charge'];
/*用户QQ号码, 现在置为空串*/
$strBuyerId = '';
/*商户号*/
$strSaler   = $strSpid;
/*商户生成的订单号(最多10位)*/
$strSpBillNo=$orderid;
/*重要: 交易单号
  交易单号(28位): 商户号(10位) + 日期(8位) + 流水号(10位), 必须按此格式生成, 且不能重复
  如果sp_billno超过10位, 则截取其中的流水号部分加到transaction_id后部(不足10位左补0)
  如果sp_billno不足10位, 则左补0, 加到transaction_id后部*/
$strTransactionId = $strSpid . $strBillDate . $strSpBillNo;
/*总金额, 分为单位*/
$strTotalFee = $amount*100;
/*货币类型: 1 – RMB(人民币) 2 - USD(美元) 3 - HKD(港币)*/
$strFeeType  = '1';
/*财付通回调页面地址, 推荐使用ip地址的方式(最长255个字符)*/
$strRetUrl  =$receiveurl;
/*商户私有数据, 请求回调页面时原样返回*/
$strAttach  = 'phpcms';
/*生成MD5签名*/
$strSignText = 'cmdno=' . $strCmdNo . '&date=' . $strBillDate . '&bargainor_id=' . $strSaler .'&transaction_id=' . $strTransactionId . '&sp_billno=' . $strSpBillNo .'&total_fee=' . $strTotalFee . '&fee_type=' . $strFeeType . '&return_url=' . $strRetUrl .'&attach=' . $strAttach . '&key=' . $strSpkey;
$strSign = strtoupper(md5($strSignText));
/*请求支付串*/
$strRequest = 'cmdno=' . $strCmdNo . '&date=' . $strBillDate . '&bargainor_id=' . $strSaler .'&transaction_id=' . $strTransactionId . '&sp_billno=' . $strSpBillNo .'&total_fee=' . $strTotalFee . '&fee_type=' . $strFeeType . '&return_url=' . $strRetUrl .'&attach=' . $strAttach . '&bank_type=' . $strBankType . '&desc=' . $strDesc .'&purchaser_id=' . $strBuyerId .'&sign=' . $strSign ;
$link=$sendurl.$strRequest;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8'charset']?>">
<title>正在跳转到支付平台...</title>
<meta http-equiv="refresh" content="0;URL=<?=$link?>">
</head>
<body>
</body>
</html>