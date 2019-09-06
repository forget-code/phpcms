<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once 'admin/urlrule.class.php';
if(!$action) $action = 'manage';
$urlrule = new urlrule();
switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$result = $urlrule->add($data);
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
			include admin_tpl('urlrule_add');
		}
		break;
    case 'edit':
		if($dosubmit)
		{
			$result = $urlrule->edit($urlruleid, $data);
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
			$data = $urlrule->get($urlruleid);
			if(!$data) showmessage('规则不存在！');
			//$data = new_htmlspecialchars($data);
            extract($data);
			include admin_tpl('urlrule_edit');
		}
		break;
    case 'manage':
        $page = max(intval($page), 1);
		$pagesize = max(intval($pagesize), 30);
        $data = $urlrule->listinfo($condition, $page, $pagesize);
		include admin_tpl('urlrule_manage');
		break;
    case 'delete':
		$result = $urlrule->delete($urlruleid);
		if($result)
		{
			showmessage('操作成功！','?mod=phpcms&file=urlrule&action=manage');
		}
		else
		{
			showmessage('操作失败！');
		}
		break;
}
?>