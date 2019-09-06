<?php
require_once("alipay_config.php");
require_once("alipay_notify.php");
$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
$verify_result = $alipay->return_verify();

 //获取支付宝的反馈参数
	$orderid = $out_trade_no; //获取订单号
	$amount = $total_fee;//获取总价格   
 
   /* $receive_name    =$_GET['receive_name'];   //获取收货人姓名
	$receive_address =$_GET['receive_address']; //获取收货人地址
	$receive_zip     =$_GET['receive_zip'];  //获取收货人邮编
	$receive_phone   =$_GET['receive_phone']; //获取收货人电话
	$receive_mobile  =$_GET['receive_mobile']; //获取收货人手机
	*/
  

if($verify_result) {
	$info = dopay($orderid, $amount, '未知');
        if($info)
		{
			$paystatus = 1;
			extract($info, EXTR_OVERWRITE);
		}
		else
	{
		$paystatus = 2;
	}
	//这里放入你自定义代码,比如根据不同的trade_status进行不同操作
	log_result("verify_success"); //将验证结果存入文件	
}
else  {
	$paystatus = 0;
	//这里放入你自定义代码，这里放入你自定义代码,比如根据不同的trade_status进行不同操作
	log_result ("verify_failed");
}

//日志消息,把支付宝反馈的参数记录下来
function  log_result($word) { 
	$fp = fopen("log.txt","a");	
	flock($fp, LOCK_EX) ;
	fwrite($fp,$word."：执行日期：".strftime("%Y%m%d%H%I%S",time())."\t\n");
	flock($fp, LOCK_UN); 
	fclose($fp);
}
	
?>