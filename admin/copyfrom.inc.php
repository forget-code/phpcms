<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'admin/copyfrom.class.php';
$copyfrom = new copyfrom();

if(!$action) $action = 'manage';
if(!$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=manage';

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$result = $copyfrom->add($info);
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
			include admin_tpl('copyfrom_add');
		}
		break;
    case 'edit':
		if($dosubmit)
		{
			$result = $copyfrom->edit($copyfromid, $info);
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
			$info = $copyfrom->get($copyfromid);
			if(!$info) showmessage('指定的来源不存在！');
			extract($info);
			include admin_tpl('copyfrom_edit');
		}
		break;
    case 'manage':
        $infos = $copyfrom->listinfo('', 'copyfromid', $page, 20);
		include admin_tpl('copyfrom_manage');
		break;
    case 'select':
        $infos = $copyfrom->listinfo('', 'copyfromid', 1, 50);
		include admin_tpl('copyfrom_select');
		break;
    case 'delete':
		$result = $copyfrom->delete($copyfromid);
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
		$result = $copyfrom->listorder($info);
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
		$result = $copyfrom->disable($copyfromid, $disabled);
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