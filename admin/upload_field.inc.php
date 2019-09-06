<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'attachment.class.php';
require_once 'admin/model_field.class.php';
$field = new model_field($modelid);
$info = $field->get($fieldid);
if(!$info) showmessage('指定的字段不存在！');
$upload_allowext = $info['upload_allowext'];
$upload_maxsize = $info['upload_maxsize']*1024;
$isthumb = $PHPCMS['thumb_enable'] && $info['isthumb'] ? 1 : 0;
$iswatermark = $PHPCMS['watermark_enable'] && $info['iswatermark'] ? 1 : 0;
$thumb_width = $info['thumb_width'] ? $info['thumb_width'] : $PHPCMS['thumb_width'];
$thumb_height = $info['thumb_height'] ? $info['thumb_height'] : $PHPCMS['thumb_height'];
$watermark_img = PHPCMS_ROOT.($info['watermark_img'] ? $info['watermark_img'] : $PHPCMS['watermark_img']);

$attachment = new attachment($mod);

if($dosubmit)
{
	$attachment->upload($uploadtext, $upload_allowext, $upload_maxsize, 1);
	if($attachment->error) showmessage($attachment->error());
	$imgurl = UPLOAD_URL.$attachment->uploadedfiles[0]['filepath'];
	$aid = $attachment->uploadedfiles[0]['aid'];
	if($isthumb)
	{
		require_once 'image.class.php';
		$image = new image();
		$img = UPLOAD_ROOT.$attachment->uploadedfiles[0]['filepath'];
		$image->thumb($img, $img, $thumb_width, $thumb_height);
	}
	if($iswatermark)
	{
		if(!$isthumb)
		{
			require_once 'image.class.php';
			$image = new image();
			$img = UPLOAD_ROOT.$attachment->uploadedfiles[0]['filepath'];
		}
		$image->watermark($img, '', $PHPCMS['watermark_pos'], $watermark_img, '', 5, '#ff0000', $PHPCMS['watermark_jpgquality']);
	}
	showmessage("文件上传成功！<script language='javascript'>window.opener.myform.".$uploadtext.".value='".$imgurl."';window.opener.myform.".$uploadtext."_aid.value='".$aid."';</script>", HTTP_REFERER);
}
else
{
	include admin_tpl('upload_field');
}
?>