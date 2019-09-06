<?php
defined('IN_PHPCMS') or exit('Access Denied');
@set_time_limit(600);
$channelid = intval($channelid);
if(!$channelid) exit;
$uptype = isset($uptype) ? intval($uptype) : 1;
$upnum = isset($upnum) ? intval($upnum) : 1;
if($dosubmit)
{
	require_once PHPCMS_ROOT.'/include/upload.class.php';
	$filepath = $CHA['channeldir']."/".$CHA['uploaddir']."/".date("Ym")."/";
	is_dir(PHPCMS_ROOT.'/'.$filepath) or dir_create(PHPCMS_ROOT.'/'.$filepath);
	if($uptype == 1)
	{
		$key = array_keys($_FILES);
		$k = $key[0];
		$filearray = array('file'=>$_FILES[$k]['tmp_name'],'name'=>$_FILES[$k]['name'],'size'=>$_FILES[$k]['size'],'type'=>$_FILES[$k]['type'],'error'=>$_FILES[$k]['error']);
		$filename = (isset($rename) && $rename == 1) ? '' : $_FILES[$k]['name'];
		$upload = new upload($filearray, $filename, $filepath, $CHA['uploadfiletype'], 1, $CHA['maxfilesize']);
		if($upload->up())
		{
			$filesize = round($_FILES[$k]['size']/1024, 2);
			echo '<script>var s = parent.document.getElementById("infourls").value == "" ? "" : "\n";parent.document.getElementById("infourls").value += s+"'.$note.'|'.$upload->saveto.'";parent.document.getElementById("filesize").value="'.$filesize.'";</script>';
			msg('Success');
		}
		else
		{
			msg('Unsuccess');
		}
	}
	elseif($uptype == 2)
	{
		$filename = (isset($rename) && $rename == 1) ? date('Ymdhis').rand(100,999).".".fileext($url) : basename($url);
		if(@copy($url, PHPCMS_ROOT.'/'.$filepath.$filename))
		{
			$filesize = round(filesize(PHPCMS_ROOT.'/'.$filepath.$filename)/1024, 2);
			echo '<script>var s = parent.document.getElementById("infourls").value == "" ? "" : "\n";parent.document.getElementById("infourls").value += s+"'.$note.'|'.$filepath.$filename.'";parent.document.getElementById("filesize").value="'.$filesize.'";</script>';
			msg('Success');
		}
		else
		{
			msg('Unsuccess');
		}
		
	}
	elseif($uptype == 3)
	{
		$key = array_keys($_FILES);
		$k = $key[0];
		$Y = 0;
		$N = 0;
		for($i=0; $i<$upnum; $i++)
		{
			$filename = (isset($rename) && $rename == 1) ? '' : $_FILES[$k]['name'][$i];
			$filearray = array('file'=>$_FILES[$k]['tmp_name'][$i],'name'=>$_FILES[$k]['name'][$i],'size'=>$_FILES[$k]['size'][$i],'type'=>$_FILES[$k]['type'][$i],'error'=>$_FILES[$k]['error'][$i]);
			if($filearray['error']) {++$N; continue;}
			$upload = new upload($filearray, $filename, $filepath, $CHA['uploadfiletype'], 1, $CHA['maxfilesize']);
			if($upload->up())
			{
				++$Y;
				$filesize = round($_FILES[$k]['size'][$i]/1024, 2);
				echo '<script>var s = parent.document.getElementById("infourls").value == "" ? "" : "\n";parent.document.getElementById("infourls").value += s+"'.$note[$i].'|'.$upload->saveto.'";parent.document.getElementById("filesize").value="'.$filesize.'";</script>';
			}
			else
			{
				++$N;
			}
		}
		msg($Y.' Success，'.$N.' Unsuccess', '', 3000);
	}
}
else
{
	include admintpl('upload');
}
?>