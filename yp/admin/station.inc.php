<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require_once 'admin/type.class.php';
$type = new type($mod);

if(!$action) $action = 'manage';

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$info['name'] = $station;
			$result = $type->add($info);
			if($result)
			{
				showmessage('添加成功',"?mod=$mod&file=$file&action=manage");
			}
			else
			{
				showmessage('操作失败！',$forward);
			}
		}
		break;
    case 'edit':
		if($dosubmit)
		{
			$result = $type->edit($typeid, $info);
			if($result)
			{
				showmessage('编辑成功',"?mod=$mod&file=$file&action=manage");
			}
			else
			{
				showmessage('操作失败！',$forward);
			}
		}
		else
		{
			$info = $type->get($typeid);
			if(!$info) showmessage('指定的类别不存在！');
			extract($info);
			include admin_tpl('station');
		}
		break;
    case 'manage':
		$page = max(intval($page), 1);
		$pagesize = 200;
        $infos = $type->listinfo($page, $pagesize);
		include admin_tpl('station');
		break;
    case 'delete':
		$result = $type->delete($typeid);
		if($result)
		{
			showmessage('操作成功！',"?mod=$mod&file=$file&action=manage");
		}
		else
		{
			showmessage('操作失败！',$forward);
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
			showmessage('操作失败！',$forward);
		}
		break;
}
?>