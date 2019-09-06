<?php
/*用户模型添加*/
defined('IN_PHPCMS') or exit('Access Denied');
$menu = admin_menu($LANG['my_field_manage'],$submenu);
require_once MOD_ROOT.'admin/include/model_member.class.php';
$model = new member_model();
if(!$action) $action = 'manage';
if(!$forward) $forward = HTTP_REFERER;
switch($action)
{
	case 'add':
		if($dosubmit)
		{
			if($model->add($info)) showmessage('操作成功！', $forward);
			showmessage($model->msg(), $forward);
		}
		else
		{	
			include admin_tpl('model_add');
		}
		break;
	case 'edit':
		if($dosubmit)
		{
			if($model->edit($modelid, $info)) showmessage('操作成功！', $forward);
			showmessage('操作失败！');
		}
		else
		{
			$info = $model->get($modelid);
			if(!$info) showmessage('指定的模块不存在！');
			extract($info);
			include admin_tpl('model_edit');
		}
		break;
	case 'manage':
		$page = max(intval($page), 1);
		$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 30;
		$infos = new_htmlspecialchars($model->listinfo("modeltype='2'", 'modelid', $page, $pagesize));
		include admin_tpl('model_manage');
		break;
	case 'delete':
		if($model->delete_model($modelid)) showmessage('操作成功！');
		showmessage('操作失败！');
		break;
	case 'disable':
		if($model->disable($modelid, $disabled)) showmessage('操作成功！', $forward);
		showmessage('操作失败！');
		break;
	case 'export':
		$result = $model->export($modelid);
		$filename = $result['arr_model']['tablename'].'.model';
		cache_write($filename, $result, CACHE_MODEL_PATH);
		file_down(CACHE_MODEL_PATH.$filename, $filename);
		break;
	case 'import':
		if(!class_exists('attachment'))
		{
			require 'attachment.class.php';	
		}
		$attachment = new attachment($mod);
		if($dosubmit)
		{
			if(!$modelname) showmessage('请输入模型名称');
			if(!$tablename) showmessage('请输入表名');
			$aid = $attachment->upload('modelfile', 'model');
			if(!$aid) showmessage($attachment->error(), $forward);
			$filepath = $attachment->get($aid[0], 'filepath');
			$array = include(UPLOAD_ROOT.$filepath['filepath']);
			$array['arr_model']['tablename'] = $tablename;
			$array['arr_model']['name'] = $modelname;
			$array['arr_model']['description'] = $description;
			$modelid = $model->import($array);
			if(!$modelid) showmessage($model->msg, $forward);
			if(is_array($array['arr_field']) && !empty($array['arr_field']) && $modelid)
			{
				@extract(new_htmlspecialchars($array['arr_model']));
				$tablename = DB_PRE.'member_'.$tablename;
				foreach($array['arr_field'] as $arr_field)
				{
					$arr_field['modelid'] = $modelid;
					$arr_field['setting'] = new_addslashes($arr_field['setting']);
					$db->insert(DB_PRE.'model_field', $arr_field);
					@extract($arr_field);
					$setting = new_stripslashes($setting);
					eval("\$setting = $setting;");
					@extract($setting);
					$excutefile = file_get_contents(MOD_ROOT.'admin/include/fields/'.$formtype.'/field_add.inc.php');
					$excutefile = str_replace('<?php', '', $excutefile);
					$excutefile = str_replace('?>', '', $excutefile);
					eval($excutefile);
				}
			}
			$attachment->delete("aid='$aid[0]'");
			showmessage('操作成功！', $forward);
		}
		else
		{
			include admin_tpl('model_import');
		}
		break;
	case 'checktable':
		if(!preg_match("/^[a-z0-9_][a-z0-9_]+$/", $value))
		{
			exit('字符只能包含英文字母，数字与下划线且必须为小写');
		}
		elseif ($model->check_tablename($value)) 
		{
			exit('表名已经存在');
		}
		else
		{
			exit('success');
		}
		break;
	case 'checkmodel';
		if ($model->check_modelname($value, $modelid))
		{
			exit('模型名称已经存在');
		}
		else
		{
			exit('success');
		}
		break;
	default :
}
?>