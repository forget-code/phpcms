<?php 
require dirname(__FILE__).'/include/common.inc.php';
if(isset($gd) && $gd==1 && $auth)
{
	header ("Content-type: image/png");
	$auth = phpcms_auth($auth, 'DECODE', $PHPCMS['authkey']);
	$im = @imagecreate (strlen($auth)*9, 16) or die ("Cannot Initialize new GD image stream");
	$background_color = imagecolorallocate ($im, 255, 255, 255);// RGB Background Color
	$text_color = imagecolorallocate ($im, 0, 0, 0);// RGB Text Color
	imagestring ($im, 5, 0, 0,$auth, $text_color);
	imagepng ($im);
	imagedestroy ($im);
}
else
{
	if(!$auth) exit;
	if(function_exists("imagepng"))
	{
		$output='<img src="'.PHPCMS_PATH.'toimg.php?gd=1&auth='.$auth.'" align="absmiddle">';
	}
	else
	{
		$output = phpcms_auth($auth, 'DECODE', $PHPCMS['authkey']);;
	}
	echo "document.write('".$output."');";
}
?>