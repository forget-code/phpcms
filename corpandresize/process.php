<?php
include("config.inc.php");

//extract($_GET);

settype($x,'int');
settype($y,'int');
settype($w,'int');
settype($h,'int');
settype($iw,'int');
settype($ih,'int');
settype($pic,'string');

$pic = @trim($pic);
if(empty($pic)){
	printf("error:%s\n\n\n","1");
	//printf("错误提示：%s","请选择需要剪切的图片！");
	exit;
}
elseif(!preg_match(FILENAME_CHECK,$pic))
{
	printf("error:%s\n\n\n","2");
	//printf("错误提示：%s","请正确选择需要的图片！");
	exit;
}

$imagecontent = @file_get_contents($pic);

if(!$imagecontent){
	printf("error:%s\n\n\n","3");
	//printf("错误提示：%s","图片读取失败");
	exit;
}

if(strlen($imagecontent)<1024){
	printf("error:%s\n\n\n","4");
	//printf("错误提示：%s","图片文件太小，不能处理");
	exit;
}

$source = @imagecreatefromstring($imagecontent);
if($source!==false){
	$width = @imagesx($source);
	$height = @imagesx($source);
}
else
{
	printf("error:%s\n\n\n","5");
	//printf("错误提示：%s","图片格式不正确，无法处理");
	exit;
}

if(!$width || !$height || $width<10 || $height<10){
	printf("error:%s\n\n\n","6");
	//printf("错误提示：%s","图片尺寸太小，无法处理");
	exit;
}

$percent = $width/$iw;

$thumb = @imagecreatetruecolor($w, $h);
$thumbfile = $_COOKIE['thumbfile'];
if($thumbfile)
{
	$thumbarr = explode('_',$thumbfile);
	if($thumbarr[0]!=$_userid)
	{
		printf("error:%s\n\n\n","7");
		exit;
	}
	if(!preg_match('/([0-9]{1,8})_([0-9]{12})_([0-9a-z]{12}).jpg$/',$thumbfile))
	{
		printf("error:%s\n\n\n","7");
		exit;
	}
	@unlink(TMP_PATH.'/'.$thumbfile);
}
$thumbfile = sprintf("%s_%s.jpg",$_userid.'_'.date("ymsHis"),substr(md5($pic),8,12));
setcookie('thumbfile',$thumbfile);
if(!@imagecopyresized($thumb, $source, 0, 0, $x * $percent, $y * $percent, $w, $h, $w * $percent, $h * $percent))
{
	printf("error:%s\n\n\n","7");
	//printf("错误提示：%s","图片剪切失败");
	exit;
}
if(@imagejpeg($thumb,TMP_PATH.'/'.$thumbfile,100))
{
	@imagedestroy($thumb);
	printf("url:%s",TMP_URL.'/'.$thumbfile);
}
else
{
	printf("error:%s\n\n\n","8");
	//printf("错误提示：%s","图片写入失败");
	exit;
}
?>