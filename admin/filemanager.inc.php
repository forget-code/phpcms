<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!FILE_MANAGER)
{
    $message = "<font color=\"blue\">出于系统安全考虑，管理员关闭了此功能。<br />如需要打开，请修改配置文件 config.inc.php，把 <font color=\"red\">define('FILE_MANAGER', '0')</font> 修改为 <font color=\"red\">define('FILE_MANAGER', '1')</font>。</font>";
    include admin_tpl('message');
    exit;
}
include_once PHPCMS_ROOT.'images/ext/ext.php';
require 'admin/filemanager.func.php';
require 'upload.class.php';
@set_time_limit(0);

$submenu = array
(
	array($LANG['return_main_dir'], '?mod='.$mod.'&file='.$file.'&action=main'),
	array('PHPINFO()', '?mod='.$mod.'&file='.$file.'&action=phpinfo'),
);
$menu = admin_menu($LANG['online_filemanager'], $submenu);
if(!isset($forward)) $forward = '?mod=phpcms&file=database&action=main';
$action = $action ? $action : 'main';

$rootpath = PHPCMS_ROOT;

if(isset($newchangedir) && !empty($newchangedir))
{
	$newchangedir= str_replace("\\","/",$newchangedir);
	if($newchangedir[0] == '/'|| $newchangedir[0] == '.')
	{
		$dir = $newchangedir;
	}
	else if(strlen($newchangedir)<strlen($rootpath))
	{
		$newchangedir = './';
		echo "<font color=red>".$LANG['illegal_directory']."</font>";
	}
	if(strpos($newchangedir,$rootpath)!= -1)
	{
		$newchangedir = str_replace($rootpath,'./',$newchangedir);
	}
	$dir = $newchangedir;
}
if (!isset($dir) or empty($dir))
{
	$dir = "./";
	$currentdir = getRelativePath($rootpath, $dir);
}
else
{
	$currentdir = getRelativePath($rootpath, $dir);
}
if(strlen($currentdir) < strlen($rootpath))
{
	$currentdir = $rootpath;
	$dir = './';
}

switch($action)
{
	case 'main':
		$writeable = is_writeable($currentdir) ? $LANG['writeable'] : $LANG['cannot_write'];
		$dirhandle = @opendir($dir);
		$dirnum = '0';
		$dirs = array();
		while ($f = @readdir($dirhandle)) {
			$fpath = "$dir/$f";
			$a = @is_dir($fpath);
			$r = array();
			if($a=="1"){
				if($f!=".." && $f!=".")
					{
						if (filectime($fpath) < filemtime($fpath))
						{
							$createtime = date("Y-m-d H:i:s",filectime($fpath));
							$modifytime = "<font color=\"red\">".date("Y-m-d H:i:s",filemtime($fpath))."</font>";
						}
						else
						{
							$createtime = date("Y-m-d H:i:s",@filectime($fpath));
							$modifytime = date("Y-m-d H:i:s",@filemtime($fpath));
						}

						$dirperm = substr(base_convert(fileperms($fpath),10,8),-4);

						$r['createtime'] = $createtime;
						$r['modifytime'] = $modifytime;
						$r['dirperm'] = $dirperm;
						$r['size'] = '<??>';
						$r['name'] = $f;
						$r['dir'] = $dir;
						$dirs[] = $r;
						$dirnum++;
					}
					else {
					if($f=="..") {
					}
				}
			}
		}
		@closedir($dirhandle);

		$dirhandle = @opendir($dir);
		$fnum = 0;
		$files = array();
		$basedir = str_replace($rootpath,'',$currentdir).'/';
		if($basedir['0'] == '/' && strlen($basedir) >1)
		{
			$basedir = substr($basedir,1);
		}
		else if($basedir== '/')
		{
			$basedir = '';
		}
		while ($f = @readdir($dirhandle)) {
			$fpath= "$dir/$f";
			$a = @is_dir($fpath);
			$r = array();
			if($a=="0"){
				$size = filesize($fpath);
				$size = $size/1024 ;
				$size = number_format($size, 3);
				if (filectime($fpath) < filemtime($fpath)) {
					$createtime = date("Y-m-d H:i:s",filectime($fpath));
					$modifytime = "<font color=\"red\">".date("Y-m-d H:i:s",filemtime($fpath))."</font>";

				} else {
					$createtime = date("Y-m-d H:i:s",@filectime($fpath));
					$modifytime = date("Y-m-d H:i:s",@filemtime($fpath));
				}
				$fileperm = substr(base_convert(fileperms($fpath),10,8),-4);

				$r['createtime'] = $createtime;
				$r['modifytime'] = $modifytime;
				$r['fileperm'] = $fileperm;
				$r['size'] = $size;
				$r['name'] = $f;
				$r['dir'] = $dir;


				$r['filepath'] = $basedir.$f;
				$r['fileext'] = fileext($fpath);
				if(!key_exists($r['fileext'],$filetype)) $r['fileext'] = 'other';
				$r['preview'] = in_array($r['fileext'],array('gif','jpg','jpeg','png','bmp')) ? "<img src=".$r['filepath']." border=0>" : "&nbsp;".$LANG['not_picture_flash']."&nbsp;";
				$files[] = $r;
				$fnum++;
			}
		}
		@closedir($dirhandle);

		include admin_tpl('filemanager_main');
	break;


	case 'chmod':
		if ($dosubmit)
		{
			if($chmodstr)
			{
			$fileperm = base_convert($chmodstr,8,10);
			(@chmod($fname,$fileperm)) ? showmessage($LANG['chmod_change_success'],"?mod=$mod&file=$file&action=main&dir=".urlencode($dir)) : showmessage($LANG['chmod_change_fail'],"?mod=$mod&file=$file&action=main&dir=".urlencode($dir));
			}
			else
			{
				showmessage($LANG['input_your_chmod'],"goback");
			}
		}
		$currentperm = substr(base_convert(@fileperms($fname),10,8),-4);
		include admin_tpl('filemanager_chmod');
	break;

	case 'newdir':
		if (!isset($newdir) || empty($newdir)) showmessage($LANG['input_new_file']);
		$mkdir = "$currentdir/$newdir";
		if (file_exists($mkdir))
		{
			showmessage($LANG['directory_existed_change_name'],"?mod=$mod&file=$file&action=main&dir=".urlencode($dir));
		}
		else
		{
			if(mkdir($mkdir,0777))
			{
				@chmod($mkdir,0777);
				showmessage($LANG['dir_create_success'],"?mod=$mod&file=$file&action=main&dir=".urlencode($dir));
			}
			else showmessage($LANG['dir_create_fail'],"?mod=$mod&file=$file&action=main&dir=".urlencode($dir));
		}
	break;

	case 'zipdir':
		if(!isset($fname)) showmessage($LANG['illegal_request_return'],'goback');
		if(!file_exists($fname)) showmessage($LANG['file_not_exist'],'goback');
		else
		{
			if($isdir == '1')
			{
				$zipname = $currentdir.'/'.basename($fname).'.tgz';
				$fname = str_replace($rootpath,'.',$fname);
				dir_zip($fname,$zipname);
				showmessage(basename($fname)." directory zipped successfully","?mod=$mod&file=$file&action=main");
			}
		}
		break;
	break;


	case 'newfile':
		if (!isset($newfile)) showmessage($LANG['input_new_file']);
		$mkfile = "$currentdir/$newfile";
		if (file_exists($mkfile))
		{
			showmessage($LANG['directory_existed_change_name'],"?mod=$mod&file=$file&action=main&dir=".urlencode($dir));
		}
		else
		{
			if(file_put_contents($mkfile,' '))
			{
				@chmod($mkfile,0777);
				showmessage($newfile.$LANG['file_create_success_continue_edit'],"?mod=$mod&file=$file&action=edit&fname=$mkfile&dir=".urlencode($dir));
			}
			else showmessage($newfile.$LANG['file_create_fail'],"?mod=$mod&file=$file&action=main&dir=".urlencode($dir));
		}
	break;

	case 'rename':
		if($dosubmit)
		{
			if ($newname)
			{
				if($isdir == '0')
				{
					$newpath = dirname($fname)."/".$newname;
					if (file_exists($newpath))
					{
						showmessage($newpath.$LANG['exist_refill']);
					}
					else
					{
						rename($fname,$newpath) ? showmessage(basename($fname).$LANG['success_change_name'].$newname." !","?mod=$mod&file=$file&action=main&dir=".urlencode($dir)) : showmessage($LANG['file_change_name_fail'],"?mod=$mod&file=$file&action=main&dir=".urlencode($dir));
					}
				}
				else if($isdir == '1')
				{
					$fname = trim($fname);
					$newpath = ($fname[strlen($fname)-1] == '/' || $fname[strlen($fname)-1] == "\\") ? substr($fname,0,-1) : $fname;
					$newpath = substr($newpath,0,strrpos($newpath, '/')+1);

					$newpath = $newpath.$newname;

					if (file_exists($newpath))
					{
						showmessage($newpath.$LANG['exist_refill']);
					}
					else
					{
						rename($fname,$newpath) ? showmessage(basename($fname).$LANG['success_change_name'].$newname." !","?mod=$mod&file=$file&action=main&dir=".urlencode($dir)) : showmessage($LANG['dir_change_name_fail'],"?mod=$mod&file=$file&action=main&dir=".urlencode($dir));
					}
				}
			}
			else
			{
				showmessage($LANG['please_input_new_directory_file_name']);
			}
		}
		include admin_tpl('filemanager_rename');
	break;


	case 'edit':
		if(!is_writeable($fname)) showmessage($LANG['file'].' '.$fname.' '.$LANG['cannot_write_edit_online']);
		if($dosubmit)
		{
			if($content) $content = str_replace(array('\n', '\r'), array(chr(10), chr(13)), $content);
			file_put_contents($fname, stripslashes($content));
	        showmessage($LANG['operation_success'], "?mod=$mod&file=$file&action=main&dir=".urlencode($dir));
		}
		else
	    {
			$content = file_get_contents($fname);
			$filemtime = date("Y-m-d H:i:s",filemtime($fname));
			include admin_tpl('filemanager_edit');
		}

	break;

	case 'uploadfile':
		if($dosubmit)
		{
			$upfile_size = '4000000';
			$savepath = str_replace(str_replace("\\","/",PHPCMS_ROOT),'',$currentdir)."/";
			$fileArr = array(
					'file'=>$_FILES['uploadfile']['tmp_name'],
					'name'=>$_FILES['uploadfile']['name'],
					'size'=>$_FILES['uploadfile']['size'],
					'type'=>$_FILES['uploadfile']['type'],
					'error'=>$_FILES['uploadfile']['error']
			);
			if(file_exists(PHPCMS_ROOT.'/'.$savepath.$fileArr['name']) && !isset($overfile)) showmessage($LANG['find_same_file']);
			$savepath = str_replace(str_replace("\\", "/", PHPCMS_ROOT), "", $currentdir)."/";
			$newname = $newname ? $newname : $_FILES['uploadfile']['name'] ;
			$upload = new upload('uploadfile', $savepath, $newname, UPLOAD_ALLOWEXT, $upfile_size, $overfile);
			if($upload->up())
				showmessage($LANG['file']." <a href=\"".$savepath.$upload->savename."\" >{$upload->savename}</a> ".$LANG['upload_success'],"?mod=$mod&file=$file&action=main&dir=".urlencode($dir));
			else
				showmessage($LANG['cannot_upload_error'].$upload->error());
		}
	break;

	case 'multiupload':
		if($dosubmit)
		{
			$upfile_size='4000000';
			$savepath = str_replace(str_replace("\\","/",PHPCMS_ROOT),'',$currentdir)."/";
			$filecount = count($_FILES['uploadfiles']['tmp_name']);
			for($i=0; $i<$filecount; $i++)
			{
				$source = $_FILES['uploadfiles']['tmp_name'][$i];
				if($source)
				{
					$fileArr = array(
									'file'=>$_FILES['uploadfiles']['tmp_name'][$i],
									'name'=>$_FILES['uploadfiles']['name'][$i],
									'size'=>$_FILES['uploadfiles']['size'][$i],
									'type'=>$_FILES['uploadfiles']['type'][$i],
									'error'=>$_FILES['uploadfiles']['error'][$i]
									);

					if(file_exists(PHPCMS_ROOT.'/'.$savepath.$fileArr['name']) && !isset($overfile)) continue;
				}
			}
			$upload = new upload('uploadfiles', $savepath, $newname, UPLOAD_ALLOWEXT, $upfile_size, $overfile);
			$upload->up();
			showmessage($LANG['all_file_uploaded'],"?mod=$mod&file=$file&action=main&dir=".urlencode($dir));
		}
		include admin_tpl('filemanager_multiupload');
		break;

	case 'down':
		file_down($fname);
		break;

	case 'delete':
		if(!isset($fname)) showmessage($LANG['illegal_request_return'],'goback');
		if(!file_exists($fname)) showmessage($LANG['file_not_exist'],'goback');
		else
		{
			if($isdir == '0')
			{
				@unlink($fname);
				showmessage(basename($fname).$LANG['file_delete_success'],"?mod=$mod&file=$file&action=main&dir=".urlencode($dir));
			}
			else if($isdir == '1')
			{
				dir_delete($fname);
				showmessage(basename($fname).$LANG['dir_delete_success'],"?mod=$mod&file=$file&action=main");
			}
		}
		break;
	break;

	case 'phpinfo':
		ob_start();
		phpinfo();
		$info = ob_get_contents();
		ob_clean();
		if(preg_match("/<body><div class=\"center\">([\s\S]*?)<\/div><\/body>/",$info,$m))
			 $phpinfo = $m[1];
		else $phpinfo = $info;
		$phpinfo = str_replace("class=\"e\"","",$phpinfo);
		$phpinfo = str_replace("class=\"v\"","",$phpinfo);
		$phpinfo = str_replace("<table","<table class=\"table_list\"",$phpinfo);

		$phpinfo = preg_replace("/<a href=\"http:\/\/www.php.net\/\"><img(.*)alt=\"PHP Logo\" \/><\/a><h1 class=\"p\">(.*)<\/h1>/","<h1 style=\"text-align:center;font-family:Arial;color=red;\">\\2<h3>&nbsp;&nbsp;provide impetus for phpcms!</h3></h1>",$phpinfo);

		include admin_tpl('filemanager_phpinfo');
	break;
}
?>
