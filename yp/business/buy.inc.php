<?php
defined('IN_YP') or exit('Access Denied');
if(!isset($action)) $action = 'manage';
require_once 'form.class.php';
require_once MOD_ROOT.'include/yp.class.php';
$c = new yp();
$c->set_model('buy');
$c->set_userid($_userid);
foreach($MODEL AS $modelid=>$value)
{
	if($value['modeltype']==9 && $value['tablename'] == 'buy') break;
}
$c->modelid = $modelid;
switch($action)
{
	case 'add':
	if($dosubmit)
	{
		$secondcatid = intval($secondcatid);
		$thirdcatid = intval($thirdcatid);
		if($thirdcatid)
		{
			$info['catid'] = $thirdcatid;
		}
		elseif($secondcatid)
		{
			$info['catid'] = $secondcatid;
		}
		else
		{
			$info['catid'] = $catid;
		}
		if(!$info['catid']) showmessage('栏目参数错误');
		if(in_array($_groupid,$M['add_check']))
		{
			$info['status'] = 99;
		}
		else
		{
			$info['status'] = 1;
		}
		require_once 'attachment.class.php';
		$attachment = new attachment($mod, $info['catid']);
		$contentid = $c->add($info) ;
		showmessage('发布成功！', $forward);

	}
	else
	{
		if($M['ischeck'] && $company_user_infos['status'] == 0) showmessage('您的公司正在审核当中...','goback');
		if($company_user_infos['endtime'] && $company_user_infos['endtime']<TIME) showmessage('您的服务截至日期已到，请续费...','goback');
		foreach($MODEL AS $modelid=>$value)
		{
			if($value['modeltype']==9 && $value['tablename'] == 'buy') break;
		}

		require CACHE_MODEL_PATH.'yp_form.class.php';
		$content_form = new content_form($modelid);
		$data['catid'] = $catid;
		$forminfos = $content_form->get($data);
	}
	break;
	
	case 'manage':
	$where = "status=99";
	$infos = $c->listinfo($where, '`id` DESC', $page, 30, 1);
	$pages = $c->pages;
	break;

	case 'edit':
		$id = intval($id);
		if($dosubmit)
		{
			$secondcatid = intval($secondcatid);
			$thirdcatid = intval($thirdcatid);
			if($thirdcatid)
			{
				$info['catid'] = $thirdcatid;
			}
			elseif($secondcatid)
			{
				$info['catid'] = $secondcatid;
			}
			else
			{
				$info['catid'] = $catid;
			}
			require_once 'attachment.class.php';
			$attachment = new attachment($mod, $catid);
			$c->edit($id, $info);
			showmessage('修改成功！',  '?file=buy&action=add');
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
		showmessage('删除成功！', '?file=buy');
		break;
}
include template('yp', 'center_buy');
?>