<?php
require './include/common.inc.php';
require PHPCMS_ROOT.'include/form.class.php';

if(!isset($forward)) $forward = HTTP_REFERER;
if ($dosubmit)
{
	if(empty($content))
	{
		showmessage('短消息不能为空');
	}
	if(!$message->reply($replyid, $msgtoid, $_userid, $content))
	{
		showmessage($message->msg(), $forward);
	}
	$memberinfo = array('userid'=>$msgtoid, 'message'=>1);
	$member->edit($memberinfo);
	showmessage('短消息回复成功', $forward);
}
else
{
	$message_info = $out ? $message->read_send($_userid, $msgid) : $message->read($_userid, $msgid);
	
	if(!$message_info)
	{
		showmessage($message->msg(), $forward);
	}
	$box = $out ? $LANG['outbox'] : $LANG['inbox'];
	@extract($message_info);
	$msgtoid = $out ? $send_to_id : $send_from_id;
	unset($message_info);
	$reply_message = $message->list_reply($msgid);
	$head['title'] = $LANG['msg_center'];
	include template($mod, 'read');
}
?>