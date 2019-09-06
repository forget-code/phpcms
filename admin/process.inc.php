<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require 'admin/process.class.php';
$p = new process($workflowid);

$submenu = array(
	array('添加工作流步骤', '?mod='.$mod.'&file='.$file.'&action=add&workflowid='.$workflowid),
	array('工作流步骤管理', '?mod='.$mod.'&file='.$file.'&action=manage&workflowid='.$workflowid),
);
$menu = admin_menu('工作流步骤管理', $submenu);

if(!$action) $action = 'manage';

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$processid = $p->add($info, $status, $priv_roleid);
			if($processid)
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
			$STATUS = cache_read('status.php');
			include admin_tpl('process_add');
		}
		break;
    case 'edit':
		if($dosubmit)
		{
			$result = $p->edit($processid, $info, $status, $priv_roleid);
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
			$info = $p->get($processid);
			if(!$info) showmessage('指定的工作流方案不存在！');
			extract($info);
			$STATUS = cache_read('status.php');
			$status = implode(',', $p->get_process_status($processid));
			$priv_roleids = implode(',', $priv_role->get_roleid('processid', $processid));
			include admin_tpl('process_edit');
		}
		break;
    case 'delete':
		$result = $p->delete($processid);
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
        $infos = $p->listinfo("workflowid=$workflowid", 'processid', 1, 100);
		include admin_tpl('process_manage');
}
?>