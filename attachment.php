<?php 
require dirname(__FILE__).'/include/common.inc.php';
require_once 'attachment.class.php';
require_once 'image.class.php';
if(!$_userid && !$PHPCMS['allowtourist'])
{
	if($from == 'fckeditor')
	{
		$message = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8".CHARSET."\"><script language='javascript'>";
		$message .= "window.parent.show_ok('1-".$id."','没有上传权限！');";
		$message .= "</script>";
		exit($message);
	}
	else
	{
		showmessage('不允许游客上传！');
	}
}
session_start();

switch($action)
{
    case 'upload':
		if($dosubmit)
	    {
			$attachment = new attachment($module);
			$aids = $attachment->upload('uploadfile', UPLOAD_ALLOWEXT, UPLOAD_MAXSIZE, 1);
			$filename = $attachment->uploadedfiles[0]['filename'];
			$filepath = $attachment->uploadedfiles[0]['filepath'];
			$fileurl = UPLOAD_FTP_ENABLE ? $filepath : UPLOAD_URL.$filepath;
			$extension = fileext($filename);
			
			if($from == 'fckeditor')
			{
				$fileurl = url($fileurl);
				if(empty($filepath))
				{
					$message = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8".CHARSET."\"><script language='javascript'>";
					$message .= "window.parent.show_ok('1-".$id."','".$attachment->error()."');";
					$message .= "</script>";
					echo $message;exit;
				}
				if($PHPCMS['watermark_enable'])
				{
					$imagefile = UPLOAD_ROOT.$filepath;
					$image = new image();
					$image->watermark($imagefile, $imagefile, $PHPCMS['watermark_pos'], $PHPCMS['watermark_img']);
				}
				if($PHPCMS['thumb_enable']  && in_array($extension,array('jpg','jpeg','gif','png','bmp')))
				{			
					$imagefile = UPLOAD_ROOT.$filepath;
					$image = new image();
					$filename = $image->thumb($imagefile, $imagefile, $PHPCMS['thumb_width'], $PHPCMS['thumb_height']);			
				}
				$filename = basename($filepath);
				if(isset($id)) 
				{
					$message = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8".CHARSET."\"><script language='javascript'>";
					$message .= "window.parent.show_ok('0-".$id."','".md5($fileurl.AUTH_KEY)." $MM_objid $fileurl');";
					$message .= "</script>";
				}
				else
				{
					$message = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8".CHARSET."\"><script language='javascript'>";
					$message .= "window.parent.SetUrl('$fileurl', '', '', '$filename');";
					$message .= "</script>";
				}
			}
			exit($message);
		}
		else
	    {
			include template('phpcms', 'attachment_upload');
		}
		break;

	case 'del_file':
		if(md5($filepath.AUTH_KEY)==$verfiy) 
		{
			if(preg_match("%".UPLOAD_URL."%i",$filepath)) 
			{
				$attachment = new attachment($module);
				$filepath = str_replace('/'.UPLOAD_URL,'',$filepath);
				if($attachment->delete("filepath = '$filepath'"))
				{
					echo('ok');
				}
			}
		}
	break;
}
?>