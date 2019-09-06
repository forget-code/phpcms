<?php
defined('IN_PHPCMS') or exit('Access Denied');
if ($dosubmit)
{
	$sendtime = time();
	$r = $db -> query("SELECT * FROM ".TABLE_MEMBER);
	while($s = $db->fetch_array($r))
	{
		$d = $s['newmessages'] + 1;
		$db->query("UPDATE ".TABLE_MEMBER." SET newmessages = $d WHERE userid = '$s[userid]'");
	}
	$db -> query("INSERT INTO ".TABLE_MESSAGE_INBOX." (sender,receiver,title,content,types,sendtime) VALUES ('$LANG[systems_manager]','null','$title','$content',1,'$sendtime')");
	if ($db -> affected_rows() > 0)
	{
		$msg = $LANG['operation_success'];
	}
	else
	{
		$msg = $LANG['operation_failure'];
	}
	showmessage($msg, $PHP_REFERER);
}
?>