<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'admin/role.class.php';
$role = new role();

if(!$action) $action = 'manage';
if(!$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=manage';

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$result = $role->add($info);
			if($result)
			{
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			include admin_tpl('role_add');
		}
		break;
    case 'edit':
		if($dosubmit)
		{
			$result = $role->edit($roleid, $info);
			if($result)
			{
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			$info = $role->get($roleid);
			if(!$info) showmessage('指定的角色不存在！');
			extract($info);
			include admin_tpl('role_edit');
		}
		break;
    case 'manage':
        $infos = $role->listinfo('', 'roleid', 1, 100);
		include admin_tpl('role_manage');
		break;
    case 'delete':
		$result = $role->delete($roleid);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;
    case 'disable':
		$result = $role->disable($roleid, $disabled);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;
    default :
}
?>