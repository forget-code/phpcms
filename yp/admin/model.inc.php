<?php
defined('IN_PHPCMS') or exit('Access Denied');

include MOD_ROOT.'admin/include/model.class.php';
$model = new model();
if(!$action) $action = 'manage';
if(!$forward) $forward = "?mod=$mod&file=$file&action=manage";

switch($action)
{
    case 'edit':
		if($dosubmit)
		{
			$result = $model->edit($modelid, $info);
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
			$info = $model->get($modelid);
			if(!$info) showmessage('指定的模块不存在！');
			extract($info);
			include admin_tpl('model_edit');
		}
		break;
    case 'manage':
        $infos = $model->listinfo('modeltype=9', 'modelid', 1, 100);
		include admin_tpl('model_manage');
		break;
	case 'urlrule':
		echo $type == 'category' ? form::select_urlrule('phpcms', 'category', $ishtml, 'info[category_urlruleid]', 'category_urlruleid', $category_urlruleid) : form::select_urlrule('phpcms', 'show', $ishtml, 'info[show_urlruleid]', 'show_urlruleid', $show_urlruleid);
		break;
    default :
}
?>