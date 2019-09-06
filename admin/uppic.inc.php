<?php
defined('IN_PHPCMS') or exit('Access Denied');

$exts = array('php','php3','asp','aspx','cgi','jsp','pl','cfg');

$type = isset($type) ? $type : '';
$rename = isset($rename) ? trim($rename) : '';

if($dosubmit)
{
	if($type == 'overwrite')
	{
		if(!is_writable(PHPCMS_ROOT.'/'.$oldname)) showmessage($LANG['please_chmod']." $oldname ".$LANG['to_777_then_upload']);
		$rename = basename($oldname);
		$uploaddir = dirname($oldname);
	}
	elseif(isset($CHA['uploaddir']))
	{
		@extract($CHA);
		$uploaddir = $PHPCMS['uploaddir'].'/'.$channeldir.'/'.$uploaddir;
	}
	elseif(isset($MOD['uploaddir']))
	{
		@extract($MOD);
		$uploaddir = $uploaddir ? $PHPCMS['uploaddir'].'/'.$moduledir.'/'.$uploaddir : $PHPCMS['uploaddir'].'/'.$moduledir;
	}
	else 
	{
		@extract($PHPCMS);
	}

	if($rename)
	{
		$ext = fileext($rename);
		if(in_array($ext, $exts)) showmessage($LANG['illegal_extension']);
	}

	$uploaddir = $rename=='' ?  $uploaddir.'/'.date('Ym').'/' : $uploaddir.'/';
	$maxfilesize = isset($maxfilesize) ? $maxfilesize : 2048000 ;

	include_once PHPCMS_ROOT.'/include/upload.class.php';

	$fileArr = array('file'=>$_FILES['uploadfile']['tmp_name'],'name'=>$_FILES['uploadfile']['name'],'size'=>$_FILES['uploadfile']['size'],'type'=>$_FILES['uploadfile']['type'],'error'=>$_FILES['uploadfile']['error']);
	$uploadfiletype = isset($uploadfiletype) ? $uploadfiletype : $PHPCMS['uploadfiletype'];

	dir_create($uploaddir);

	$upload = new upload($fileArr, $rename, $uploaddir, $uploadfiletype, 1, $maxfilesize);
    if($upload->up())
	{
		if($type == 'thumb' || $type == 'both' || $type == 'water')
		{
			include PHPCMS_ROOT.'/include/watermark.class.php';
			$water_pos = isset($water_pos) ? $water_pos : $PHPCMS['water_pos'];
			$wm = new watermark($upload->saveto, 10, $water_pos);
		}
		$querystring ='';
		if($type == 'thumb')
		{
			if($PHPCMS['enablethumb'])
			{
				$width = $newwidth ? $newwidth : $PHPCMS['thumb_width'];
				$height = $newheight ? $newheight : $PHPCMS['thumb_height'];
				$wm->thumb($width,$height);
			}
			$querystring = '&width='.$width.'&height='.$height;
		}
		elseif($type == 'both')
		{
			if($PHPCMS['enablethumb'])
			{
				$thumbname='thumb_'.basename($upload->saveto);
				$width = $width ? $width : $PHPCMS['thumb_width'];
				$height = $height ? $height : $PHPCMS['thumb_height'];
				$wm->thumb($width,$height,$uploaddir.$thumbname);
			}
			$querystring = '&width='.$width.'&height='.$height;
		}
		elseif($type == 'water')
		{
			if($PHPCMS['water_type']==1)
			{
				$water_text = $water_text ? $water_text : $PHPCMS['water_text'];
                $water_fontcolor = $water_fontcolor ? $water_fontcolor : $PHPCMS['water_fontcolor'];
				$water_fontsize = $water_fontsize ? $water_fontsize : $PHPCMS['water_fontsize'];
				$wm->text($water_text,$upload->saveto,$water_fontcolor,$water_fontsize,$PHPCMS['water_font']);
			}
			elseif($PHPCMS['water_type']==2)
			{
				$water_image = $water_image ? $water_image : $PHPCMS['water_image'];
				$wm->image($water_image,$upload->saveto);
			}
		}
		if($type != 'overwrite' && isset($oldname) && $oldname && !preg_match("/^http:\/\//i",$oldname))
		{
			@unlink(PHPCMS_ROOT.'/'.$oldname);
		}
		showmessage($LANG['upload_success']."<script language='javascript'>window.opener.myform.".$uploadtext.".value='".$upload->saveto."';</script>","?".$PHP_QUERYSTRING.$querystring);
    }
	else
	{
		showmessage($upload->errmsg(), '?'.$PHP_QUERYSTRING.$querystring);
	}
}
else
{
	include admintpl('uppic', 'phpcms');
}
?>