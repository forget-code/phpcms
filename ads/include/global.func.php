<?php
defined('IN_PHPCMS') or exit('Access Denied');

function get_type($type) {
  global $LANG; 
  if($type=='image') return $LANG['image'];
  elseif($type=='flash') return 'FLASH';
  elseif($type=='text') return $LANG['text'];
  elseif($type=='code') return $LANG['code'];
  else return $LANG['unkown'];
}

function ads_content($ads, $isjs = 1) 
{
	if (!is_array($ads)) return "";
	@extract($ads);
	switch ($type)
	{
		case 'image':
		$imageurl = imgurl($imageurl, 1);
		$content = ads_image($adsid, $linkurl, $imageurl, $width, $height, $alt);
		break;

		case 'flash':
		$flashurl = imgurl($flashurl, 1);
		$content = ads_flash($adsid, $flashurl, $width, $height, $wmode = 'transparent');
		break;

		case 'text':
		$content = ads_text($adsid, $text);
		break;

		case 'code':
		$content = ads_code($adsid, $code);
		break;
	}
	return $isjs ? strip_js($content) : $content;
}

function ads_image($id, $linkurl, $imageurl, $width, $height, $alt = '') 
{
	global $PHP_SITEURL,$MOD;
	$url = $MOD['enableadsclick'] ? $PHP_SITEURL.'ads/clickads.php?id='.$id : $linkurl;
	return "<a href='".$url."' target='_blank'><img src='".$imageurl."' border='0' width='".$width."' height='".$height."' alt='".$alt."'></a>";
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