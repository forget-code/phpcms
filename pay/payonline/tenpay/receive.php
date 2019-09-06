<meta name="TENCENT_ONELINE_PAYMENT" content="China TENCENT">
<?php
defined('IN_PHPCMS') or exit('Access Denied');
/*取返回参数*/
$strCmdno= $cmdno;
$strPayResult= $pay_result;
$strPayInfo= $pay_info;
$strBillDate= $date;
$strBargainorId	= $bargainor_id;
$strTransactionId= $transaction_id;
$strSpBillno= $sp_billno;
$strTotalFee= $total_fee;
$strFeeType= $fee_type;
$strAttach= $attach;
$strMd5Sign= $sign;
/*本地参数*/
/*这里替换为您的实际商户号*/
$strSpid    = $partnerid;
/*商户密钥,测试时即为商户号,正式上线后需修改*/
$strSpkey   =$keycode;
/*返回值定义*/
$iRetOK= 0;		// 成功
$iInvalidSpid= 1;		// 商户号错误
$iInvalidSign= 2;		// 签名错误
$iTenpayErr= 3;		// 财付通返回支付失败
/*验签*/
$strResponseText  = 'cmdno=' . $strCmdno . '&pay_result=' . $strPayResult . '&date=' . $strBillDate . '&transaction_id=' . $strTransactionId .'&sp_billno=' . $strSpBillno . '&total_fee=' . $strTotalFee .'&fee_type=' . $strFeeType . '&attach=' . $strAttach .'&key=' . $strSpkey;
$strLocalSign = strtoupper(md5($strResponseText));
$strPayResult=0?$status=1:$status=0;

if($strLocalSign== $strMd5Sign && $strSpid == $strBargainorId )
{
	$info = dopay($strSpBillno,$strTotalFee/100, '未知');
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
