<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
$imgext = array('jpg','jpeg','gif','png','bmp');
if($MOD['show_mode'] != 1 || !isset($src) || !in_array(strtolower(fileext($src)), $imgext)) exit;
$file = PHPCMS_ROOT.'/'.$PHPCMS['uploaddir'].'/'.$CHA['channeldir'].'/'.$MOD['upload_dir'].'/'.$src;
if(!file_exists($file)) exit;
if(empty($PHP_REFERER) || !strpos($PHP_REFERER, $PHP_DOMAIN)) $file = PHPCMS_ROOT.'/images/error.jpg';
header("Content-type:image/pjpeg");
readfile($file);
?>