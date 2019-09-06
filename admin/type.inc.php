<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'admin/type.class.php';
if(!isset($module)) $module = 'phpcms';
$type = new type($module);

if(!$action) $action = 'manage';
if(!$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=mange';

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
		if($result)
		{
			showmessage('操作成功！', $forward);
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