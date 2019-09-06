<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require 'admin/status.class.php';
$s = new status();

if(!$action) $action = 'manage';
if(!$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=manage';

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$result = $s->add($info);
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
			$options = array();
			for($i=4; $i<99; $i++)
			{
				if(!$s->get($i)) $options[$i] = $i;
			}
			include admin_tpl('status_add');
		}
		break;
    case 'edit':
		if($dosubmit)
		{
			$result = $s->edit($status, $info);
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
			$info = $s->get($status);
			if(!$info) showmessage('指定的状态不存在！');
			extract($info);
			include admin_tpl('status_edit');
		}
		break;
    case 'delete':
		$result = $s->delete($status);
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
        $infos = $s->listinfo('', 'status', 1, 100);
		include admin_tpl('status_manage');
}
?>