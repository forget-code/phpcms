<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($forward) $forward = HTTP_REFERER;
switch ($action) 
{
	case 'manage':
		if ($dosubmit)
		{
			if(!$del_msgid) showmessage('请选择短消息');
			if(!$message_admin->delete($del_msgid))
			{
				showmessage($message->msg(), $forward);
			}
			showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			$where = '';
			if($username)
			{
				if(!class_exists('member'))
				{
					require PHPCMS_ROOT.'member/include/member.class.php';
				}
				$member = new member();
				$userid = $member->get_userid($username);
				$where  .= $where ?  " AND send_from_id='$userid'" : " send_from_id='$userid'";
			}
			if($subject)
			{
				$where .= $where ? " AND subject LIKE '%$subject%'" : "subject LIKE '%$subject%'";
			}
			if($datestart) 
			{
				$start_time = strtotime($datestart);
				$where .= $where ? " AND $start_time <= message_time" : " $start_time <= message_time";
			}
			if ($dateend)
			{
				$end_time = strtotime($dateend);
				$where .= $where ? " AND message_time <= $end_time": " message_time <= $end_time";;
			}
			$arr_message = array();
			$where .= $where ? " AND replyid=0" : " replyid=0";
			if(!$order) $order = "messageid ASC";
			$page = max(intval($page), 1);
			$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 30;
			$arr_message = $message_admin->list_message($where, $order, $page, $pagesize);
			$message_num = $message_admin->count_message($where);
			$pages = pages($message_num, $page, $pagesize);
			include admin_tpl('manage');
		}
		break;
	case 'delete':
		if($dosubmit)
		{
			if(!$message_admin->del_by_time($time))
			{
				showmessage($message_admin->msg(), $forward);
			}	
			showmessage($LANG['operation_success'], $forward);
		}
		else 
		{
			$stat = load('stat.class.php');
			$del_from_array = array(0=>'选择删除条件',7=>'一周前',30=>'一个月前',1=>'全部');
			$num_inbox = $message_admin->num_inbox();
			$num_outbox = $message_admin->num_outbox();
			include admin_tpl('delete_msg');
		}
		break;
	default:
		include admin_tpl('manage');
		break;
}
?>