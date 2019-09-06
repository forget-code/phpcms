<?php
$v_mid = $partnerid;								// 商户号，这里为测试商户号20000400，替换为自己的商户号即可
$v_url = $receiveurl;	                            // 请填写返回url
$key = $keycode;									// 如果您还没有设置MD5密钥请登陆我们为您提供商户后台，地址：https://merchant3.chinabank.com.cn/

$v_oid = trim($orderid); 
$v_amount = trim($amount);                   //支付金额                 
$v_moneytype = 'CNY';                        //币种

$text = $v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key;         //md5加密拼凑串,注意顺序
$v_md5info = strtoupper(md5($text));                              //md5函数加密并转化成大写字母

$remark1 = isset($remark1) ? trim($remark1) : '';					  //备注字段1
$remark2 = isset($remark2) ? trim($remark2) : '';                      //备注字段2

//***************以下几项与网上支付货款无关，建议不用**************
$v_rcvname   = isset($contactname) ? trim($contactname) : '';		// 收货人
$v_rcvaddr   = isset($v_rcvaddr) ? trim($v_rcvaddr) : '';		// 收货地址
$v_rcvtel    = isset($telephone) ? trim($telephone) : '';		// 收货人电话
$v_rcvpost   = isset($v_rcvpost) ? trim($v_rcvpost) : '';		// 收货人邮编
$v_rcvemail  = isset($email) ? trim($email) : '';		    // 收货人邮件
$v_rcvmobile = isset($v_rcvmobile) ? trim($v_rcvmobile) : '';		// 收货人手机号
$v_ordername   = isset($contactname) ? trim($contactname) : '';	// 订货人姓名
$v_orderaddr   = isset($v_orderaddr) ? trim($v_orderaddr) : '';	// 订货人地址
$v_ordertel    = isset($telephone) ? trim($telephone) : '';	// 订货人电话
$v_orderpost   = isset($v_orderpost) ? trim($v_orderpost) : '';	// 订货人邮编
$v_orderemail  = isset($email) ? trim($email) : '';	        // 订货人邮件
$v_ordermobile = isset($v_ordermobile) ? trim($v_ordermobile) : '';	// 订货人手机号 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8'charset']?>">
<title>正在跳转到支付平台...</title>
</head>
<body onLoad="javascript:document.E_FORM.submit()">
<p align="center">正在跳转到支付平台...</p>
<form method="post" name="E_FORM" action="<?=$sendurl?>">
<input type="hidden" name="v_mid"       value="<?php echo $v_mid;?>">
<input type="hidden" name="v_oid"       value="<?php echo $v_oid;?>">
<input type="hidden" name="v_amount"    value="<?php echo $v_amount;?>">
<input type="hidden" name="v_moneytype" value="<?php echo $v_moneytype;?>">
<input type="hidden" name="v_url"       value="<?php echo $v_url;?>">
<input type="hidden" name="v_md5info"   value="<?php echo $v_md5info;?>">
<input type="hidden" name="remark1"     value="<?php echo $remark1;?>">
<input type="hidden" name="remark2"     value="<?php echo $remark2;?>">
<!--以下几项与网上支付货款无关，建议不用//-->
<input type="hidden" name="v_rcvname"    value="<?php echo $v_rcvname;?>">
<input type="hidden" name="v_rcvtel"     value="<?php echo $v_rcvtel;?>">
<input type="hidden" name="v_rcvpost"    value="<?php echo $v_rcvpost;?>">
<input type="hidden" name="v_rcvaddr"    value="<?php echo $v_rcvaddr;?>">
<input type="hidden" name="v_rcvemail"    value="<?php echo $v_rcvemail;?>">
<input type="hidden" name="v_rcvmobile"    value="<?php echo $v_rcvmobile;?>">

<input type="hidden" name="v_ordername"  value="<?php echo $v_ordername;?>">
<input type="hidden" name="v_orderaddr"    value="<?php echo $v_orderaddr;?>">
<input type="hidden" name="v_orderpost"    value="<?php echo $v_orderpost;?>">
<input type="hidden" name="v_ordertel"     value="<?php echo $v_ordertel;?>">
<input type="hidden" name="v_ordermobile"  value="<?php echo $v_ordermobile;?>">
<input type="hidden" name="v_orderemail" value="<?php echo $v_orderemail;?>">
</form>
</body>
</html>