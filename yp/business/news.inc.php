<?php
defined('IN_YP') or exit('Access Denied');
if(!isset($action)) $action = 'manage';
require_once 'form.class.php';
require_once MOD_ROOT.'include/yp.class.php';
$c = new yp();
$c->set_model('news');
foreach($MODEL AS $modelid=>$value)
{
	if($value['modeltype']==9 && $value['tablename'] == 'news') break;
}
$c->modelid = $modelid;
switch($action)
{
	case 'add':
	if($dosubmit)
	{
		if(in_array($_groupid,$M['add_check']))
		{
			$info['status'] = 99;
		}
		else
		{
			$info['status'] = 1;
		}
		require_once 'attachment.class.php';
		$attachment = new attachment($mod, '');
		$contentid = $c->add($info);
		showmessage('发布成功！', '?file=news&action=add');

	}
	else
	{
		if($M['ischeck'] && $company_user_infos['status'] == 0) showmessage('您的公司正在审核当中...','goback');
		if($company_user_infos['endtime'] && $company_user_infos['endtime']<TIME) showmessage('您的服务截至日期已到，请续费...','goback');
		foreach($MODEL AS $modelid=>$value)
		{
			if($value['modeltype']==9 && $value['tablename'] == 'news') break;
		}

		require CACHE_MODEL_PATH.'yp_form.class.php';
		$content_form = new content_form($modelid);
		$data['catid'] = $catid;
		$forminfos = $content_form->get($data);
	}
	break;
	
	case 'manage':
		
		$infos = $c->listinfo("userid='$userid'",'id DESC',$page);
		$pages = $c->pages;
	break;

	case 'edit':
		$id = intval($id);
		if($dosubmit)
		{
			require_once 'attachment.class.php';
			$attachment = new attachment($mod);
			$c->edit($id, $info);
			showmessage('修改成功！', $forward);
		}
		else
		{
			require CACHE_MODEL_PATH.'yp_form.class.php';
			$content_form = new content_form($modelid);
			$data = $c->get($id);
			$forminfos = $content_form->get($data);
		}
		break;
	case 'delete':
		$id = intval($id);
		$c->delete($id);
		showmessage('删除成功！', '?file=news');
		break;
}
include template('yp', 'center_news');
?>