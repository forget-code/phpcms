<?php
defined('IN_PHPCMS') or exit('Access Denied');

$payment_lang = 'languages/'.LANG.'/payment/chinabank.php';

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
    $modules[$i]['desc']    = 'chinabank_desc';

    /* 是否支持货到付款 */
    $modules[$i]['is_cod']  = '0';

    /* 是否支持在线支付 */
    $modules[$i]['is_online']  = '1';

    /* 支付费用 */
    $modules[$i]['pay_fee'] = '2.5%';

    /* 作者 */
    $modules[$i]['author']  = 'PHPCMS TEAM';

    /* 网址 */
    $modules[$i]['website'] = 'http://www.chinabank.com.cn';

    /* 版本号 */
    $modules[$i]['version'] = '1.0.0';

    /* 配置信息 */
    $modules[$i]['config'] = array(
        array('name' => 'chinabank_account', 'type' => 'text', 'value' => ''),
        array('name' => 'chinabank_key',     'type' => 'text', 'value' => ''),
    );

    return;
}

/**
 * 类
 */
class chinabank
{
	var $err = '';
    /**
     * 生成支付代码
     * @param   array   $order      订单信息
     * @param   array   $payment    支付方式信息
     */
    function get_code($order, $payment)
    {
        $data_vid           = trim($payment['chinabank_account']);
        $data_orderid       = $order['order_sn'];
        $data_vamount       = $order['order_amount'];
        $data_vmoneytype    = 'CNY';
        $data_vpaykey       = trim($payment['chinabank_key']);
        $data_vreturnurl    = return_url('chinabank');
		
		$v_ordername   = trim($order['contactname']);	// 订货人姓名
		$v_ordertel    = trim($order['telephone']);	// 订货人电话
		$v_orderemail  = trim($order['email']);	// 订货人邮件
		$remark1  = htmlspecialchars($order['remark1']);	// 备注


        $MD5KEY =$data_vamount.$data_vmoneytype.$data_orderid.$data_vid.$data_vreturnurl.$data_vpaykey;
        $MD5KEY = strtoupper(md5($MD5KEY));

        $def_url  = '<form style="text-align:left;" method=post action="https://pay3.chinabank.com.cn/PayGate" target="_blank">';
        $def_url .= "<input type='hidden' name='v_mid' value='".$data_vid."'>";
        $def_url .= "<input type='hidden' name='v_oid' value='".$data_orderid."'>";
        $def_url .= "<input type='hidden' name='v_amount' value='".$data_vamount."'>";
        $def_url .= "<input type='hidden' name='v_moneytype'  value='".$data_vmoneytype."'>";
        $def_url .= "<input type='hidden' name='v_url'  value='".$data_vreturnurl."'>";
        $def_url .= "<input type='hidden' name='v_ordername'  value='".$v_ordername."'>";
        $def_url .= "<input type='hidden' name='v_ordertel'  value='".$v_ordertel."'>";
        $def_url .= "<input type='hidden' name='v_orderemail'  value='".$v_orderemail."'>";
        $def_url .= "<input type='hidden' name='remark1'  value='".$remark1."'>";
        $def_url .= "<input type='hidden' name='v_md5info' value='".$MD5KEY."'>";
        $def_url .= "<input type=submit value='立即使用网银在线支付'>";
        $def_url .= "</form>";

        return $def_url;
    }

    /**
     * 响应操作
     */
    function respond()
    {
        $payment        = get_payment(basename(__FILE__, '.php'));
		echo $v_oid          = trim($_POST['v_oid']);
        $v_pmode        = trim($_POST['v_pmode']);
        $v_pstatus      = trim($_POST['v_pstatus']);
        $v_pstring      = trim($_POST['v_pstring']);
        $v_amount       = trim($_POST['v_amount']);
        $v_moneytype    = trim($_POST['v_moneytype']);
        $remark1        = trim($_POST['remark1' ]);
        $remark2        = trim($_POST['remark2' ]);
        $v_md5str       = trim($_POST['v_md5str' ]);
		$total = floatval($v_amount);

		$key            = $payment['chinabank_key'];

        $md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));

        ///* 检查秘钥是否正确 */
        if ($v_md5str == $md5string)
        {
            if ($v_pstatus == '20')
            {
                if(changeorder($v_oid))
                {
                    return true;
                }
            }
        }
        else
        {
			$this->err = '校验失败，若您的确已经在网关处被扣了款项，请及时联系店主，并且请不要再次点击支付按钮(原因：错误的签名)';
            return false;
        }
    }
}

?>