<?php
if(isset($submit))
{
	$typeid = intval($typeid);
	if(!$title) showmessage($LANG['mail_title_not_null']);
	if(!$typeid) showmessage($LANG['select_correct_subscription_type']);
	if(!$content) showmessage($LANG['mail_content_not_null']);
	if(!$period) showmessage($LANG['input_period']);

	$sql="INSERT INTO ".TABLE_MAIL.
		"(typeid,title,content,addtime,username,period)".
		"VALUES('$typeid','$title','$content','$PHP_TIME','$_username','$period')";
	$result=$db->query($sql);	
	showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
}
$typeid = isset($typeid) ? $typeid : 0 ;
$type_select = type_select('typeid',$LANG['select_subscription_type'],$typeid,'');	
include admintpl("subscription_add");
?> 