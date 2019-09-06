<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require 'admin/workflow.class.php';
$w = new workflow();

if(!$action) $action = 'manage';
if(!$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=manage';

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			if($w->checkname($info['name'])) showmessage($info['name'].'已经存在！', 'goback');
			$result = $w->add($info);
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
			include admin_tpl('workflow_add');
		}
		break;
    case 'edit':
		if($dosubmit)
		{
			$result = $w->edit($workflowid, $info);
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
			$info = $w->get($workflowid);
			if(!$info) showmessage('指定的工作流方案不存在！');
			extract($info);
			include admin_tpl('workflow_edit');
		}
		break;
    case 'delete':
		$result = $w->delete($workflowid);
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
        $infos = $w->listinfo('', 'workflowid', 1, 100);
		include admin_tpl('workflow_manage');
}
?>