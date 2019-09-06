<?php
require './include/common.inc.php';
require_once './include/guestbook.class.php';
$g = new guestbook;
if($dosubmit)
{
	if(!$M['enableTourist'] && !$_username)
	{
		showmessage($LANG['dis_guest'],'goback');
	}
	if($M['enablecheckcode'])	
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
	if(strlen($guestbook['content'])>$M['maxcontent'])
	{
		showmessage($LANG['message_more'].$M['maxcontent'].$LANG['message_characters'],'goback'); 
	}
	if(empty($guestbook[username]))
	{
		showmessage($LANG['message_input_username'],'goback');
	}
	if(empty($guestbook[title]))
	{
		showmessage($LANG['message_input_subject'],'goback');
	}
	if(empty($guestbook[content]))
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
	//$content = $M['usehtml'] ? str_safe($content) : htmlspecialchars($content);
	if($M['checkpass'])
	{
		$passed = 0;
		$showmessage = $LANG['message_publishes_waite'];
	}
	else
	{
		$passed = 1;
		$showmessage = $LANG['message_publishes_successfully'];
	}
	$guestbook['passed'] = $passed;
	$guestbook['ip'] = IP;
	$guestbook['userid'] =$_userid;
	$guestbook['addtime'] = TIME;
	if($g->add($guestbook)) showmessage($showmessage,"$mod/index.php");
}
else
{
	require 'form.class.php';
	$srchtype = isset($srchtype) ? $srchtype : 0;
	$keyword = isset($keyword) ? $keyword : '';
	$position = $M['name'];
	include template('guestbook', 'post'); 
}
?>