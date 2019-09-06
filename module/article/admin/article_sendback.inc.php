<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	if(empty($articleid))
	{
		showmessage($LANG['invalid_parameters'],'goback');
	}
	if(isset($ifpm))
	{
		if(empty($title))
		{
			showmessage($LANG['short_title_can_not_be_blank'],'goback');
		}
		if(empty($content))
		{
			showmessage($LANG['content_can_not_be_blank'],'goback');
		}
		//sendpm($username,$title,$content);
		$db->query("INSERT INTO ".TABLE_MESSAGE_INBOX." (sender,receiver,title,content,sendtime) VALUES ('$_username','$username','$title','$content',$PHP_TIME)");
	}
	if(isset($ifemail))
	{
		$r = $db->get_one("SELECT email FROM ".TABLE_MEMBER." WHERE username='$username' LIMIT 0,1");
		if($r['email'] && is_email($r['email']))
		{
			require PHPCMS_ROOT.'/include/mail.inc.php';
			sendmail($r['email'], $title, stripslashes($content));
		}
		//sendusermail($username,$title,$content);
	}
	$db->query("UPDATE ".channel_table('article', $channelid)." SET status=2 WHERE articleid=$articleid ");
	showmessage($LANG['operation_success'],$referer);
}
else
{
	if(empty($articleid))
	{
		showmessage($LANG['invalid_parameters'],'goback');
	}
	$article=$db->get_one("SELECT title,catid,username,status FROM ".channel_table('article', $channelid)." WHERE articleid='$articleid' ");
	if($article['title'])
	{
		$article['status'] == 1 or showmessage($LANG['can_not_access'],'goback');
	}
	else
	{
		showmessage($LANG['article_not_exists'],'goback');
	}
	include admintpl($mod.'_sendback');
}
?>