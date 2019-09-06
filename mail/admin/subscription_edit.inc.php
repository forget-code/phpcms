<?php

if(empty($mailid)) showmessage($LANG['illegal_parameters']);
$mailid = intval($mailid);
if($dosubmit)
{
	$typeid = intval($typeid);
	if(!$title) showmessage($LANG['mail_title_not_null']);
	if(!$typeid) showmessage($LANG['select_correct_subscription_type']);
	if(!$content) showmessage($LANG['mail_content_not_null']);
	if(!$period) showmessage($LANG['input_period']);

	$sql="UPDATE ".TABLE_MAIL.
		" SET typeid='".$typeid."',title='".$title."',content='".$content."',addtime='".$PHP_TIME."',period='".$period."',username='".$_username."' ".
		"WHERE mailid=".$mailid;	
	$result = $db->query($sql);	
	showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
}

$mail = $db->get_one("SELECT * FROM ".TABLE_MAIL." where mailid = $mailid limit 1");
$typeid = isset($typeid) ? $typeid : $mail['typeid'] ;
$type_select = type_select('typeid',$LANG['select_subscription_type'],$typeid,'');	
$mail=new_htmlspecialchars($mail);

if (count($mail)<1) showmessage($LANG['cannot_find_record_return'],$referer);

include admintpl("subscription_edit");
?> 