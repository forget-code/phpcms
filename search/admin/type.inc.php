<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once MOD_ROOT.'include/type.class.php';
$t = new type();

if(!$action) $action = 'manage';
if(!$forward) $forward = "?mod=$mod&file=$file&action=manage";

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$result = $t->add($type, $name, $md5key, $description);
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
			$result = $t->edit($type, $name, $md5key, $description);
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
			$r = $t->get($type);
			if(!$r) showmessage('指定的类别不存在！');
			extract($r);
			include admin_tpl('type_edit');
		}
		break;
    case 'manage':
		$page = max(intval($page), 1);
		$pagesize = max(intval($pagesize), 20);
        $infos = $t->listinfo($page, $pagesize);
		include admin_tpl('type_manage');
		break;
    case 'delete':
		$result = $t->delete($typeid);
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
		$result = $t->listorder($info);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;
	case 'check':
        echo $t->check($value) ? 'success' : $t->errormsg();
		break;
    default :
        $infos = $t->listinfo();
		include admin_tpl('type_manage');
}
?>