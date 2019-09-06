<?php
require './include/common.inc.php';

switch($action)
{
    case 'view':
        $r = $order->get($orderid);
	    if(!$r) showmessage('订单不存在！');
	    extract($r);
        $statusname = $order->STATUS[$status];
		$closedtime = $order->get_closedtime($time, $M['maxcloseday']);
		include template($mod, 'view');
		break;

    case 'cancel':
		$order->set_status($orderid, 4, '取消订单');
	    showmessage('操作成功！', url($M['url'], 1).'index.php?action=manage');
		break;

    case 'pay':
		$r = $order->get($orderid);
		if(!$r) showmessage('订单不存在！');
		extract($r);

		if($dosubmit)
	    {
			$pay_api = load('pay_api.class.php', 'pay', 'api');
			if(!$pay_api->update_exchange('order', 'amount', -$amount, "<a href=\'$goodsurl\' target=\'_blank\'>".addslashes($goodsname)."</a>"))
			{
				showmessage($pay_api->error());
			}
			$order->set_status($orderid, 1, '已付款，待发货');
			showmessage('操作成功！', url($M['url'], 1).'index.php?action=manage&status=1');
		}
		else
	    {
			$statusname = $order->STATUS[$status];
			$closedtime = $order->get_closedtime($time, $M['maxcloseday']);
			$money = $amount - $_amount;
			include template($mod, 'pay');
		}
		break;

    case 'memo':
        $r = $order->get($orderid);
	    if(!$r) showmessage('订单不存在！');

		if($dosubmit)
	    {
			$order->set_memo($orderid, $memo);
			showmessage('操作成功！', $forward);
		}
		else
	    {
			extract($r);
			include template($mod, 'memo');
		}
		break;

	case 'receive':
		if(!$order->set_status($orderid, 3, '已收获，交易成功'))
		{
			showmessage('订单不存在！', $forward);
		}
		else
		{
			showmessage('操作成功！', $forward);
		}
		break;

    default :
		$where = '';
	    if(isset($status))
	    {
			$status = intval($status);
			$where = " status=$status ";
		}
		$data = $order->listinfo($where, '', $page, 20);
		$pages = $order->pages;
		if(isset($status)) $statusname = $order->STATUS[$status];
		include template($mod, 'index');
}
?>