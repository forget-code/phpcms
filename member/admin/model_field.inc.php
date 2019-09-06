<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/fields/fields.inc.php';
require_once MOD_ROOT.'admin/include/model_member.class.php';
require_once MOD_ROOT.'admin/include/model_member_field.class.php';
$model = new member_model();
$field = new member_model_field($modelid);

$modelinfo = $model->get($modelid);
$modelname = $modelinfo['name'];
$tablename = $field->tablename;
$submenu = array(
	array('添加字段', '?mod='.$mod.'&file='.$file.'&action=add&modelid='.$modelid),
	array('管理字段', '?mod='.$mod.'&file='.$file.'&action=manage&modelid='.$modelid),
	array('预览模型', '?mod='.$mod.'&file='.$file.'&action=preview&modelid='.$modelid),
);
$menu = admin_menu($modelname.'模型字段管理', $submenu);
if(!$action) $action = 'manage';
if(!$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=manage&modelid='.$modelid;

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$info['modelid'] = $modelid;
            $info['unsetgroupids'] = isset($unsetgroupids) ? implodeids($unsetgroupids) : '';
            $info['unsetroleids'] = isset($unsetroleids) ? implodeids($unsetroleids) : '';
			$result = $field->add($info, $setting);
			if($result)
			{
				@extract(new_htmlspecialchars($setting));
				@extract(new_htmlspecialchars($info));
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
			$roles = cache_read('role.php');
			$unsetroles = form::checkbox($roles, 'unsetroleids', 'unsetroleids', '', 5);
		    require_once MOD_ROOT.'admin/include/fields/patterns.inc.php';
		    require_once 'fields/patterns.inc.php';
			include admin_tpl('model_field_add');
		}
		break;
    case 'edit':
		if($dosubmit)
		{
            $info['unsetgroupids'] = isset($unsetgroupids) ? implodeids($unsetgroupids) : '';
            $info['unsetroleids'] = isset($unsetroleids) ? implodeids($unsetroleids) : '';
			$result = $field->edit($fieldid, $info, $setting);
			if($result)
			{
				@extract($setting);
				@extract($info);
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
			$info = $field->get($fieldid);
			if(!$info) showmessage('指定的字段不存在！');
			@extract(new_htmlspecialchars($info));
			$unsetgroups = form::checkbox($GROUP, 'unsetgroupids', 'unsetgroupids', $unsetgroupids, 5);
			$roles = cache_read('role.php');
			$unsetroles = form::checkbox($roles, 'unsetroleids', 'unsetroleids', $unsetroleids, 5);
		    require_once MOD_ROOT.'admin/include/fields/patterns.inc.php';
			include admin_tpl('model_field_edit');
		}
		break;
	case 'copy':
		if($dosubmit)
		{
			$info['modelid'] = $modelid;
			$info['formtype'] = $formtype;
		    $info['setting'] = addslashes(serialize($setting));
            $info['unsetgroupids'] = isset($unsetgroupids) ? implodeids($unsetgroupids) : '';
            $info['unsetroleids'] = isset($unsetroleids) ? implodeids($unsetroleids) : '';
			$result = $field->add($info, $setting);
			if($result)
			{
				@extract(new_htmlspecialchars($setting));
				@extract(new_htmlspecialchars($info));
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
			$info = $field->get($fieldid);
			if(!$info) showmessage('指定的字段不存在！');
			@extract(new_htmlspecialchars($info));
			$unsetgroups = form::checkbox($GROUP, 'unsetgroupids', 'unsetgroupids', $unsetgroupids, 5);
			$roles = cache_read('role.php');
			$unsetroles = form::checkbox($roles, 'unsetroleids', 'unsetroleids', $unsetroleids, 5);
		    require_once MOD_ROOT.'admin/include/fields/patterns.inc.php';
			include admin_tpl('model_field_copy');
		}
		break;
    case 'manage':
        $infos = $field->listinfo("modelid=$modelid", 'listorder,fieldid', 1, 100);
	    $field->cache();
		include admin_tpl('model_field_manage');
		break;
    case 'delete':
		$info = $field->get($fieldid);
		$result = $field->delete_field($fieldid);
		if($result)
		{
			@extract($info);
			require_once MOD_ROOT.'admin/include/fields/'.$formtype.'/field_delete.inc.php';
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;
    case 'listorder':
		$result = $field->listorder($info);
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
		$result = $field->disable($fieldid, $disabled);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;
    case 'setting_add':
		require_once MOD_ROOT.'admin/include/fields/patterns.inc.php';
        require_once MOD_ROOT.'admin/include/fields/'.$formtype.'/field_add_form.inc.php';
		break;
    case 'setting_edit':
		$info = $field->get($fieldid);
		if(!$info) showmessage('指定的字段不存在！');
		eval("\$setting = $info[setting];");
		@extract($setting);
		require_once MOD_ROOT.'admin/include/fields/patterns.inc.php';
        require_once MOD_ROOT.'admin/include/fields/'.$formtype.'/field_edit_form.inc.php';
		break;
    case 'preview':
		if($dosubmit)
		{
			showmessage('发布成功');
		}
		else
		{	
			require CACHE_MODEL_PATH.'member_form.class.php';
			$member_form = new member_form($modelid);
			$forminfos = $member_form->get();
			include admin_tpl('member_model_add');
		}
		break;
	case 'checkfield':
		if($field->field_exsited($modelid, $value))
		{
			exit('该字段已存在');
		}
		elseif(!preg_match("/^[a-zA-Z0-9_][a-zA-Z0-9_]+$/", $value))
		{
			exit('包含不合法字符');
		}
		else
		{
			exit('success');
		}
		break;
    default :
}
?>