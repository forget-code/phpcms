<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once 'admin/type.class.php';
$type = new type($mod);
$submenu = array(
	array('添加类别', '?mod='.$mod.'&file='.$file.'&action=add'),
	array('类别管理', '?mod='.$mod.'&file='.$file.'&action=manage'),
);
$menu = admin_menu('管理类别', $submenu);

if(!$action) $action = 'manage';

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$result = $type->add($info);
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
			include admin_tpl('type_add');
		}
		break;
    case 'edit':
		if($dosubmit)
		{
			$result = $type->edit($typeid, $info);
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
			$info = $type->get($typeid);
			if(!$info) showmessage('指定的类别不存在！');
			extract($info);
			include admin_tpl('type_edit');
		}
		break;
    case 'manage':
		$page = max(intval($page), 1);
		$pagesize = max(intval($pagesize), 20);
        $infos = $type->listinfo($page, $pagesize);
		include admin_tpl('type_manage');
		break;
    case 'delete':
		$result = $type->delete($typeid);
        require_once MOD_ROOT.'admin/include/subscription.class.php';
        $s = new subscription();
        $s->dropTypeContent($typeid);
		if($result)
		{
			showmessage('操作成功！');
		}
		else
		{
			showmessage('操作失败！');
		}
		break;
    case 'listorder':
		$result = $type->listorder($info);
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
		$page = max(intval($page), 1);
		$pagesize = max(intval($pagesize), 20);
        $infos = $type->listinfo($page, $pagesize);
		include admin_tpl('type_manage');
}
?>