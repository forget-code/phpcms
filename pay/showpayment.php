<?php
require './include/common.inc.php';
require MOD_ROOT.'/include/payonline.class.php';
require_once 'times.class.php';
$times = new times();
$times->set('recharge', 3600, 1);
$payinfo = new payonline();
switch ($action)
{
	case 'type':
		$pay = trim($pay);
		if ('' == $pay)
		{
			include template('pay', 'showpayment_view');
		}
		else
		{
			if(!in_array($pay,array('offline','online','card'))) showmessage('非法参数');
			if('offline' == $pay)
			{
				$offlines = $payinfo->get_offline();
			}
			if ('online' == $pay)
			{
				$onlines = $payinfo->get_online();
			}
            if('card' == $pay)
            {
                if($M['maxtopfailedtimes'])
                {
                    $times = new times();
                    $times->set('recharge', $M['maxiplockedtime']*3600, $M['maxtopfailedtimes']);
                    if($times->check()) showmessage('充值失败超过'.$M['maxtopfailedtimes'].'次！<br />您的IP已经被系统锁定，'.$M['maxiplockedtime'].'小时后将自动解除锁定。', SITE_URL);
                }
            }
			include template('pay' , $pay.'_view');
		}
	break;
	case 'online':
		if(!is_email($email) || $email == '')  $email = '';
		$order['email'] = $email;
        checkcode($checkcode,$M['ischeckcode']);
		if(empty($amount))
        {
            showmessage("请输入正确的金额",'pay/showpayment.php?action=type&pay=online');
        }
        else
        {
            $amount = floatval($amount);
        }
		if (!$paymentid)
        {
            showmessage("请输选择支付方式",'pay/showpayment.php?action=type&pay=online');
        }
        else
        {
            $paymentid = intval($paymentid);
        }
        set_cookie('orderid', $forward);
		session_start();
		$order['contactname'] = $contactname	= new_htmlspecialchars($contactname);
		$order['remark1'] = htmlspecialchars($usernote);//备注
		
		$order['telephone'] = $telephone		= safe_replace($telephone);
		//产生订单号
		$_SESSION['order_sn'] = $order['order_sn']	= create_sn();
		$_SESSION['order_sn_time'] = TIME;

		$payment = $payinfo->get_payment($paymentid);
		if(!$payment) showmessage('支付方式错误');
		$payment['config']		= $payinfo->unserialize_config($payment['config']);

		$payment['pay_fee']		= pay_fee($amount, $payment['pay_fee'].'%');//计算支付手续费
		$order['order_amount']	= $amount + $payment['pay_fee'];//实际要支付的金额
		//支付记录
		$online['amount'] = $order['order_amount'];
		$online['moneytype'] = 'CNY';//支付币种
		 /* 变量初始化 */
		$surplus = array(
				'userid'      => $_userid,
				'username'    => $_username,
				'amount'      => $order['order_amount'],//$amount,
                'quantity'    => $amount,
				'telephone'   => $telephone,
				'contactname' => $contactname,
				'addtime'	  => TIME,
				'type'		  => '1',
				'payment'     => $payment['pay_name'],
				'ispay'	  => '0',
				'usernote'    => isset($usernote) ? new_htmlspecialchars($usernote) : '',
				'sn'		   => $order['order_sn']
		);
		$order['orderid'] = $payinfo->set_offline( $surplus );
		include_once('include/payment/' . $payment['pay_code'] . '.php');
        $pay_obj    = new $payment['pay_code'];
		$pay_online = $pay_obj->get_code($order, $payment['config']);
		$order['pay_desc'] = $payment['pay_desc'];
		include template('pay','showmessage');
	break;
	case 'card':
		$cardid = trim($cardid);
        checkcode($checkcode,1,HTTP_REFERER);
		if(!$payinfo->set_card($cardid, $cardtype))
		{
            if($M['maxtopfailedtimes'])
            {
                $times->add();
            }
			showmessage($payinfo->error(),'pay/showpayment.php?action=type&pay=card');
		}else
		{
			showmessage("充值成功!",'pay/pay.php');
		}
	break;
	case 'verified':
		if ($dosubmit)
		{
            checkcode($checkcode,$M['ischeckcode']);
			if(empty($setting['amount'])) showmessage('请填写汇款金额！','pay/showpayment.php?action=verified');
            if(empty($setting['payment'])) showmessage('请选择类型！','pay/showpayment.php?action=verified');
			if ($payinfo->set_offline( $setting ))
			{
				showmessage("提交成功",'pay/useramount.php');
			}
		}
		else
		{
			$offlines = $payinfo->get_offline();
			include template('pay' , 'verified_view');
		}
	break;
    case 'buypoint':
        if($button)
        {
            if(!$pid) showmessage("请选择充值类型");
           $payinfo->setBuyPoint($pid); showmessage("充值成功",'pay/pay.php');
        }
        else
        {
            $infos = $payinfo->buypoint();
            include template('pay', 'buypoint_view');
        }
        break;
	default:
        include template('pay', 'showpayment_view');
	break;

}
?>
