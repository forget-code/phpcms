<?php
defined('IN_PHPCMS') or exit('Access Denied');
include MOD_ROOT.'include/announce.class.php';
$a = new announce;
$page = $page ? $page : 1;
$pagesize = $M['pagesize'] ? $M['pagesize'] : 20;
$action = $action ? $action : 'manage';
switch($action)
{	
	case 'manage':
		$condition = " where 1 and  passed=1 and (todate > '".date('Y-m-d')."' or todate='0000-00-00')";
		$annou = $a->listinfo($page,$pagesize,$condition);
		include admin_tpl('announce_manage');
	break;

	case 'delete':
		if(empty($aid))
		{
			showmessage($LANG['illegal_parameters'],$forward);
		}
		$result = $a->delete($aid);
		if($result)
		{
			showmessage($LANG['operation_success'],$forward);
		}
		else 
		{
			showmessage($LANG['operation_failure'],$forward);
		}
	break;

	case 'approval':
		if(isset($submit))
		{
			if(empty($aid))
			{
				showmessage($LANG['illegal_parameters'],$forward);
			}

			$result = $a->approval($aid,$passed);	
				
			if($result)
			{
				showmessage($LANG['operation_success'],'?mod=announce&file=announce&action=manage');
			}
			else
			{
				showmessage($LANG['operation_failure'],$forward);
			}
		}
		else
		{
			$condition = " where 1 and  passed=0 ";
			$annou = $a->listinfo($page,$pagesize,$condition);
			include admin_tpl('announce_approval');
		}
	break;

	case 'expired':
		$condition = " where 1 and todate <= '".date('Y-m-d')."' and todate != '0000-00-00' ";
		$annou = $a->listinfo($page,$pagesize,$condition);
		include admin_tpl('announce_expired');
	break;

	case 'add':
		if(isset($submit))
		{
			if(empty($announce['title']))
			{
				showmessage('公告标题不能为空',$forward);
			}
			if(empty($announce['content']))
			{
				showmessage('公告内容不能为空',$forward);
			}
			if(trim($announce['todate']) !='' && $announce['todate'] <= date('Y-m-d'))
			{	
				showmessage('截止日期要晚于当前日期',$forward);
			}
			$result = $a->add($announce);
			if($result)
			{
				showmessage($LANG['operation_success'], '?mod=announce&file=announce&action=manage');
			}
			else 
			{
				showmessage($this->lang['operation_failure'],$forward);
			}
		}
		include admin_tpl('announce_add');
	break;

	case 'edit':
		if(isset($submit))
		{	
			if(empty($announce['title']))
			{
				showmessage('公告标题不能为空',$forward);
			}
			if(empty($announce['content']))
			{
				showmessage('公告内容不能为空',$forward);
			}
			$where = " announceid = $aid ";
			$result = $a->edit($announce,$where);
			if($result)
			{
				showmessage($LANG['operation_success'], '?mod=announce&file=announce&action=manage');
			}
			else 
			{
				showmessage($LANG['operation_failure'],$forward);

			}
		}
		else
		{
			$announ = $a->getone($aid);
			include admin_tpl('announce_edit');
		}		
	break;
}

?>