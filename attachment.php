<?php 
require dirname(__FILE__).'/include/common.inc.php';
require_once 'attachment.class.php';
require_once 'image.class.php';

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
			$fileurl = UPLOAD_URL.$filepath;
			
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
				if($PHPCMS['thumb_enable'])
				{			
					$imagefile = UPLOAD_ROOT.$filepath;
					$image = new image();
					$filename = $image->thumb($imagefile, $imagefile, $PHPCMS['thumb_width'], $PHPCMS['thumb_height']);			
				}
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
					$message .= "window.parent.GetE('frmUpload').reset() ;";
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