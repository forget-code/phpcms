<?php
require './include/common.inc.php';

$keyid = isset($keyid) ? $keyid : 'phpcms';
if(is_numeric($keyid))
{
	$channelid = $keyid;
	$CHA = cache_read('channel_'.$channelid.'.php');
}
if($dosubmit)
{
	if(!$MOD['enableTourist'] && !$_username)
	{
		showmessage($LANG['dis_guest'],'goback');
	}
	if($MOD['enablecheckcode'])	
	{
		checkcode($checkcodestr,1,$forward);
	}
	if($gender!=0 && $gender!=1)
	{
		showmessage($LANG['illegal_parameters'],'goback'); 
	}
	if(strlen($username)>20 || strlen($email)>50 || strlen($homepage)>255)
	{
		showmessage($LANG['illegal_parameters'],'goback');
	}
	if(strlen($content)>$MOD['maxcontent'])
	{
		showmessage($LANG['message_more'].$MOD['maxcontent'].$LANG['message_characters'],'goback'); 
	}
	if(empty($username))
	{
		showmessage($LANG['message_input_username'],'goback');
	}
	if(empty($title))
	{
		showmessage($LANG['message_input_subject'],'goback');
	}
	if(empty($content))
	{
		showmessage($LANG['message_input_content']);
	}
	if($hidden!=0 && $hidden!=1)
	{
		showmessage($LANG['illegal_parameters'],'goback'); 
	}

	$username = $_username ? $_username : strip_tags($username);
	$inputstring=array('title'=>$title,'username'=>$username,'gender'=>$gender,'head'=>$headimg,'email'=>$email,'homepage'=>$homepage,'hidden'=>$hidden);
	extract($inputstring,EXTR_OVERWRITE);
	$title = strip_tags($title);
	$content = $MOD['usehtml'] ? str_safe($content) : htmlspecialchars($content);
	if($MOD['checkpass'])
	{
		$passed = 0;
		$showmessage = $LANG['message_publishes_waite'];
	}
	else
	{
		$passed = 1;
		$showmessage = $LANG['message_publishes_successfully'];
	}

	$query = "INSERT INTO ".TABLE_GUESTBOOK."(keyid,title,content,username,gender,head,email,qq,homepage,hidden,addtime,passed,ip) VALUES('$keyid','$title','$content','$username','$gender','$head','$email','$qq','$homepage','$hidden','$PHP_TIME','$passed','$PHP_IP')";
	$db->query($query);
	if($db->affected_rows()>0)
	{
		showmessage($showmessage, $MOD['linkurl'].'index.php?keyid='.$keyid);
	}
	else
	{
		showmessage($LANG['message_publishes_flase'], 'goback');
	}
}
else
{
	$head['title'] = $LANG['message_head_title'];
	$head['keywords'] = $LANG['message_head_keywords'];
	$head['description'] = $LANG['message_head_description'];
	$srchtype = isset($srchtype) ? $srchtype : 0;
	$keyword = isset($keyword) ? $keyword : '';
	$position = $MOD['name'];
	include template('guestbook', 'post'); 
}
?>