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
function get_type($type) {
  if ($type=="image") return "图片";
  if ($type=="flash") return "FLASH";
  if ($type=="text") return "文字";
  if ($type=="code") return "代码";
  return "未知";
}

function ads_content($ads) 
{
	if (!is_array($ads)) return "";
	@extract($ads);
	switch ($type)
	{
		case 'image':
		$imageurl = get_imgurl($imageurl);
		$content = ads_image($adsid, $linkurl, $imageurl, $width, $height, $alt);
		break;

		case 'flash':
		$flashurl = get_imgurl($flashurl);
		$content = ads_flash($adsid, $flashurl, $width, $height, $wmode = 'transparent');
		break;

		case 'text':
		$content = ads_text($adsid, $text);
		break;

		case 'code':
		$content = ads_code($adsid, $code);
		break;
	}
	return strip_js($content);
}

function ads_image($id, $linkurl, $imageurl, $width, $height, $alt = '') 
{
	global $PHP_DOMAIN;
	return "<a href='http://".$PHP_DOMAIN.PHPCMS_PATH."ads/clickads.php?id=".$id."&url=".$linkurl."' target='_blank'><img src='".$imageurl."' border='0' width='".$width."' height='".$height."' alt='".$alt."'></a>";
}
function ads_flash($id, $flashurl, $width, $height, $wmode = 'transparent') 
{
	return "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0' width='".$width."' height='".$height."'>
	<param name='movie' value='".$flashurl."' /><param name='quality' value='high' />
	".($wmode ? "<param name='wmode' value='transparent' />" : "") ."
	<embed src='".$flashurl."' width='".$width."' height='".$height."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'>
	</embed>
	</object>";
}
function ads_text($id, $text) 
{
	return $text;
}
function ads_code($id, $code) 
{
	return $code;
}
?>