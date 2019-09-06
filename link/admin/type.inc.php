<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'admin/type.class.php';
$type = new type($mod);
$link = new link();

if(!$action) $action = 'manage';

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$result = $type->add($info);
			if($result)
			{
				//showmessage('操作成功！',"?mod=link&file=createhtml&forward=".urlencode($forward));
				showmessage('添加成功',"?mod=$mod&file=$file&action=manage");
			}
			else
			{
				showmessage('操作失败！',$forward);
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
				//showmessage('操作成功！',"?mod=link&file=createhtml&forward=".urlencode($forward));
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
		$dellink = $link->deltypelink($typeid);
		if($dellink)
		{
			$result = $type->delete($typeid);
			$link->del('',"where typeid=$typeid");
			if($result)
			{
				//showmessage('操作成功！', "?mod=link&file=createhtml&forward=".urlencode($forward));
				showmessage('操作成功！',"?mod=$mod&file=$file&action=manage");
			}
			else
			{
				showmessage('操作失败！',$forward);
			}
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
    default :
		$page = max(intval($page), 1);
		$pagesize = max(intval($pagesize), 20);
        $infos = $type->listinfo($page, $pagesize);
		include admin_tpl('type_manage');
}
?>