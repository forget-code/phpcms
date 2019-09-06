<?php
require dirname(__FILE__).'/include/common.inc.php';
if(!$_userid || !$modelid || !$fieldid) exit;
$modelid = intval($modelid);
$fieldid = intval($fieldid);
if($catid)
{
	$C = cache_read('category_'.$catid.'.php');
}
require_once 'attachment.class.php';
require_once 'admin/model_field.class.php';
$field = new model_field($modelid);
$info = $field->get($fieldid);
if(!$info) showmessage('指定的字段不存在！');
$upload_allowext = !empty($C['upload_allowext']) ? $C['upload_allowext'] : $info['upload_allowext'];
$upload_maxsize = !empty($C['upload_maxsize']) ? $C['upload_maxsize'] : $info['upload_maxsize']*1024;
$isthumb = isset($C['thumb_enable']) ? $C['thumb_enable'] : ($PHPCMS['thumb_enable'] && $info['isthumb'] ? 1 : 0);
$iswatermark = isset($C['watermark_enable']) ? $C['watermark_enable'] : ($PHPCMS['watermark_enable'] && $info['iswatermark'] ? 1 : 0);
$thumb_width = isset($width) ? $width : (isset($C['thumb_width']) ? $C['thumb_width'] : ($info['thumb_width'] ? $info['thumb_width'] : $PHPCMS['thumb_width']));
$thumb_height = isset($height) ? $height : (isset($C['thumb_height']) ? $C['thumb_height'] : ($info['thumb_height'] ? $info['thumb_height'] : $PHPCMS['thumb_height']));
$watermark_img = PHPCMS_ROOT.($info['watermark_img'] ? $info['watermark_img'] : $PHPCMS['watermark_img']);

$attachment = new attachment($mod);

if($dosubmit)
{
	$attachment->upload($uploadtext, $upload_allowext, $upload_maxsize, 1);
	if($attachment->error) showmessage($attachment->error());
	$imgurl = UPLOAD_URL.$attachment->uploadedfiles[0]['filepath'];
	$aid = $attachment->uploadedfiles[0]['aid'];
	if($isthumb || $iswatermark)
	{
		require_once 'image.class.php';
		$image = new image();
		$img = UPLOAD_ROOT.$attachment->uploadedfiles[0]['filepath'];
		if($isthumb) $image->thumb($img, $img, $width, $height);
		if($iswatermark) $image->watermark($img, '', $PHPCMS['watermark_pos'], $watermark_img, '', 5, '#ff0000', $PHPCMS['watermark_jpgquality']);
	}
	showmessage("文件上传成功！<script language='javascript'>$(window.opener.document).find(\"form[@name='myform'] #$uploadtext\").val(\"$imgurl\");$(window.opener.document).find(\"form[@name='myform'] #{$uploadtext}_aid\").val(\"$aid\");</script>", HTTP_REFERER);
}
else
{
	$upload_maxsize = $attachment->size($upload_maxsize);
	include template('phpcms','upload_field');
}
?>