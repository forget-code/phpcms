<?php
defined('IN_PHPCMS') or exit('Access Denied');

$log->set('admin', 0);

$action = $action ? $action : 'manage';

switch($action)
{
	case 'manage':
	    $where = '';
	    if($s_module) $where .= "AND `module`='$s_module' ";
	    if($s_file) $where .= "AND `file`='$s_file' ";
	    if($s_action) $where .= "AND `action`='$s_action' ";
	    if($s_url) $where .= "AND `querystring` LIKE '%$s_url%' ";
	    if($s_username)
	    {
			$userid = userid($s_username);
			$username = $s_username;
		}
	    if($userid)
	    {
			if(!$username) $username = username($userid);
			if(!$s_username) $s_username = $username;
			$where .= "AND `userid`='$userid' ";
		}
	    if($s_ip) $where .= "AND `ip`='$s_ip' ";
	    if($s_fromdate) $where .= "AND `time`>='$s_fromdate 00:00:00' ";
	    if($s_todate) $where .= "AND `time`<='$s_todate 23:59:59' ";
		if($where) $where = substr($where, 3);
		$data = $log->listinfo($where, $page, 20);
		include admin_tpl('log');
		break;

    case 'delete':
		$admin_founders = explode(',',ADMIN_FOUNDERS);
		if(!in_array($_userid,$admin_founders)) showmessage('为了安全，只有创始人才能删除日志');
		$log->delete($module, $fromdate, $todate);
		showmessage($LANG['operation_success'],'?mod=phpcms&file=log');
		break;

    case 'clear':
		$admin_founders = explode(',',ADMIN_FOUNDERS);
		if(!in_array($_userid,$admin_founders)) showmessage('为了安全，只有创始人才能删除日志');
		$log->clear();
		showmessage($LANG['operation_success'],'?mod=phpcms&file=log');
		break;
}
?>