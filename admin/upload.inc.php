<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'attachment.class.php';

$attachment = new attachment($mod);

if($dosubmit)
{
	$attachment->upload('uploadfile', UPLOAD_ALLOWEXT, UPLOAD_MAXSIZE, 1);
	if($attachment->error) showmessage($attachment->error());
	$imgurl = UPLOAD_URL.$attachment->uploadedfiles[0]['filepath'];	
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
	showmessage("文件上传成功！<script language='javascript'>	try{ window.opener.myform.".$uploadtext.".value='".$imgurl."';window.opener.myform.".$uploadtext."_aid.value='".$aid."';window.opener.myform.filesize.value='".$filesize."';}catch(e){} window.close();</script>", HTTP_REFERER);
}
else
{
	include admin_tpl('upload');
}
?>