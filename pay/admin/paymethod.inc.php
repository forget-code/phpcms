<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/payment.class.php';
if (empty($action)) $action = 'list';
$payment = new payment();
switch ($action)
{
	case 'list':
		$payments = $payment->get_list();
		include admin_tpl('payment_view');
	break;
	case 'add':
		if ( $dosubmit )
		{
			if ($payment->get_intallpayment($pay_code))
			{
				//update
				$data = $config = array();
				$info = $payment->get_payment($pay_code);
				$config = $info['config'];
				foreach ($config_name as $key => $value)
				{
					$config[$value]['value'] = $config_value[$key];
				}
				$data['pay_code'] = $pay_code;
				$data['pay_name'] = $pay_name;
				$data['pay_desc'] = $pay_desc;
				$data['pay_fee'] = $pay_fee;
				$data['enabled'] = '1';
				$data['is_cod'] = $is_cod;
				$data['is_online'] = $is_online;
                $data['config'] = array2string($config, 0);
				if ($payment->update($data,"pay_code = '$pay_code'"))
				{
					showmessage('添加成功','?mod=pay&file=paymethod&action=list');
				}
			}
			else
			{
				//insert
				$data = $config = array();
				$info = $payment->get_payment($pay_code);
				$config = $info['config'];
				foreach ($config_name as $key => $value)
				{
					$config[$value]['value'] = $config_value[$key];
				}
				$data['pay_code'] = $pay_code;
				$data['pay_name'] = $pay_name;
				$data['is_cod'] = $is_cod;
				$data['is_online'] = $is_online;
				$data['pay_desc'] = $pay_desc;
				$data['pay_fee'] = $pay_fee;
				$data['enabled'] = '1';
                $data['config'] = array2string($config, 0);
				$data['author'] = $info['author'];
				$data['website'] = $info['website'];
				$data['version'] = $info['version'];
				if ($payment->add($data))
				{
					showmessage('添加成功','?mod=pay&file=paymethod&action=list');
				}
			}
		}
		else
		{
			$info = $payment->get_payment($code);
			include admin_tpl('payment_detail');
		}
	break;
	case 'drop':

		if($payment->drop($id))
		{
			showmessage('卸载成功','?mod=pay&file=paymethod&action=list');
		}
	break;
	case 'edit':
		if ($dosubmit)
		{
			$data = $config = array();
			$info = $payment->get_payment($pay_code);
			$config = $info['config'];

			foreach ($config_name as $key => $value)
			{
				$config[$value]['value'] = $config_value[$key];
			}
			
			$data['pay_name'] = $pay_name;
			$data['pay_desc'] = $pay_desc;
			$data['pay_fee'] = $pay_fee;
            $data['pay_order'] = $pay_order;
			
            $data['config'] = array2string($config, 0);
			if ($payment->update($data,"pay_id = '$id'"))
			{
				showmessage('编辑成功','?mod=pay&file=paymethod&action=list');
			}
		}
		else
		{
			$info = $payment->edit($id);
			include admin_tpl('payment_detail');
		}
	break;
	case 'install':
		if ($dosubmit)
		{
			$data = $config = array();
			$info = $payment->get_payment($pay_code);
			$config = $info['config'];
			foreach ($config_name as $key => $value)
			{
				$config[$value]['value'] = $config_value[$key];
			}
			$data['pay_code'] = $pay_code;
			$data['pay_name'] = $pay_name;
			$data['pay_desc'] = $pay_desc;
			$data['pay_fee'] = $pay_fee;
			$data['enabled'] = '1';
            $data['config'] = array2string($config, 0);
			$data['author'] = $info['author'];
			$data['website'] = $info['website'];
			$data['version'] = $info['version'];
			if ($payment->add($data))
			{
				showmessage('安装成功','?mod=pay&file=paymethod&action=list');
			}
		}
		else
		{
			$info = $payment->get_payment($code);
			include admin_tpl('payment_view');
		}
	break;
}
?>


