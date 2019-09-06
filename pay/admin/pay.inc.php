<?php
defined('IN_PHPCMS') or exit('Access Denied');

$submenu = array
(
	array($LANG['add_record'], '?mod='.$mod.'&file='.$file.'&action=add'),
	array($LANG['finance_waste_book'], '?mod='.$mod.'&file='.$file.'&action=list'),
	array($LANG['operation_type_setting'], '?mod='.$mod.'&file='.$file.'&action=type'),
);
$menu = adminmenu($LANG['finance_operation'], $submenu);

$types = pay_type();

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			if(!array_key_exists($typeid, $types)) showmessage($LANG['illegal_operation']);

            $amount = floatval($amount);

			$r = $db->get_one("SELECT userid,email,money FROM ".TABLE_MEMBER." WHERE username='$username'");
			if(!$r) showmessage($LANG['username_not_exist']);
			$balance = $r['money'];
			$value = 0;
			$operation = $types[$typeid]['operation'];
            if($operation == '+')
			{
			    $balance += $amount;
			}
			elseif($operation == '-')
			{
			    $balance -= $amount;
			}
			$balance = round($balance, 2);

			$year = date('Y', $PHP_TIME);
			$month = date('m', $PHP_TIME);
			$date = date('Y-m-d', $PHP_TIME);

			$note = new_htmlspecialchars($note);
			$note = str_cut($note, 200);

            if($operation == '+')
			{
			    money_add($username, $amount, $note);
			}
			elseif($operation == '-')
			{
			    money_diff($username, $amount, $note);
			}
			else
			{
			    $db->query("INSERT INTO ".TABLE_PAY."(typeid,note,paytype,amount,balance,username,year,month,date,inputtime,inputer,ip) VALUES('$typeid','$note','$paytype','$amount','$balance','$username','$year','$month','$date','$PHP_TIME','$_username','$PHP_IP')");
			}
			if(strpos($forward, 'mod=phpcms&file=index&action=module') || !$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=list';
			showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			$paytypes = explode("\n", $MOD['paytypes']);
            $paytypes = array_map('trim', $paytypes);
            $paytype = isset($paytype) ? $paytype : '';
			if(!isset($typeid)) $typeid = 0;
			if(!isset($username)) $username = '';
			if(!isset($amount)) $amount = '';
			if(!isset($note)) $note = '';

			include admintpl('pay_add');
		}
		break;

	case 'list':
		$typeid = isset($typeid) ? intval($typeid) : 0;

		$pagesize = $PHPCMS['pagesize'];
		if(!isset($page))
		{
			$page=1;
			$offset=0;
		}
		else
		{
			$offset=($page-1)*$pagesize;
		}

		$sql = '';
		$sql .= $typeid ? " and typeid=$typeid" : "";
		$sql .= isset($paytype) && $paytype ? " and paytype='$paytype'" : "";
		$sql .= isset($date) && $date ? " and date='$date'" : "";
		$sql .= isset($fromdate) && $fromdate ? " and date>='$fromdate'" : "";
		$sql .= isset($todate) && $todate ? " and date<='$todate'" : "";
		$sql .= isset($keywords) && $keywords ? " and note like '%$keywords%'" : "";
		$sql .= isset($username) && $username ? " and username='$username'" : "";

		$r = $db->get_one("select COUNT(*) as number from ".TABLE_PAY." where deleted=0 $sql");
		$pages = phppages($r['number'], $page, $pagesize);

        $pays = $money = array();
		$result = $db->query("select * from ".TABLE_PAY." where deleted=0 $sql order by payid desc limit $offset,$pagesize");
		while($r = $db->fetch_array($result))
		{
			$money[$r['typeid']][] = $r['amount'];
			$pays[] = $r;
		}

		foreach($types as $id=>$val)
		{
		    if(isset($money[$id])) $money[$id] = array_sum($money[$id]);
		}

		$fromdate = isset($fromdate) ? $fromdate : date('Y-m-01');

		$todate = isset($todate) ? $todate : date('Y-m-d');

		$paytypes = explode("\n", $MOD['paytypes']);
		$paytypes = array_map('trim', $paytypes);

		include admintpl('pay_list');

		break;
	case 'delete':
		$payid = intval($payid);
		if(!$payid) showmessage($LANG['illegal_operation']);
		$db->query("DELETE FROM ".TABLE_PAY." WHERE payid=$payid ");
		showmessage($LANG['operation_success'], "?mod=$mod&file=$file&action=list");
		break;
	case 'type':

		if($dosubmit)
		{
			if(!isset($name)) $name = array();
			foreach($name as $id=>$v)
			{
				if(isset($delete[$id]) && $delete[$id])
				{
					$db->query("DELETE FROM ".TABLE_PAY_TYPE." WHERE typeid=$id");
				}
				else
				{
					$db->query("UPDATE ".TABLE_PAY_TYPE." SET name='$name[$id]',listorder='$listorder[$id]',operation='$operation[$id]' WHERE typeid=$id");
				}
			}
			if($newname)
			{
				$db->query("INSERT INTO ".TABLE_PAY_TYPE."(name,listorder,operation) VALUES('$newname','$newlistorder','$newoperation')");
			}
			showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			$maxtypeid = 0;
			$types = array();
			$result = $db->query("SELECT * FROM ".TABLE_PAY_TYPE." ORDER BY listorder");
			while($r = $db->fetch_array($result))
			{
				$types[$r['typeid']] = $r;
				$maxtypeid = max($maxtypeid, $r['typeid']);
			}
			$newlistorder = $maxtypeid + 1;
			include admintpl('pay_type');
		}
		break;

    default :
}
?>