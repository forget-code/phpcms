<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'admin/author.class.php';
$author = new author();

if(!$action) $action = 'manage';
if(!$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=manage';

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$info['username'] = trim($info['username']);
			$info['name'] = trim($info['name']);
			if(empty($info['username'])) showmessage("用户名不能为空");
			if(empty($info['name'])) showmessage("姓名不能为空");
			$result = $author->add($info);
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
			include admin_tpl('author_add');
		}
		break;
    case 'edit':
		if($dosubmit)
		{
			$info['username'] = trim($info['username']);
			$info['name'] = trim($info['name']);
			if(empty($info['username'])) showmessage("用户名不能为空");
			if(empty($info['name'])) showmessage("姓名不能为空");
			$result = $author->edit($authorid, $info);
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
			$info = $author->get($authorid);
			if(!$info) showmessage('指定的作者不存在！');
			extract($info);
			include admin_tpl('author_edit');
		}
		break;
    case 'manage':
        $infos = $author->listinfo('', 'authorid', $page, 20);
		include admin_tpl('author_manage');
		break;
    case 'select':
        $infos = $author->listinfo('', 'authorid', $page, 50);
		include admin_tpl('author_select');
		break;
    case 'delete':
		$result = $author->delete($authorid);
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
		$result = $author->listorder($info);
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
		$result = $author->disable($authorid, $disabled);
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