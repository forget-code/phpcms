<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/useramount.class.php';
$onlines = new useramount('1');
$submenu = array
(
	array($LANG['all_payment_record'], "?mod=$mod&file=$file&action=list"),
	array($LANG['success_record'], "?mod=$mod&file=$file&action=list&ispay=0"),
	array($LANG['fail_record'], "?mod=$mod&file=$file&action=list&ispay=1"),
	array($LANG['today_payment_record'], "?mod=$mod&file=$file&action=list&sendtime=day")
);
$menu = admin_menu($LANG['online_payment_manage'], $submenu);

switch ($action)
{
	case 'list':
		$page = max(intval($page), 1);
		$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 30;
		$time = TIME;
		$paytypes = get_payType(1);
		if (!empty($payment))		$condition[] = " payment='$payment'";
		if ( intval($status) )		$condition[] = " `status`   = '$status'" ;
		if ( 'day' == $sendtime)	$condition[] = " `addtime` = '$time'" ;
		if ( !empty($username))		$condition[] = " `username` like '%$username%'" ;
		if (!empty($inputer))		$condition[] = " `inputer`  like '%$inputer%'";
		if ($ispay >= '0')			$condition[] = " `ispay`	= '$ispay'";
		if ($addtimebe)				{ $addtimebe = strtotime($addtimebe); $condition[] = " `addtime` >= '$addtimebe' " ;}
		if ($addtimeend)			{ $addtimeend = strtotime($addtimeend); $condition[] = "`addtime` <= '$addtimeend' " ;}
		if ($paytimebe)			{ $paidtimebe = strtotime($paidtimebe); $condition[] = "`paytime` >= '$paidtimebe' " ;}
		if ($paidtimeend)			{ $paidtimeend = strtotime($paidtimeend); $condition[] = "`paytime` <= '$paidtimeend' " ;}
		$lists = $onlines->get_list( $condition , $page , $pagesize);
		$pages = $lists['pages'];
		include admin_tpl('payonline_view');
	break;

	case 'view':
		$r = $onlines->view($payid);
		if(!$r) showmessage($LANG['order_not_exist']);
		extract($r);
		$sendtime = date('Y-m-d', $sendtime);
		$receivetime = $receivetime ? date('Y-m-d', $receivetime) : '';
		include admin_tpl('payonline_detail');
	break;
	case 'check'://审核支付订单
		$payid = intval($id);
		$data['ispay'] = '1';
		if($onlines->check($payid, $data))
		{
			showmessage($LANG['order_verify_success'], $forward);
		}
		else
		{
			showmessage($payonline_list->error());
		}
	break;

	case 'delete':
		if($onlines->drop($amountid))
		{
			showmessage('删除成功', '?mod=pay&file=payonline&action=list');
		}
	break;
}
?>