<?php
defined('IN_PHPCMS') or exit('Access Denied');

@set_time_limit(600);
$channelid = intval($channelid);
if(!$channelid) exit;
$uptype = isset($uptype) ? intval($uptype) : $MOD['uptype'];
$upnum = isset($upnum) ? intval($upnum) : $MOD['upnum'];
if($uptype == 1) $upnum = 1;
if($uptype == 2) $upnum = 3;

if($dosubmit)
{
	if(isset($CHA))
	{
		@extract($CHA);
	}
	elseif(isset($MOD))
	{
		@extract($MOD);
	}
	else
	{
		@extract($PHPCMS);
	}
	require_once PHPCMS_ROOT.'/include/upload.class.php';
	include PHPCMS_ROOT.'/include/watermark.class.php';
	$water_pos = isset($water_pos) ? $water_pos : $PHPCMS['water_pos'];
	$filepath = $PHPCMS['uploaddir'].'/'.$CHA['channeldir'].'/'.$MOD['upload_dir'].'/'.date('Ym').'/';
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
			$wm = new watermark($upload->saveto, 10, $water_pos);
			if($PHPCMS['water_type']==1)
			{
				$water_text = isset($water_text) ? $water_text : $PHPCMS['water_text'];
                $water_fontcolor = isset($water_fontcolor) ? $water_fontcolor : $PHPCMS['water_fontcolor'];
				$water_fontsize = isset($water_fontsize) ? $water_fontsize : $PHPCMS['water_fontsize'];
				$wm->text($water_text, $upload->saveto, $water_fontcolor, $water_fontsize, $PHPCMS['water_font']);
			}
			elseif($PHPCMS['water_type']==2)
			{
				$water_image = isset($water_image) ? $water_image : $PHPCMS['water_image'];
				$wm->image($water_image, $upload->saveto);
			}
			$thumbname='thumb_'.basename($upload->saveto);
			$wm->thumb($MOD['thumb_maxwidth'],0,$filepath.$thumbname);

			$saveto = str_replace($PHPCMS['uploaddir'].'/'.$CHA['channeldir'].'/'.$MOD['upload_dir'].'/', '', $upload->saveto);
			echo '<script>var s = parent.document.getElementById("pictureurls").value == "" ? "" : "\n";parent.document.getElementById("pictureurls").value += s+"'.$note.'|'.$saveto.'";</script>';
			msg('Success');
		}
		else
		{
			msg('Unsuccess');
		}
	}
	elseif($uptype == 2)
	{
		$type = isset($type) ? $type : 0;
		$T = 0;
		$Y = 0;
		$N = 0;
		if(preg_match("/(.*)\(\*\)(.*)/", $url, $m))
		{
			$T = 1;
		}
		if($type == 2 && $T)
		{
			if(!isset($cf) || !isset($ct)) msg('Error!');
			if( (preg_match("/[a-z]{1}/", $cf) && preg_match("/[a-z]{1}/", $ct) && ord($cf) < ord($ct) ) || (preg_match("/[A-Z]{1}/", $cf) && preg_match("/[A-Z]{1}/", $ct) && ord($cf) < ord($ct)) )
			{
				$i = ord($cf);
				$j = ord($ct);
			}
			else
			{
				msg('Error!');
			}
		}
		elseif($type == 1 && $T)
		{
			$nf = intval($nf);
			$nt = intval($nt);
			$length = intval($length);
			if(!$nt) msg('Error!');
			if($nf > $nt) list($nf, $nt) = array($nt, $nf);
			$i = $nf;
			$j = $nt;
		}
		else
		{
			$i = 1;
			$j = 1;
		}
		for( ; $i <= $j; $i ++)
		{
			if($type == 2 && $T && $m[1] && $m[2])
			{
				$url = $m[1].chr($i).$m[2];
			}
			elseif($type == 1 && $T && $m[1] && $m[2])
			{
				$url = $length ? $m[1].sprintf('%0'.$length.'d', $i).$m[2] : $m[1].$i.$m[2];
			}
			$filename = (isset($rename) && $rename == 1) ? date('Ymdhis').rand(100,999).".".fileext($url) : basename($url);
			if(@copy($url, PHPCMS_ROOT.'/'.$filepath.$filename))
			{
				++$Y;
				$wm = new watermark($filepath.$filename, 10, $water_pos);
				if($PHPCMS['water_type']==1)
				{
					$water_text = isset($water_text) ? $water_text : $PHPCMS['water_text'];
					$water_fontcolor = isset($water_fontcolor) ? $water_fontcolor : $PHPCMS['water_fontcolor'];
					$water_fontsize = isset($water_fontsize) ? $water_fontsize : $PHPCMS['water_fontsize'];
					$wm->text($water_text, $filepath.$filename, $water_fontcolor, $water_fontsize, $PHPCMS['water_font']);
				}
				elseif($PHPCMS['water_type']==2)
				{
					$water_image = isset($water_image) ? $water_image : $PHPCMS['water_image'];
					$wm->image($water_image, $filepath.$filename);
				}
				$thumbname='thumb_'.$filename;
				$wm->thumb($MOD['thumb_maxwidth'],0,$filepath.$thumbname);

				$saveto = str_replace($PHPCMS['uploaddir'].'/'.$CHA['channeldir'].'/'.$MOD['upload_dir'].'/', '', $filepath.$filename);
				echo '<script>var s = parent.document.getElementById("pictureurls").value == "" ? "" : "\n";parent.document.getElementById("pictureurls").value += s+"'.$note.'|'.$saveto.'";</script>';
			}
			else
			{
				++$N;
			}
		}
		msg($Y.' Success, '.$N.' Unsuccess', '', 3000);
		
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
				$wm = new watermark($upload->saveto, 10, $water_pos);
				if($PHPCMS['water_type']==1)
				{
					$water_text = isset($water_text) ? $water_text : $PHPCMS['water_text'];
					$water_fontcolor = isset($water_fontcolor) ? $water_fontcolor : $PHPCMS['water_fontcolor'];
					$water_fontsize = isset($water_fontsize) ? $water_fontsize : $PHPCMS['water_fontsize'];
					$wm->text($water_text, $upload->saveto, $water_fontcolor, $water_fontsize, $PHPCMS['water_font']);
				}
				elseif($PHPCMS['water_type']==2)
				{
					$water_image = isset($water_image) ? $water_image : $PHPCMS['water_image'];
					$wm->image($water_image, $upload->saveto);
				}
				$thumbname='thumb_'.basename($upload->saveto);
				$wm->thumb($MOD['thumb_maxwidth'],0,$filepath.$thumbname);

				$saveto = str_replace($PHPCMS['uploaddir'].'/'.$CHA['channeldir'].'/'.$MOD['upload_dir'].'/', '', $upload->saveto);
				echo '<script>var s = parent.document.getElementById("pictureurls").value == "" ? "" : "\n";parent.document.getElementById("pictureurls").value += s+"'.$note[$i].'|'.$saveto.'";</script>';
			}
			else
			{
				++$N;
			}
		}
		msg($Y.' Success,'.$N.' Unsuccess', '', 3000);
	}
}
else
{
	include admintpl('upload');
}
?>