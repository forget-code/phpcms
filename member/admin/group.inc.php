<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once MOD_ROOT.'admin/include/group_admin.class.php';
$group = new group_admin();

$menu = admin_menu($LANG['member_group_manage']);
$action=$action ? $action : 'manage';

$grouptypes = array('0'=>'自定义', '1'=>'系统组');
$choices = array('1'=>'是', '0'=>'否');
if(!$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=manage';

switch($action)
{
    case 'manage':
		$groups = array();
		require MOD_ROOT.'admin/include/member_admin.class.php';
		$member_admin = new member_admin();
      	$groups = $group->listinfo();
		include admin_tpl('group_manage');
	break;

	case 'add':
		if($dosubmit)
		{
			$result = $group->add($groupinfo);
			if(!$result)
			{
				showmessage($group->msg(), $forward);	
			}
			cache_member_group();
			showmessage($LANG['operation_success'], "?mod=$mod&file=$file&action=manage");
		}
		else
		{
			include admin_tpl('group_add');
		}
	break;

	case 'edit':
		if($dosubmit)
		{
			if($group->edit($groupid, $groupinfo))
			{
				cache_member_group();
				showmessage($LANG['operation_success'], $forward);
			}
			else
			{
				showmessage($LANG['operation_failure'], 'goback');
			}
		}
		else
		{
			$groupinfo = $group->get($groupid);
			@extract(new_htmlspecialchars($groupinfo));
			include admin_tpl('group_edit');
		}
	break;
	
	case 'listorder':
		$group->listorder($listorders);
		cache_member_group();
		showmessage($LANG['operation_success'], $forward);
	break;

	case 'disabled':
		$group->disable($groupid, $val);
		showmessage($LANG['operation_success'], $forward);
	break;

	case 'delete':
		$group->delete($groupid);
		cache_member_group();
		showmessage($LANG['operation_success'], $forward);
	break;

	case 'extenddisable':
		$group->extend_disable($groupid, $disable);
		showmessage($LANG['operation_success'], $forward);
	break;

	case 'extenddelete':
		$group->extend_cancel($userid, $groupid);
		showmessage($LANG['operation_success'], $forward);
	break;

	case 'checkname':
		if(!$group->check_name($value, $groupid))
		{
			exit($group->msg());
		}
		else
		{
			exit('success');
		}
	break;
}
?>