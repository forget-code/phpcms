<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/exchange.class.php';
$exchange = new exchange();
switch($action)
{
    case 'add':
		if($dosubmit)
        {
			$r = get_user('0',$username);
			$userid = $r['userid'];
            if(empty($r))
            {
                showmessage('用户不存在','?mod=pay&file=exchange&action=add');
            }
			$module = 'pay';
			if ($typeid)
			{
                if(empty($note)) $note = '增加'.$LANG[$type];
				$number = $number;
			}
			else
			{
                if(empty($note)) $note = '减少'.$LANG[$type];
				$number = '-'.$number;
			}
			if($exchange->update_exchange($module, $type, $number, $note , $userid ))
			{
				showmessage('添加成功','?mod=pay&file=exchange&action=list');
			}
			else
			{
				showmessage($exchange->error());
			}
		}
		else
		{
			include admin_tpl('exchange_add');
		}
		break;
	case 'list':
		$condition = array();
		if ($begindate)			$condition[] = "`time` >= '$begindate' " ;
		if ($enddate)			$condition[] = "`time` <= '$enddate' " ;
		if(!empty($type))		$condition[] = "`type` = '$type' " ;
		if(!empty($username))	$condition[] = "`username` = '$username' " ;
		if(!empty($module))		$condition[] = "`module` = '$module' " ;
        if(!empty($num1))       {$num1 = intval($num1); $condition[] = "`number` >= '$num1' " ;}
        if(!empty($num2))       {$num2 = intval($num2); $condition[] = "`number` >= '$num2' " ;}
        if(!empty($inputer))    $condition[] = "`inputer` like '%$inputer%' " ;
		$page = isset($page) ? intval($page) : 1;
		$pagesize	= $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
        $offset = ($page-1)*$pagesize;
		$exchanges = $exchange->get_list( $condition, $page, $pagesize);
		$pages = $exchanges['pages'];
		include admin_tpl('exchange_view');
	break;
	case 'delete':
		$exchange->drop($payid);showmessage('删除记录成功','?mod=pay&file=exchange&action=list');
	break;
    case 'checkuser':
        if(!$exchange->username_exists($value))
        {
            exit('success');
        }
        else
        {
            exit("用户名不存在");
        }
        break;
    default :
}
?>