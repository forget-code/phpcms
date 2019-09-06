<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once MOD_ROOT.'admin/include/formguide_admin.class.php';
require_once MOD_ROOT.'admin/include/formguide_fields.class.php';

$formguide_admin = new formguide_admin();

if(!$action) $action = 'manage';
if(!$forward) $forward = "?mod=$mod&file=$file&action=manage";

switch($action)
{
	case 'add':
		if($dosubmit)
		{
			$formid = $formguide_admin->add($info, $setting);
			if(!$formid)
			{
				showmessage($formguide_admin->msg(), $forward);
			}
			$formguide_fields = new formguide_fields($formid);
			$formguide_fields->cache();
			showmessage('操作成功', $forward.'&formid='.$formid);
		}
		else
		{
			
			include admin_tpl('add');
		}
	break;
	case 'edit':
		if($dosubmit)
		{
			$formguide_admin->edit($formid, $info, $setting);
			$formguide_fields = new formguide_fields($formid);
			$formguide_fields->cache();
			showmessage('操作成功', $forward);
		}
		else
		{
			$result = $formguide_admin->get($formid);
			@extract(new_htmlspecialchars($result));
			@extract($setting);
			if($starttime) $starttime = date('Y-m-d', $starttime);
			if($endtime) $endtime = date('Y-m-d', $endtime);
			include admin_tpl('edit');
		}
	break;
	case 'manage':
		if($formname) $where = " name LIKE '%$formname%'";
		$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 30;
		if(!$order) $order = ' formid DESC';
		$arr_info = $formguide_admin->listinfo($where, $order, $page, $pagesize);
		include admin_tpl('manage');
	break;
	case 'delete':
		if(empty($formid)) showmessage('请选择要删除的表单');
		$formguide_admin->delete($formid);
		showmessage('操作成功', '?mod=formguide&file=manage&action=manage');
	break;
	case 'disabled':
		$formguide_admin->disabled($formid, $val);
		$formguide_fields = new formguide_fields($formid);
		$formguide_fields->cache();
		showmessage('操作成功', $forward);
	break;
	case 'checktable':
		if(!preg_match("/^[a-z0-9_][a-z0-9_]+$/", $value))
		{
			exit('字符只能包含英文字母，数字与下划线且必须为小写');
		}
		elseif ($formguide_admin->check_tablename($value, $formid)) 
		{
			exit('表名已经存在');
		}
		else
		{
			exit('success');
		}
	break;
	case 'checkmodel';
		if ($formguide_admin->check_formname($value, $formid))
		{
			exit('表单名称已经存在');
		}
		else
		{
			exit('success');
		}
	break;

}
?>