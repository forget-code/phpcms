<?php
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'images/ext/ext.php';

$rootdir = UPLOAD_ROOT;
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
if($action == 'getdata')
{
	foreach($files as $k=>$v)
	{
			$ext = fileext($v);
			$lfile['ext'] = array_key_exists($ext,$filetype) ? $ext : "other";
			$lfile['type'] = $filetype[$lfile['ext']];
			$lfile['isimage'] = in_array($lfile['ext'],array('gif','jpg','jpeg','png','bmp')) ? 1 : 0;
			if($isimage && !$lfile['isimage']) continue;
			$listfiles_string .= str_replace(UPLOAD_ROOT, UPLOAD_URL, $v).'|';
	}
	echo substr($listfiles_string,0,-1);
}
else
{
	if(is_array($dirs))
	{
		foreach($dirs as $k=>$v)
		{
			$ldir['name'] = basename($v);
			$ldir['path'] = ($currentdir ? dir_path($currentdir) : '').$ldir['name'];
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
			$lfile['isimage'] = in_array($lfile['ext'],array('gif','jpg','jpeg','png','bmp')) ? 1 : 0;
			if($isimage && !$lfile['isimage']) continue;
			$lfile['path'] = str_replace(UPLOAD_ROOT, UPLOAD_URL, $v);
			$lfile['name'] = "<img src='images/ext/".$lfile['ext'].".gif' width='24' height='24' border='0'>".basename($v).(($lfile['isimage'] && $type=='thumb') ? "<br /><img src='".$lfile['path']."' width='50' border='0'>" : '');
			$lfile['preview'] = $lfile['isimage'] ? "<img src=".$lfile['path']." border=0>" : "&nbsp;此文件非图片或动画，无预览&nbsp;";
			$lfile['size'] = round(filesize($v)/1000);
			$imagesize = getimagesize($lfile['path']);
			$lfile['imagesize'] = $imagesize[0].'*'.$imagesize[1];
			$lfile['mtime'] = date("Y-m-d H:i:s",filemtime($v));
			$listfiles[] = $lfile;
		}
	}
	$backparentdir = dirname($parentdir) == '.' ? '' : dirname($parentdir);
	include admin_tpl('more_pic_select','phpcms');
}
?>