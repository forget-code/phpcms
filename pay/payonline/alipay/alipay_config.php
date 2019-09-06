<?php
$partner = $partnerid;//合作伙伴ID
$security_code = $keycode;//安全检验码
$seller_email = $MOD['alipay'];//卖家邮箱
$_input_charset = "GBK"; //字符编码格式  目前支持 GBK 或 utf-8
$sign_type = "MD5"; //加密方式  系统默认(不要修改)
$transport= "https";//访问模式,你可以根据自己的服务器是否支持ssl访问而选择http以及https访问模式(系统默认,不要修改)
$notify_url = $receiveurl;// 异步返回地址
$return_url = $receiveurl; //同步返回地址
$show_url   = $PHP_SITEURL;  //你网站商品的展示地址,可以为空

/** 提示：如何获取安全校验码和合作ID
1.访问 www.alipay.com，然后登陆您的帐户($seller_email).
  2.点击右上角的“商家工具”.
  3.在网站集成目录下，选择适合您的交易方式，然后点击点此申请.
  4.填写好申请表格，点击下一步，您可以看到一段32位的字符串—就是安全校验($security_code).
  5.合作ID在安全校验码下方($partner).
*/
?>