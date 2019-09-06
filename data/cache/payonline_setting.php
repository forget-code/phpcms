<?php
 return array (
  'chinabank' => 
  array (
    'id' => '1',
    'paycenter' => 'chinabank',
    'name' => '网银在线',
    'logo' => 'http://merchant.chinabank.com.cn/images/logo.gif',
    'sendurl' => 'https://pay.chinabank.com.cn/select_bank',
    'receiveurl' => 'http://www.***.com/pay/payonline_receive.php',
    'partnerid' => '',
    'keycode' => '',
    'percent' => '0',
    'enable' => '1',
  ),
  'alipay' => 
  array (
    'id' => '2',
    'paycenter' => 'alipay',
    'name' => '支付宝',
    'logo' => 'http://img.alipay.com/img/logo/logo_126x37.gif',
    'sendurl' => 'http://www.alipay.com/cooperate/gateway.do',
    'receiveurl' => 'http://www.***.com/pay/payonline_receive.php',
    'partnerid' => '',
    'keycode' => '',
    'percent' => '0',
    'enable' => '1',
  ),
);
?>