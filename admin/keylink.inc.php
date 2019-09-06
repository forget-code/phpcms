<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'admin/keylink.class.php';
$keylink = new keylink();

if(!$action) $action = 'manage';
if(!$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=manage';

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			if($keylink->checkword($info['word'])) showmessage($info['word'].'已经存在！', 'goback');
			$result = $keylink->add($info);
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
			include admin_tpl('keylink_add');
		}
		break;
    case 'edit':
		if($dosubmit)
		{
			$result = $keylink->edit($keylinkid, $info);
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
			$info = $keylink->get($keylinkid);
			if(!$info) showmessage('指定的关联链接不存在！');
			extract($info);
			include admin_tpl('keylink_edit');
		}
		break;
    case 'manage':
        $infos = $keylink->listinfo('', 'keylinkid', $page, 20);
		include admin_tpl('keylink_manage');
		break;
    case 'delete':
		$result = $keylink->delete($keylinkid);
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
		$result = $keylink->listorder($info);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;
}
?>