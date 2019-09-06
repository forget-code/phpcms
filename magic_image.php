<?php 
require dirname(__FILE__).'/include/common.inc.php';
if(isset($gd) && $gd==1 && $txt)
{
	header ("Content-type: image/png");
	$txt = urldecode(phpcms_auth($txt, 'DECODE', AUTH_KEY));
	$imageX = strlen($txt)*9;
	$im = @imagecreate ($imageX, 16) or die ("Cannot Initialize new GD image stream");
	$bgColor = ImageColorAllocate($im,255,255,255);
	$white=imagecolorallocate($im,234,185,95);
	$font_color=imagecolorallocate($im,0x00,0x00,0x00);
	
	$fontfile = PHPCMS_ROOT."include/fonts/simfang.ttf";
	if(file_exists($fontfile) && !preg_match('/([a-z0-9\@\.])/',$txt))
	{
		$txt = iconv("GB2312","UTF-8",$txt);
		ImageTTFText($im, 10, 0, 0, 12, $font_color, $fontfile, $txt);
	}
	else
	{
		$fonttype = intval($fonttype);
		imagestring ($im, $fonttype, 0, 0,$txt, $font_color);
	}
	imagepng ($im);
	imagedestroy ($im);
}
?>