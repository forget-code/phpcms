<?php
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/images/ext/ext.php';
$realdir = isset($realdir) ? $realdir : '';
if(isset($channelid) && $channelid)
{
	$CHA = cache_read('channel_'.$channelid.'.php');
    $rootdir = $realdir ? $CHA['channeldir'].'/'.$realdir.'/' : $CHA['channeldir'].'/'.$CHA['uploaddir'].'/';
	$rootdir = $PHPCMS['uploaddir'].'/'.$rootdir;
}
elseif(isset($mod) && $mod)
{
	if($mod == 'phpcms')
	{
		$rootdir = $realdir ? $PHPCMS['uploaddir'].'/'.$realdir.'/' : $PHPCMS['uploaddir'].'/';
	}
	else
	{
		$MOD = cache_read($mod.'_setting.php');
		$rootdir = $realdir ? $mod.'/'.$realdir.'/' : $mod.'/'.$MOD['uploaddir'].'/';
	}
}

$type = isset($type) ? $type : 'thumb';
$currentdir = isset($currentdir) ? $currentdir : '';
$parentdir = isset($parentdir) ? $parentdir : '';
$thisdir = dir_path($rootdir.$currentdir);
if($currentdir && !preg_match("/^[0-9a-z_\/]+$/i",$currentdir)) showmessage("参数错误！");
if($parentdir && !preg_match("/^[0-9a-z_\/]+$/i",$parentdir)) showmessage("参数错误！");
if(!is_dir($thisdir)) showmessage("当前目录".$thisdir."不存在！");
$listdirs = array();
$listfiles = array();
$list = glob($thisdir."*");
$files = glob($thisdir."*.*");
if(!$list) $list = array();
if(!$files) $files = array();
$dirs = array_diff($list, $files);

if(is_array($dirs))
{
	foreach($dirs as $k=>$v)
	{
		$ldir['name'] = basename($v);
		$ldir['path'] = ($currentdir ? dir_path($currentdir) : "").$ldir['name'];
		$ldir['type'] = "文件夹";
		$ldir['size'] = "<目录>";
		$ldir['mtime'] = date("Y-m-d H:i:s",filemtime($v));
		$listdirs[] = $ldir;
	}
}

if(is_array($files))
{
	foreach($files as $k=>$v)
	{
		$ext = fileext($v);
		$lfile['ext'] = array_key_exists($ext,$filetype) ? $ext : "other";
		$lfile['type'] = $filetype[$lfile['ext']];
	    $lfile['name'] = $type=="thumb" ? "<img src='".$v."' width='50' border='0'><br/><img src='".PHPCMS_PATH."images/ext/".$lfile['ext'].".gif' width='24' height='24' border='0'>".basename($v) : basename($v);
		$lfile['preview'] = in_array($lfile['ext'],array('gif','jpg','jpeg','png','bmp')) ? "<img src=".$v." border=0>" : "&nbsp;此文件非图片或动画，无预览&nbsp;";
		$lfile['path'] = $v;
		$lfile['size'] = round(filesize($v)/1000);
		$lfile['mtime'] = date("Y-m-d H:i:s",filemtime($v));
		$listfiles[] = $lfile;
	}
}
$backparentdir = dirname($parentdir)=="." ? "" : dirname($parentdir);
include admintpl('file_select','phpcms');
?>