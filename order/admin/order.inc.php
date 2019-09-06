<?php
defined('IN_PHPCMS') or exit('Access Denied');

require MOD_ROOT.'include/order.class.php';
$order = new order();

switch($action)
{
    case 'view':
        $r = $order->get($orderid);
	    if(!$r) showmessage('订单不存在！');
	    extract($r);
        $statusname = $order->STATUS[$status];
		$closedtime = $order->get_closedtime($time, $M['maxcloseday']);

		$logs = $order->get_log($orderid);
		include admin_tpl('view');
		break;

    case 'edit':
		if($dosubmit)
	    {
			$order->edit($orderid, $data);
			showmessage('操作成功！', $forward);
		}
		else
	    {
			$r = $order->get($orderid);
			if(!$r) showmessage('订单不存在！');
			extract($r);
			$startdate = date('Y-m-d', $starttime);
			include admin_tpl('edit');
		}
		break;

    case 'cancel':
		$order->set_status($orderid, 4, '取消订单');
	    showmessage('操作成功！', $forward);
		break;

    case 'deliver':
		$order->set_status($orderid, 2, '确认发货');
	    showmessage('操作成功！', $forward);
		break;

    case 'delete':
        $order->delete($orderid);
	    showmessage('操作成功！', $forward);
		break;

    default :
		$where = '';
	    if(isset($status) && is_numeric($status)) $where .= "AND `status`=$status ";
		if($minamount) $where .= "AND `amount`>='$minamount' ";
		if($maxamount) $where .= "AND `amount`<='$maxamount' ";
		if($startdate) $where .= "AND `date`>='$startdate' ";
		if($enddate) $where .= "AND `date`<='$enddate' ";
		if($q)
	    {
			if($field == 'orderid') $where .= "AND `$field`='$q' ";
			elseif($field == 'userid') $where .= "AND `$field`='$q' ";
			elseif($field == 'username') $where .= "AND `userid`='".userid($q)."' ";
			elseif($field == 'goodsname') $where .= "AND `$field` LIKE '%$q%' ";
		}
		if($where) $where = substr($where, 3);
		if(!isset($orderby)) $orderby = '`orderid` DESC';
		$data = $order->listinfo($where, $orderby, $page, 20);
		$pages = $order->pages;
		include admin_tpl('manage');
}
?>