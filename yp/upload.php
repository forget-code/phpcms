<?php
require './include/common.inc.php';
if(!$_userid) showmessage('您还没有登陆，请登陆',$MODULE['member']['url'].'login.php');

if($dosubmit)
{
	require_once 'attachment.class.php';
	$attachment = new attachment($mod);
	$aids = $attachment->upload($uploadtext, 'jpg|jpeg|gif|bmp|png', UPLOAD_MAXSIZE, 1);
	if($attachment->error) showmessage($attachment->error());
	$filepath = $attachment->uploadedfiles[0]['filepath'];
	$fileurl = UPLOAD_URL.$filepath;
	showmessage("文件上传成功！<script language='javascript'>$(window.opener.document).find(\"form[@name='myform'] #$uploadtext\").val(\"$fileurl\");window.close();</script>");
}
else
{
	include template($mod, 'upload');
}
?>