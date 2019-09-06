<?php
defined('IN_PHPCMS') or header('location:../admin.php?file=index&action=index');
$action = isset($action) ? $action : 'index';
switch($action)
{
	case 'main':
		
		$GROUP = cache_read('member_group_'.$_groupid.'.php');
		$r = $db->get_one("select email,lastlogintime,logintimes,items from ".TABLE_MEMBER." where username='$_username'");
		$lastlogintime = $r['lastlogintime'] ? date('Y-m-d H:i:s', $r['lastlogintime']) : '';
		$logintimes = $r['logintimes'];
		@extract($db->get_one("SELECT COUNT(orderid) AS new_order_num FROM ".TABLE_YP_ORDER." WHERE companyid='$companyid' AND status=0"));
		@extract($db->get_one("SELECT COUNT(gid) AS new_message_num FROM ".TABLE_YP_GUESTBOOK." WHERE companyid='$companyid' AND status=0"));
		include managetpl('index_main');
	break;

	case 'menu':
		include managetpl('index_menu');
	break;
	case 'manage':

		include managetpl('left_company');
	break;
	case 'top':

		include managetpl('index_top');
		break;

	default:
	include managetpl('index');
}

?>