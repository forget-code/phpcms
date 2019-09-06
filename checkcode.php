<?php
/*
*######################################
* PHPCMS v3.00 - Advanced Content Manage System.
* Copyright (c) 2004-2005 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*######################################
*/
include "common.php";

if($in_admin) $usecookie = $admin_usecookie;

header ("Content-type: image/png");
$randomstr = random(4);
mkcookie("randomstr",$randomstr);
$im = @imagecreate(40, 20) or die ("Cannot Initialize new GD image stream");
$background_color = imagecolorallocate ($im, 230, 230, 255);
$text_color = imagecolorallocate ($im, 0, 0, 200);
imagestring($im,5,3,3,$randomstr,$text_color);
imagepng($im);
imagedestroy($im);
?>