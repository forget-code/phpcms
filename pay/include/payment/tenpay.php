<?php

$payment_lang = 'languages/' .LANG. '/payment/tenpay.php';

if (file_exists($payment_lang))
{
    global $LANG;

    include_once($payment_lang);
}

/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* 代码 */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* 描述对应的语言项 */
    $modules[$i]['desc']    = 'tenpay_desc';

    /* 是否支持货到付款 */
    $modules[$i]['is_cod']  = '0';

    /* 是否支持在线支付 */
    $modules[$i]['is_online']  = '1';

    /* 作者 */
    $modules[$i]['author']  = 'PHPCMS TEAM';

    /* 网址 */
    $modules[$i]['website'] = 'http://www.tenpay.com';

    /* 版本号 */
    $modules[$i]['version'] = '1.0.0';

    /* 配置信息 */
    $modules[$i]['config']  = array(
		 array( "name" => "tenpay_account", "type" => "text", "value" => "" ),
        array( "name" => "tenpay_key", "type" => "text", "value" => "" ),
        array( "name" => "tenpay_type", "type" => "select", "value" => "1" )
    );

    return;
}

/**
 * 类
 */
class tenpay
{
	var $err = '';
    /**
     * 生成支付代码
     * @param   array    $order       订单信息
     * @param   array    $payment     支付方式信息
     */
    function get_code($order, $payment)
    {
        $cmd_no = '1';
        /* 获得订单的流水号，补零到10位 */
        $sp_billno = $order['order_sn'];

        /* 交易日期 */
        $today = date('Ymd');
        /* 将商户号+年月日+流水号 */
        $bill_no = $order['orderid'];
        $bill_no = str_pad($bill_no, 10, 0, STR_PAD_LEFT);
        $transaction_id = $payment['tenpay_account'].$today.$bill_no;
        //$transaction_id = '1202437801200512190000012138';
        /* 银行类型:支持纯网关和财付通 */
        $bank_type = '0';

        /* 订单描述，用订单号替代 */

        $desc = $order['order_sn'];
        $attach = 'voucher';


        /* 返回的路径 */
        $return_url  = return_url(basename(__FILE__, '.php'));

        /* 总金额 */
        $total_fee = floatval($order['order_amount']) * 100;

        /* 货币类型 */
        $fee_type = '1';

        /* 重写自定义签名 */
        //$payment['magic_string'] = abs(crc32($payment['magic_string']));

        /* 数字签名 */
        $sign_text = "cmdno=" . $cmd_no . "&date=" . $today . "&bargainor_id=" . $payment['tenpay_account'] .
          "&transaction_id=" . $transaction_id . "&sp_billno=" . $sp_billno .
          "&total_fee=" . $total_fee . "&fee_type=" . $fee_type . "&return_url=" . $return_url .
          "&attach=" . $attach . "&key=" . $payment['tenpay_key'];
        $sign = strtoupper(md5($sign_text));

        /* 交易参数 */
        $parameter = array(
            'cmdno'             => $cmd_no,                     // 业务代码, 财付通支付支付接口填  1
            'date'              => $today,                      // 商户日期：如20051212
            'bank_type'         => $bank_type,                  // 银行类型:支持纯网关和财付通
            'desc'              => $desc,                       // 交易的商品名称
            'purchaser_id'      => '',                          // 用户(买方)的财付通帐户,可以为空
            'bargainor_id'      => $payment['tenpay_account'],  // 商家的财付通商户号
            'transaction_id'    => $transaction_id,             // 交易号(订单号)，由商户网站产生(建议顺序累加)
            'sp_billno'         => $sp_billno,                    // 商户系统内部的定单号,最多10位
            'total_fee'         => $total_fee,                  // 订单金额
            'fee_type'          => $fee_type,                   // 现金支付币种
            'return_url'        => $return_url,                 // 接收财付通返回结果的URL
            'attach'            => $attach,                     // 用户自定义签名
            'sign'              => $sign                       // MD5签名
        );

        $button  = '<form style="text-align:left;" action="https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi" target="_blank" >';

        foreach ($parameter AS $key=>$val)
        {
            $button  .= "<input type='hidden' name='$key' value='$val' />";
        }
        $button  .= '<input type="submit" value="立即使用财付通支付" /></form><br />';

        return $button;
    }

    /**
     * 响应操作
     */
    function respond()
    {
        /*取返回参数*/
		/*取返回参数*/
        $cmd_no         = $_GET['cmdno'];
        $pay_result     = $_GET['pay_result'];
        $pay_info       = $_GET['pay_info'];
        $bill_date      = $_GET['date'];
        $bargainor_id   = $_GET['bargainor_id'];
        $transaction_id = $_GET['transaction_id'];
        $sp_billno      = $_GET['sp_billno'];
        $total_fee      = $_GET['total_fee'];
        $fee_type       = $_GET['fee_type'];
        $attach         = $_GET['attach'];
        $sign           = $_GET['sign'];

        $payment    = get_payment('tenpay');

        $sign_text  = "cmdno=" . $cmd_no . "&pay_result=" . $pay_result .
                          "&date=" . $bill_date . "&transaction_id=" . $transaction_id .
                            "&sp_billno=" . $sp_billno . "&total_fee=" . $total_fee .
                            "&fee_type=" . $fee_type . "&attach=" . $attach .
                            "&key=" . $payment['tenpay_key'];
        $sign_md5 = strtoupper(md5($sign_text));
        if ($sign_md5 != $sign)
        {
            $this->err = '校验失败，若您的确已经在网关处被扣了款项，请及时联系店主，并且请不要再次点击支付按钮(原因：错误的签名)';
			return false;
        }
        elseif ($pay_result == 0)
        {
            /* 改变订单状态 */
            if(changeorder($sp_billno))
            {
                return true;
            }
        }
		else
		{
			//支付失败，请根据retcode进行错误逻辑处理
			return false;
		}
    }
}

?>