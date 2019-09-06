<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!$forward) $forward = HTTP_REFERER;
if(!$action) $action = 'manage';
if(!class_exists('formguide_admin'))
{
	require MOD_ROOT.'admin/include/formguide_admin.class.php';
}
$formguide_admin = new formguide_admin();

if(!class_exists('formguide_fields'))
{
	require MOD_ROOT.'admin/include/formguide_fields.class.php';
}
$formguide_fields = new formguide_fields($formid);
require_once MOD_ROOT.'admin/include/fields/patterns.inc.php';
require MOD_ROOT.'admin/include/fields/fields.inc.php';
$tablename = DB_PRE.'form_'.$FORMGUIDE[$formid]['tablename'];
$submenu = array(
	array('添加字段', '?mod='.$mod.'&file='.$file.'&action=add&formid='.$formid),
	array('管理字段', '?mod='.$mod.'&file='.$file.'&action=manage&formid='.$formid),
	array('预览表单', '?mod='.$mod.'&file='.$file.'&action=preview&formid='.$formid),
);
$menu = admin_menu('字段管理', $submenu);
if(!$forward) $forward = "?mod=$mod&file=$file&action=manage";

switch ($action) 
{
	case 'add':
		if($dosubmit)
		{
			$info['formid'] = $formid;
			$info['unsetgroupids'] = isset($unsetgroupids) ? implodeids($unsetgroupids) : '';
			if(!$result = $formguide_fields->add($info, $setting))
			{
				showmessage($formguide_fields->msg(), 'goback');
			}
			if($result)
			{
				extract($setting);
				extract($info);
				require_once MOD_ROOT.'admin/include/fields/'.$formtype.'/field_add.inc.php';
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else 
		{
			$unsetgroups = form::checkbox($GROUP, 'unsetgroupids', 'unsetgroupids', '', 5);
			include admin_tpl('fields_add');
		}
		break;
	case 'edit':
		if($dosubmit)
		{
			$info['unsetgroupids'] = isset($unsetgroupids) ? implodeids($unsetgroupids) : '';
			$result = $formguide_fields->edit($fieldid, $info, $setting);
			if($result)
			{
				extract($setting);
				extract($info);
				require_once MOD_ROOT.'admin/include/fields/'.$formtype.'/field_edit.inc.php';
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else 
		{
			$infos = $formguide_fields->get($fieldid);
			@extract(new_htmlspecialchars($infos));
			$unsetgroups = form::checkbox($GROUP, 'unsetgroupids', 'unsetgroupids', $unsetgroupids, 5);
			include admin_tpl('fields_edit');
		}
		break;
	case 'copy':
		if($dosubmit)
		{
			$info['formid'] = $formid;
			$info['formtype'] = $formtype;
			$info['unsetgroupids'] = isset($unsetgroupids) ? implodeids($unsetgroupids) : '';
			if(!$result = $formguide_fields->add($info, $setting))
			{
				showmessage($formguide_fields->msg(), 'goback');
			}
			if($result)
			{
				extract($setting);
				extract($info);
				require_once MOD_ROOT.'admin/include/fields/'.$formtype.'/field_add.inc.php';
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			$info = $formguide_fields->get($fieldid);
			if(!$info) showmessage('指定的字段不存在！');
			@extract(new_htmlspecialchars($info));
			$unsetgroups = form::checkbox($GROUP, 'unsetgroupids', 'unsetgroupids', $unsetgroupids, 5);
			include admin_tpl('fields_copy');
		}		
	break;
	case 'manage':
		$where = "formid='$formid'";
		$infos = $formguide_fields->listinfo($where);
		include admin_tpl('fields_manage');
		break;
	case 'setting_add':
		require_once MOD_ROOT.'admin/include/fields/'.$formtype.'/field_add_form.inc.php';
		break;
	case 'setting_edit':
		$info = $formguide_fields->get($fieldid);
		if(!$info) showmessage('指定的字段不存在！');
		eval("\$setting = $info[setting];");
		@extract($setting);
		require_once MOD_ROOT.'admin/include/fields/'.$formtype.'/field_edit_form.inc.php';
		break;
	case 'delete':
		$info = $formguide_fields->get($fieldid);
		$formguide_fields->delete($fieldid);
		@extract($info);
		require_once MOD_ROOT.'admin/include/fields/'.$formtype.'/field_delete.inc.php';
		showmessage('操作成功');
		break;
	case 'listorder':
		$formguide_fields->listorder($info);
		showmessage('操作成功');
		break;
	case 'preview':
		require CACHE_MODEL_PATH.'formguide_form.class.php';
		$formguide_form = new formguide_form($formid);
		$forminfos = $formguide_form->get();
		include admin_tpl('form_add');
		break;
	
	case 'disabled':
		$formguide_fields->disabled($fieldid, $disabled);
		showmessage('操作成功', $forward);
		break;
	case 'checkfield':
		if($formguide_fields->field_exsited($value, $formid, $fieldid))
		{
			exit('字段已存在');
		}
		elseif(!preg_match("/^[a-zA-Z_][a-zA-Z0-9_]+$/", $value))
		{
			exit('字符只能包含英文字母，数字和下划线');
		}
		else
		{
			exit('success');
		}
		break;
	case 'checkname':
		if($formguide_fields->fieldname_exsited($value, $formid, $fieldid))
		{
			exit('字段名已存在');
		}
		else
		{
			exit('success');
		}
		break;
	default:
		break;
}
?>