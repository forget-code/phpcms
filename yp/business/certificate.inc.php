<?php
defined('IN_YP') or exit('Access Denied');
if(!isset($action)) $action = 'manage';
require_once 'form.class.php';
require_once MOD_ROOT.'include/certificate.class.php';
$cert = new certificate();
$cert->set_userid($userid);

switch($action)
{
	case 'add':
	if($dosubmit)
	{
		$info['userid'] = $userid;
		$info['name'] = strip_tags($title);
		if(!$info['name']) showmessage('请填写证书名称');
		$info['organization'] = strip_tags($organization);
		if(!$info['organization']) showmessage('请填写发证机构');
		$info['thumb'] = htmlspecialchars($thumb);
		if(!$info['thumb']) showmessage('请上传证书');
		$info['effecttime'] = htmlspecialchars($effecttime);
		$info['endtime'] = htmlspecialchars($endtime);
		$info['addtime'] = TIME;
		$info['status'] = 1;
		$cert->add($info);
		showmessage('证书添加成功！', '?file=certificate&action=manage');
	}
	else
	{
		if($M['ischeck'] && $company_user_infos['status'] == 0) showmessage('您的公司正在审核当中...','goback');
	}
	break;
	
	case 'manage':
		
		$infos = $cert->listinfo("userid='$userid'",'',$page);
		$pages = $cert->pages;
	break;

	case 'delete':
		$id = intval($id);
		$cert->delete($id);
		showmessage('证书删除成功！', '?file=certificate&action=manage');
	break;
	
	case 'edit':

		$id = intval($id);
		if($dosubmit)
		{
			$info['name'] = strip_tags($title);
			if(!$info['name']) showmessage('请填写证书名称');
			$info['organization'] = strip_tags($organization);
			if(!$info['organization']) showmessage('请填写发证机构');
			$info['thumb'] = htmlspecialchars($thumb);
			if(!$info['thumb']) showmessage('请上传证书');
			$info['effecttime'] = htmlspecialchars($effecttime);
			$info['endtime'] = htmlspecialchars($endtime);
			if($M['check_cert']) $info['status'] = 0;
			$cert->edit($id,$info);
			showmessage('修改成功！', $forward);
		}
		else
		{
			$info = $cert->get($id);
		}
		
	break;
}
include template('yp', 'center_certificate');
?>