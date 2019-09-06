<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/error.class.php';
$errors = new error();
switch($action)
{
	case 'list':
		$condition = array();
        if(isset($status)) $condition[] = "status = $status";
		$page = isset($page) ? intval($page) : 1;
		$pagesize	= $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 20;
		$error = $errors->get_list($condition, $page, $pagesize);
		$pages = $error['pages'];
		include admin_tpl('error.view');
	break;
	case 'delete':
        if(empty($errorid))
        {
            showmessage('请选择删除对象','?mod=error_report&file=error_report&action=list');
        }
        if($errors->drop($errorid)) showmessage('删除成功','?mod=error_report&file=error_report&action=list');
	break;
    case 'check':
        if(empty($errorid))
        {
            showmessage('请选择审核对象','?mod=error_report&file=error_report&action=list');
        }
        if($errors->check($errorid)) showmessage('审核成功','?mod=error_report&file=error_report&action=list');
    break;
}
?>