<?php
require './include/common.inc.php';

if($dosubmit)
{
	if(strlen($reply) > 10000 || empty($reply)) showmessage($LANG['reply_content_not_null_less_than_10000']); 

	$askid = intval($askid);
	$reply = str_safe($reply);

	$subject = $db->get_one("select * from ".TABLE_ASK." where askid=$askid");
	if(!$subject) showmessage($LANG['sorry_not_exist_record']);
	if($subject['username'] != $_username) showmessage($LANG['illegal_operation']);

	$db->query("insert into ".TABLE_ASK_REPLY."(askid,reply,username,ip,addtime) values('$askid','$reply','$_username','$PHP_IP','$PHP_TIME')");
	if($db->affected_rows() > 0 )
	{
	    $db->query("UPDATE ".TABLE_ASK." SET lastreply='$PHP_TIME' WHERE askid=$askid");
		showmessage($LANG['reply_post_success'], $forward);
	}
	else
	{
		showmessage($LANG['reply_post_fail_contract_to_administratro']);
	}
}
?>