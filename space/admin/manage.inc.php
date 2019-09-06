<?php
defined('IN_PHPCMS') or exit('Access Denied');

if (!$forward) $forward = HTTP_REFEER;
//error_reporting(E_ALL);
switch ($action) 
{

	case 'add':
		if ($dosubmit)
		{
			if(!$space_admin->add_api($info)) 
			{
				showmessage($space_admin->msg());
			}
			showmessage($LANG['operation_success'], "?mod=$mod&file=$file&action=manage");
		}
		else 
		{
			include admin_tpl('add');
		}
	break;
	case 'manage':
		$page = max(intval($page), 1);
		$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 30;
		$num_api = $space_admin->count_api();
		$pages = pages($num_api, $page, $pagesize);
		$api_info = $space_admin->list_api($where, $order, $page, $pagesize);
		include admin_tpl('manage');
	break;
	case 'edit':
		if ($dosubmit)
		{
			if(!$space_admin->edit_api($info))
			{
				exit('ok');
				showmessage($space_admin->msg(), $forward);
			}
			showmessage($LANG['operation_success'], $forward);
		}
		else 
		{
			$api_info = $space_admin->get_api($apiid);
			extract($api_info);
			include admin_tpl('edit');
		}
	break;
	case  'disable':
		$space_admin->disable($apiid, $val);
		showmessage($LANG['operation_success'], $forward);
		break;
	case 'delete':
		$space_admin->delete_api($apiid);
		showmessage($LANG['operation_success']);
	break;
	case 'listorder':
		$space_admin->listorder($listorders);
		showmessage($LANG['operation_success'], $forward);
	break;
	case 'modulepath':
		$module = $db->get_one("SELECT url FROM ".DB_PRE."module WHERE module='$name'");
		$url = $module['url'];
		exit($url);
	break;
}
?>