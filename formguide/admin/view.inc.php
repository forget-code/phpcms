<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!class_exists('formguide_admin'))
{
	require MOD_ROOT.'admin/include/formguide_fields.class.php';
}
$formguide_fields = new formguide_fields($formid);

if(!class_exists('formguide_form'))
{
	require CACHE_MODEL_PATH.'formguide_form.class.php';
}
$formguide_form = new formguide_form($formid);

if(!class_exists('formguide_output'))
{
	require CACHE_MODEL_PATH.'formguide_output.class.php';
}
$formguide_output = new formguide_output($formid);

if(!$action) $action = 'manage';
if(!$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=manage&formid='.$formid;

switch($action)
{
	case 'delete':
		if(empty($dataid)) showmessage('请选择需要删除的信息ID', $forward);
		if($formguide_fields->deleteinfo($dataid))
		{
			showmessage('操作成功', $forward);
		}
		else
		{
			showmessage('操作失败', $forward);
		}
	break;
	case 'manage':
		if(!class_exists('formguide_search_form'))
		{
			require CACHE_MODEL_PATH.'formguide_search_form.class.php';
		}
		$formname = $FORMGUIDE[$formid]['name'];
		$form = new formguide_search_form($formid);
		$where = $form->get_where();
		$page = max(intval($page), 1);
		$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 30;	
		$forminfos = $formguide_form->get();
		$formname = $FORMGUIDE[$formid]['name'];
		$result = $formguide_fields->listview($page, $pagesize);
		include admin_tpl('view');
	break;
}
?>