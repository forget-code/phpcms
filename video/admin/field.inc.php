<?php
defined('IN_PHPCMS') or exit('Access Denied');
@set_time_limit(600);

$submenu = array
(
	array('字段管理', '?mod='.$mod.'&file='.$file.'&action=manage'),
	array('添加字段', '?mod='.$mod.'&file='.$file.'&action=add'),
	array('更新字段缓存', '?mod='.$mod.'&file='.$file.'&action=cache'),
);
$menu = admin_menu('视频字段管理', $submenu);
if(!$action) $action = 'manage';

require MOD_ROOT.'admin/include/fields/fields.inc.php';
require MOD_ROOT.'admin/include/model_field.class.php';
require MOD_ROOT.'admin/include/model.class.php';
$field = new model_field($modelid);
$model = new model();
$modelinfo = $model->get($modelid);
$modelname = $modelinfo['name'];
$tablename = $field->tablename;

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
				extract($setting);
				extract($info);
				require MOD_ROOT.'admin/include/fields/'.$formtype.'/field_add.inc.php';
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			if(!is_ie()) showmessage('本功能只支持IE浏览器，请用IE浏览器打开。');
			$unsetgroups = form::checkbox($GROUP, 'unsetgroupids', 'unsetgroupids', '', 4);
			$unsetroles = form::checkbox($ROLE, 'unsetroleids', 'unsetroleids', '', 4);
		    require MOD_ROOT.'admin/include/fields/patterns.inc.php';
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
				extract($setting);
				extract($info);
				if($issystem) $tablename = DB_PRE.'video';
				require MOD_ROOT.'admin/include/fields/'.$formtype.'/field_edit.inc.php';
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			if(!is_ie()) showmessage('本功能只支持IE浏览器，请用IE浏览器打开。');
			$info = $field->get($fieldid);
			if(!$info) showmessage('指定的字段不存在！');
			extract(new_htmlspecialchars($info));
			$unsetgroups = form::checkbox($GROUP, 'unsetgroupids', 'unsetgroupids', $unsetgroupids, 4);
			$unsetroles = form::checkbox($ROLE, 'unsetroleids', 'unsetroleids', $unsetroleids, 4);
		    require MOD_ROOT.'admin/include/fields/patterns.inc.php';
			include admin_tpl('model_field_edit');
		}
		break;
	case 'copy':
		if($dosubmit)
		{
      		$info['modelid'] = $modelid;
			$info['formtype'] = $formtype;
            $info['unsetgroupids'] = isset($unsetgroupids) ? implodeids($unsetgroupids) : '';
            $info['unsetroleids'] = isset($unsetroleids) ? implodeids($unsetroleids) : '';
			$result = $field->add($info, $setting);
			if($result)
			{
				extract($setting);
				extract($info);
				require MOD_ROOT.'admin/include/fields/'.$formtype.'/field_add.inc.php';
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
			extract(new_htmlspecialchars($info));
			$unsetgroups = form::checkbox($GROUP, 'unsetgroupids', 'unsetgroupids', $unsetgroupids, 5);
			$unsetroles = form::checkbox($ROLE, 'unsetroleids', 'unsetroleids', $unsetroleids, 5);
		    require MOD_ROOT.'admin/include/patterns.inc.php';
			include admin_tpl('model_field_copy');
		}
		break;
    case 'manage':
        $infos = $field->listinfo("modelid=$modelid", 'listorder,fieldid', 1, 100);
		include admin_tpl('model_field_manage');
		break;
    case 'delete':
		$info = $field->get($fieldid);
		$result = $field->delete($fieldid);
		if($result)
		{
			extract($info);
			@extract(unserialize($setting));
			require MOD_ROOT.'admin/include/fields/'.$formtype.'/field_delete.inc.php';
			showmessage('操作成功！', '?mod=video&file=field&action=manage&modelid='.$modelid);
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
		require MOD_ROOT.'admin/include/fields/patterns.inc.php';
        require MOD_ROOT.'admin/include/fields/'.$formtype.'/field_add_form.inc.php';
		break;
    case 'setting_edit':
		$info = $field->get($fieldid);
		if(!$info) showmessage('指定的字段不存在！');
		eval("\$setting = $info[setting];");
		@extract($setting);
		require MOD_ROOT.'admin/include/fields/patterns.inc.php';
        require MOD_ROOT.'admin/include/fields/'.$formtype.'/field_edit_form.inc.php';
		break;
    case 'preview':
		if($dosubmit)
		{
			require CACHE_MODEL_PATH.'yp_input.class.php';
			require CACHE_MODEL_PATH.'yp_update.class.php';

			$content_input = new content_input($modelid);
			$info = $content_input->get($info);
            $systeminfo = $info['system'];
            $modelinfo = $info['model'];

			$systeminfo['userid'] = $_userid;
			$systeminfo['updatetime'] = TIME;

			$db->insert(DB_PRE.'content', $systeminfo);
			$contentid = $modelinfo['contentid'] = $db->insert_id();
			$db->insert($tablename, $modelinfo);
            
			$content_update = new content_update($modelid, $contentid);
			$content_update->update($info);

			showmessage(' 发布成功！');
		}
		else
		{
			require CACHE_MODEL_PATH.'yp_form.class.php';
			$content_form = new content_form($modelid);
			$forminfos = $content_form->get();
			include admin_tpl('content_add');
		}
		break;
	case 'checkfield':
		if(!$field->check($value))
		{
			exit('只能由英文字母、数字和下划线组成，必须以字母开头');
		}
		elseif($field->exists($value))
		{
			exit('字段名已存在');
		}
		else
		{
			exit('success');
		}
	break;
	
	case 'cache':
		$model->cache();
		$field->cache();
		showmessage('字段缓存 更新完成',"?mod=$mod&file=field");
	break;
}
?>