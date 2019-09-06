<?php
require './include/common.inc.php';
if(!$_userid) showmessage($LANG['please_login'], $MODULE['member']['url'].'login.php?forward='.urlencode(URL));
if(!$forward) $forward = HTTP_REFERRE;

switch ($action) 
{
	case 'export':
		if(!is_array($arr_msgid) || empty($arr_msgid)) showmessage($LANG['please_choose_msg'], $forward);
		$arr_message = $message->export($arr_msgid);
		$xls = load('excel_xml.class.php', 'message');
		$xls->addArray ($arr_message);
		$xls->generateXML($LANG['inbox']);
		break;
	case 'delete':
		if(empty($arr_msgid)) showmessage('请选择短消息', $forward);
		if(!$message->delete_message($arr_msgid, $_userid))
		{
			showmessage($message->msg(), $forward);
		}
		showmessage('操作成功', $forward);
		break;
	default: 
		$head['title'] = $anoucement = $LANG['inbox'];
		$leastmsg = $G['allowmessage'] - $new_message;
		$message_num = $message->count_message($where=" send_to_id='$_userid' AND (folder='inbox' OR folder='all') AND replyid=0");
		$page = max(intval($page), 1);
		$pagesize = 10;
		$pages = pages($message_num, $page, $pagesize);
		$arr_message = $message->inbox($_userid, $page, $pagesize);
		include template($mod, 'inbox');
	break;
}
?>