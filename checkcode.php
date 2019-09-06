<?php
require dirname(__FILE__).'/include/common.inc.php';

session_start();

$enablegd = 1;
$funcs = array('imagecreatetruecolor','imagecolorallocate','imagefill','imageline','imagedestroy','imagecolorallocatealpha','imageellipse','imagepng');
foreach($funcs as $func)
{
	if(!function_exists($func))
	{
		$enablegd = 0;
		break;
	}
}
if(!function_exists('ob_gzhandler')) ob_clean();

if($enablegd)
{
	//create captcha
	$consts = 'cdfgkmnpqrstwxyz23456';
	$vowels = 'aek23456789';
	for ($x = 0; $x < 6; $x++)
	{
		$const[$x] = substr($consts, mt_rand(0,strlen($consts)-1),1);
		$vow[$x] = substr($vowels, mt_rand(0,strlen($vowels)-1),1);
	}
	$radomstring = $const[0] . $vow[0] .$const[2] . $const[1] . $vow[1] . $const[3] . $vow[3] . $const[4];
	$_SESSION['checkcode'] = $string = substr($radomstring,0,4); //only display 4 str
	//set up image, the first number is the width and the second is the height
	$imageX = strlen($radomstring)*8;	//the image width
	$imageY = 20;						//the image height
	$im = imagecreatetruecolor($imageX,$imageY);

	//creates two variables to store color
	$background = imagecolorallocate($im, rand(180, 250), rand(180, 250), rand(180, 250));
	$foregroundArr = array(imagecolorallocate($im, rand(0, 20), rand(0, 20), rand(0, 20)),
						   imagecolorallocate($im, rand(0, 20), rand(0, 10), rand(245, 255)),
						   imagecolorallocate($im, rand(245, 255), rand(0, 20), rand(0, 10)),
						   imagecolorallocate($im, rand(245, 255), rand(0, 20), rand(245, 255)));
	$foreground2 = imagecolorallocatealpha($im, rand(20, 100), rand(20, 100), rand(20, 100),80);
	$middleground = imagecolorallocate($im, rand(200, 160), rand(200, 160), rand(200, 160));
	$middleground2 = imagecolorallocatealpha($im, rand(180, 140), rand(180, 140), rand(180, 140),80);

	//fill image with bgcolor
	imagefill($im, 0, 0, imagecolorallocate($im, 250, 253, 254));
	//writes string
	if(function_exists('imagettftext'))
	{
		imagettftext($im, 12, rand(30, -30), 5, rand(14, 16), $foregroundArr[rand(0,3)], PHPCMS_ROOT.'include/fonts/ALGER.TTF', $string[0]);
		imagettftext($im, 12, rand(50, -50), 20, rand(14, 16), $foregroundArr[rand(0,3)], PHPCMS_ROOT.'include/fonts/ARIALNI.TTF', $string[1]);
		imagettftext($im, 12, rand(50, -50), 35, rand(14, 16), $foregroundArr[rand(0,3)], PHPCMS_ROOT.'include/fonts/ALGER.TTF', $string[2]);
		imagettftext($im, 12, rand(30, -30), 50, rand(14, 16), $foregroundArr[rand(0,3)], PHPCMS_ROOT.'include/fonts/arial.ttf', $string[3]);
	}
	else
	{
		imagestring($im, 5, 3, floor(rand(0,5))-1, $string[0], $foregroundArr[rand(0,3)]);
		imagestring($im, 5, 16, floor(rand(0,5))-1, $string[1], $foregroundArr[rand(0,3)]);
		imagestring($im, 5, 23, floor(rand(0,5))-1, $string[2], $foregroundArr[rand(0,3)]);
		imagestring($im, 5, 33, floor(rand(0,5))-1, $string[3], $foregroundArr[rand(0,3)]);
	}
	//strikethrough

	$border = imagecolorallocate($im, 133, 153, 193);
	//imagefilledrectangle($aimg, 0, 0, $x_size - 1, $y_size - 1, $back);
	imagerectangle($im, 0, 0, $imageX - 1, $imageY - 1, $border);

	$pointcol = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));
	for ($i=0;$i<80;$i++)
	{
		imagesetpixel($im,rand(2,$imageX-2),rand(2,$imageX-2),$pointcol);
	}
	//random shapes
	for ($x=0; $x<9;$x++)
	{
		if(mt_rand(0,$x)%2==0)
		{
			imageline($im, rand(0, 120), rand(0, 120), rand(0, 120), rand(0, 120), rand(0, 999999));
			imageellipse($im, rand(0, 120), rand(0, 120), rand(0, 120), rand(0, 120), $middleground2);
		}
		else
		{
			imageline($im, rand(0, 120), rand(0, 120), rand(0, 120), rand(0, 120), rand(0, 999999));
			imageellipse($im, rand(0, 120), rand(0, 120), rand(0, 120), rand(0, 120), $middleground);
		}
	}
	//output to browser
    header("content-type:image/png\r\n");
	imagepng($im);
	imagedestroy($im);
}
else
{
	$files = glob(PHPCMS_ROOT.'images/checkcode/*.jpg');
	if(!is_array($files)) exit($LANG['please_check_dir_images_checkcode']);

	$checkcodefile = $files[rand(0, count($files)-1)];
	$_SESSION['checkcode'] = substr(basename($checkcodefile), 0, 4);

	header("content-type:image/jpeg\r\n");
	include $checkcodefile;
}
?>