<?php
defined('IN_PHPCMS') or exit('Access Denied');
if ($dosubmit)
{
	!empty($content) or showmessage($LANG['please_input_content'], $PHP_REFERER);
	$addtime = time();
	$db->query("insert into " . TABLE_ANNOUNCE . "(keyid,title,content,fromdate,todate,username,addtime,passed,templateid,skinid) values('$keyid','$atitle','$content','$fromdate','$todate','$_username','$addtime','$passed','$templateid','$skinid')");
	if ($db->affected_rows() > 0)
	{
		$msg = $LANG['operation_success'];
		$referer = "?mod=$mod&file=$file&action=manage&passed=$passed&keyid=$keyid";
	}
	else
	{
		$msg = $LANG['operation_failure'];
		$referer = $PHP_REFERER;
	}
	showmessage($msg, $referer);
}
?>