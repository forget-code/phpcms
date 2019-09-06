<?php
defined('IN_PHPCMS') or exit('Access Denied');

$submenu = array
(
	array($LANG['all_charge_card'], '?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['unused_charge_card'], '?mod='.$mod.'&file='.$file.'&action=manage&status=notused'),
	array($LANG['used_charge_card'], '?mod='.$mod.'&file='.$file.'&action=manage&status=used'),
	array($LANG['out_of_date_charge_card'], '?mod='.$mod.'&file='.$file.'&action=manage&status=timeout'),
	array($LANG['batch_create_charge_card'], '?mod='.$mod.'&file='.$file.'&action=add')
);
$menu = adminmenu($LANG['charge_card_manage'], $submenu);

$today = date('Y-m-d');
$pagesize = $PHPCMS['pagesize'];

switch($action)
{
	case 'manage':
		if(!isset($status)) $status = '';
		$page = isset($page) ? intval($page) : 1;
		$offset = ($page-1)*$pagesize;

        $condition = '';
		if($status == 'notused')
		{
			$condition .= " where regtime=0 and enddate>='$today' or enddate='0000-00-00'";
		}
		elseif($status == 'used')
		{
			$condition .= " where regtime>0";
		}
		elseif($status == 'timeout')
		{
			$condition .= " where regtime=0 and enddate<'$today' and enddate!='0000-00-00'";
		}

		$r = $db->get_one("select count(*) as num from ".TABLE_PAY_CARD." $condition");
		$pages = phppages($r['num'], $page, $pagesize);

        $paycards = array();
		$result=$db->query("SELECT * FROM ".TABLE_PAY_CARD." $condition ORDER BY id desc limit $offset,$pagesize");
		while($r=$db->fetch_array($result))
		{
			$r['status'] = $r['regtime'] ? "<font color='red'>".$LANG['used']."</font>" : (  ($r['enddate']!='0000-00-00' && $r['enddate'] < $today) ? $LANG['out_of_date'] : "<font color='blue'>".$LANG['unused']."</font>" );
			$r['regtime'] = $r['regtime'] ? date("Y-m-d H:i:s",$r['regtime']) : "";
			$r['enddate'] = $r['enddate']=='0000-00-00' ? $LANG['no_limit'] : $r['enddate'];
			$paycards[] = $r;
		}
		include admintpl('paycard_manage');
		break;

	case 'add':
		if($dosubmit)
		{
		    $price = intval($price);
			$paycardlen = intval($paycardlen);
			if($paycardlen>20 || $paycardlen<8) showmessage($LANG['card_number_not_less_than8_greater_than20']);

			$passwordlen = intval($passwordlen);
			if($passwordlen>10 || $passwordlen<4) showmessage($LANG['charge_card_number_not_than4_greater_than10']);

			$prefixlen = strlen($prefix);
			if($prefixlen>6 || $prefixlen<1) showmessage($LANG['card_number_prefix_not_than4_greater_than10']);

			$strnum = $paycardlen - strlen($prefix);
			$paycards = array();
			for($i=0; $i<$paycardnum; $i++)
			{
				$cardid = $prefix.random($strnum, '0123456789');
				$password = random($passwordlen);
				$adddate = date('Y-m-d');
				$paycards[] = array($cardid,$password);
				$result = $db->query("SELECT id FROM ".TABLE_PAY_CARD." WHERE cardid='$cardid'");
				if($db->num_rows($result)) continue;
				$db->query("INSERT INTO ".TABLE_PAY_CARD." (prefix,cardid,password,price,inputer,adddate,enddate) VALUES('$prefix','$cardid','$password','$price','$_username','$adddate','$enddate')");
			}
			include admintpl('paycard_view');
		}
		else
		{
			$enddate = (date('Y')+5).date('-m-d');
			include admintpl('paycard_add');
		}
		break;

	case 'delete':
		  if(empty($id)) showmessage($LANG['illegal_parameters']);

		  $ids = is_array($id) ? implode(',',$id) : $id;
		  $db->query("DELETE FROM ".TABLE_PAY_CARD." WHERE id IN ($ids)");
		  $db->affected_rows()>0 ? showmessage($LANG['operation_success'], $forward) : showmessage($LANG['operation_failure']);
		 break;

	case 'deletetimeout':
		  $db->query("DELETE FROM ".TABLE_PAY_CARD." WHERE regtime=0 AND enddate<$today");
		  $db->affected_rows()>0 ? showmessage($LANG['operation_success'], $forward) : showmessage($LANG['operation_failure']);
		 break;

	case 'deleteused':
		  $db->query("DELETE FROM ".TABLE_PAY_CARD." WHERE regtime>0");
		  $db->affected_rows()>0 ? showmessage($LANG['operation_success'], $forward) : showmessage($LANG['operation_failure']);
		 break;
}
?>