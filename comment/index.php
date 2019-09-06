<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/
require "common.php";

$referer = $referer ? $referer : $PHP_REFERER;

switch($action)
{
	case 'add':
		if($_PHPCMS['comment_checkuser'] && !$_userid) message('抱歉！本站禁止游客评论！','goback');
		if($_PHPCMS['comment_checkcode'] && getcookie('randomstr') != $checkcode)
		{
			message('验证码不正确！','goback');
		}
		if(strlen($content)<2) message("评论内容不得少于2个字节！",'goback');
		if(strlen($content)>$_PHPCMS['comment_maxcontent'])	message("评论内容不得大于".$_PHPCMS['comment_maxcontent']."个字节！",'goback');
		if($_PHPCMS['comment_mintime'])
	    {
			$comment_time = getcookie('comment_time');
			if($comment_time + $_PHPCMS['comment_mintime'] > $timestamp) message("连续两次发表评论的时间间隔不得少于".$_PHPCMS['comment_mintime']."秒！","goback");
		    mkcookie('comment_time',$timestamp);
		}

		$username = $_username ? $_username : 'Guest';
		$score = intval($score);
        $score = ($score>=1 && $score<=5) ? $score : 3;
		$content = htmlspecialchars($content);

		if($_PHPCMS['comment_checkpass'])
		{
			$passed=0;
			$message="评论发表成功！请等待管理员审核！";
		}
		else
		{
			$passed=1;
			$message="评论发表成功！";
		}
		$db->query("INSERT INTO ".TABLE_COMMENT." (item,itemid,username,score,content,ip,addtime,passed) VALUES('$item','$itemid','$username','$score','$content','$PHP_IP','$timestamp','$passed')");
		message($message,$referer);
	break;

	default:
		$meta_title = "评论";
        $r = $db->get_one("SELECT count(*) AS totalnumber,AVG(score) AS avgscore FROM ".TABLE_COMMENT." WHERE item='$item' AND itemid='$itemid' ");
		@extract($r);
		$avgscore = stars($avgscore);
		$page = intval($page);
		$page = $page ? $page : 1;
		include template("comment","comment");
}
?>