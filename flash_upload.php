<?php
require dirname(__FILE__).'/include/common.inc.php';
if($PHPSESSID) 
{
	session_id($PHPSESSID);
	session_start();
}
if($auth) set_cookie('auth', $auth);
if(!get_cookie('cookietime') && $cookietime) set_cookie('cookietime', $cookietime);
require_once 'admin/model_field.class.php';
$field = new model_field($modelid);
$info = $field->get($fieldid);
if(!$info) showmessage('指定的字段不存在！');
$upload_allowext = $info['upload_allowext'];
$upload_maxsize = $info['upload_maxsize']*1024;

require_once 'attachment.class.php';
$attachment = new attachment();

if($dosubmit)
{
	$aid = $attachment->upload('Filedata', $upload_allowext, $upload_maxsize);
	if($aid)
	{
		$filename = $attachment->uploadedfiles[0]['filename'];
		$fileurl = UPLOAD_URL.$attachment->uploadedfiles[0]['filepath'];
		exit($filename.'|'.$fileurl);
	}
	else
	{
		if (isset($_FILES["Filedata"])) {
			echo $_FILES["Filedata"]["error"];
			exit;
		}
	}	
}
else 
{
	include template('phpcms','flash_upload');
}
?>