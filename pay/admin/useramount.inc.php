<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/useramount.class.php';

$submenu = array
(
	array($LANG['amount_list'], '?mod='.$mod.'&file='.$file.'&action=list')
);
$menu = admin_menu($LANG['finance_operation'], $submenu);

$action = isset($action) ? $action : 'list';
$useramount = new useramount('0');
switch ($action)
{
	case 'list':
		if (!empty($id))
        {
			$amount = $useramount->view($id);
			include admin_tpl('amount_detail');
		}
        else
        {
			$paytypes = get_payType();
			if(!empty($username))           $condition[] = " username='$username'";
			if(!empty($inputer))            $condition[] = " inputer='$inputer'";
			if(!empty($payment))            $condition[] = " payment='$payment'";
			if($is_paid >= '0')             $condition[] = " ispay = '$is_paid'";
			if ($addtimebe)
            {
                $addtimebe = strtotime($addtimebe);
                $condition[] = "addtime >= '$addtimebe' " ;
            }
			if ($addtimeend)			{ $addtimeend = strtotime($addtimeend); $condition[] = "`addtime` <= '$addtimeend' " ;}

			if ($paidtimebe)			{ $paidtimebe = strtotime($paidtimebe); $condition[] = "`paytime` >= '$paidtimebe' " ;}
			if ($paidtimeend)			{ $paidtimeend = strtotime($paidtimeend); $condition[] = "`paytime` <= '$paidtimeend' " ;}

			$page = isset($page) ? intval($page) : 1;
			$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 30;
			$amounts = $useramount->get_list($condition,$page,$pagesize);
			$pages = $amounts['pages'];
			include admin_tpl('amount_view');
		}
	break;
	case 'check':
		if ( $dosubmit )
		{
			if ( $useramount->check($id, $setting) ){
				showmessage('修改成功','?mod=pay&file=useramount&action=list');
			}
		}
		else
		{
			$info = $useramount->view($id);
			include admin_tpl('amount_edit');
		}
	break;
	case 'del':
		if ( $useramount->drop($id) ) showmessage('删除成功','?mod=pay&file=useramount&action=list');
	break;
	default:
	break;
}
?>