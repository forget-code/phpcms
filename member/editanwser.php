<?php
require './include/common.inc.php';
if(!$_userid) showmessage($LANG['please_login'], $M['url'].'login.php?forward='.urlencode(URL));
if(!$forward) $forward = HTTP_REFERER;

if($dosubmit)
{
	if(!$member->edit_answer($info['question'], $info['answer'], $info['password']))
	{
		showmessage($member->msg(), $forward);
	}
	showmessage('操作成功', $forward);
}
else
{
	$avatar = avatar($_userid);
	include template($mod, 'editanswer');
}
?>