<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once PHPCMS_ROOT.'member/include/member.class.php';
$member = new member();
require_once MOD_ROOT.'admin/include/credit.class.php';
$credit = new credit();

$submenu = array
(
	array($LANG['all_integral'], '?mod='.$mod.'&file='.$file.'&action=total'),
	array($LANG['premonth_integral'], '?mod='.$mod.'&file='.$file.'&action=month'),
	array($LANG['preweek_integral'], '?mod='.$mod.'&file='.$file.'&action=week')
);
$menu = admin_menu($LANG['credit_list'],$submenu);

if(!$action) $action = 'total';
switch($action)
{
	case 'week':
	$infos = $credit->listinfo('', 'preweek DESC', 1, 50, 1);
    break;
    
	case 'month':
	$infos = $credit->listinfo('', 'premonth DESC', 1, 50, 1);
    break;
    
    case 'total':
	$infos = $credit->listinfo('', '', 1, 50);

	break;
}
include admin_tpl('credit');
?>