<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'attachment.class.php';
session_start();
$attachment = new attachment($mod);
$_SESSION['downfiles'] = 1;
if($dosubmit)
{
	if(!$attachment->upload('uploadfile', UPLOAD_ALLOWEXT, UPLOAD_MAXSIZE, 1))
	{
		msg($attachment->error(), '', 6000);
		exit;
	}
	$atts = $attachment->uploadedfiles;
	$filesize = $attachment->uploadedfiles[0]['filesize'];
	$filesize = $attachment->size($filesize);
	foreach($atts AS $k=>$v)
	{
		$name = $file_description[$k+1];
		if($name=='')
		{
			$name = basename($v['filename'],'.'.$v['fileext']);
		}
		echo '<script>var s = parent.document.getElementById("downurls").value == "" ? "" : "\n";parent.document.getElementById("downurls").value += s+"'.$name.'|'.UPLOAD_URL.$v['filepath'].'";parent.document.getElementById("filesize").value="'.$v['filesize'].'";</script>';
	}
	echo '<script>parent.document.getElementById("filesize").value="'.$filesize.'";</script>';
	msg('上传成功', '', 3000);
}
else
{
	include admin_tpl('downfiles');
}

function msg($msg, $forward = '', $timeout = 2000)
{
	if(!$forward)
	{
		global $forward; 
	}
	echo '<table width="100%" cellpadding="0" cellspacing="0"  height="100%" bgcolor="#F1F3F5">';
	echo '<tr><td style="font-size:12px;color:blue;">';
	echo '<a href="'.$forward.'">'.$msg.' Click To Back</a>';
	echo '</td></tr></table>';
	echo '<script>setTimeout("window.location=\''.$forward.'\'", '.$timeout.');</script>';
	exit;
}
?>