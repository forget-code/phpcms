<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'attachment.class.php';

$attachment = new attachment($mod);
if($catid)
{
	$C = cache_read('category_'.$catid.'.php');
}
$upload_allowext = $C['upload_allowext'] ? $C['upload_allowext'] : UPLOAD_ALLOWEXT;
$upload_maxsize = $C['upload_maxsize'] ? $C['upload_maxsize'] : UPLOAD_MAXSIZE;
if($dosubmit)
{
	$attachment->upload('uploadfile', $upload_allowext, $upload_maxsize, 1);
	if($attachment->error) showmessage($attachment->error());
	//判断是否开启附件ftp上传，返回图片路径
	$imgurl = UPLOAD_FTP_ENABLE ? $attachment->uploadedfiles[0]['filepath'] : UPLOAD_URL.$attachment->uploadedfiles[0]['filepath'];	
	$aid = $attachment->uploadedfiles[0]['aid'];
	$filesize = $attachment->uploadedfiles[0]['filesize'];
	$filesize = $attachment->size($filesize);
    if($isthumb || $iswatermark)
	{
		require_once 'image.class.php';
		$image = new image();
		$img = UPLOAD_ROOT.$attachment->uploadedfiles[0]['filepath'];
		if($isthumb)
		{
			$image->thumb($img, $img, $width, $height);
		}
		if($iswatermark)
		{
			$image->watermark($img, $img, $PHPCMS['watermark_pos'], $PHPCMS['watermark_img'], '', 5, '#ff0000', $PHPCMS['watermark_jpgquality']);
		}
	}

	showmessage("文件上传成功！<script language='javascript'>	try{ $(window.opener.document).find(\"form[@name='myform'] #$uploadtext\").val(\"$imgurl\");$(window.opener.document).find(\"form[@name='myform'] #{$uploadtext}_aid\").val(\"$aid\");$(window.opener.document).find(\"form[@name='myform'] #$filesize\").val(\"$filesize\");}catch(e){} window.close();</script>", HTTP_REFERER);
}
else
{
	include admin_tpl('upload');
}
?>