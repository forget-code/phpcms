<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'admin/ipbanned.class.php';
$ipbanned = new ipbanned();
if(!$forward) $forward = '?mod='.$mod.'&file='.$file;

switch($action)
{
    case 'add':
        $expires = strtotime($expires);
		if($ipbanned->update($ip, $expires))
	    {
		    showmessage('操作成功！', $forward);
		}
		else
	    {
		    showmessage('操作失败！', $forward);
		}
		break;

    case 'clear':
		$ipbanned->clear();
		showmessage('操作成功！', $forward);
		break;

	case 'delete':
		$ipbanned->delete($ip);
		showmessage('操作成功！', $forward);
		break;

    default :
		$where = '';
		if($sip) $where = "`ip` LIKE '%$sip%'";
		$data = $ipbanned->listinfo($where, '', $page, 20);
		include admin_tpl('ipbanned');
}
?>

