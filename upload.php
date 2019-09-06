<?php
require dirname(__FILE__).'/include/common.inc.php';
if(!$keyid || (!array_key_exists($keyid, $MODULE) && !array_key_exists($keyid, $CHANNEL))) showmessage($LANG['illegal_operation']);

$type = isset($type) ? $type : '';
$uploadfiletype = $PHPCMS['uploadfiletype'];
$maxfilesize = $PHPCMS['maxfilesize'];

if(is_numeric($keyid))
{
	$CHA = cache_read('channel_'.$keyid.'.php');
	if($CHA['uploadfiletype']) $uploadfiletype = $CHA['uploadfiletype'];
	if($CHA['maxfilesize']) $maxfilesize = $CHA['maxfilesize'];
	if($CHA['module'] == 'picture')
	{
		$picture_setting = cache_read('picture_setting.php');
		$CHA['uploaddir'] = $picture_setting['upload_dir'];
	}
	$uploaddir = $PHPCMS['uploaddir'].'/'.$CHA['channeldir'].'/'.$CHA['uploaddir'];
}
elseif($keyid)
{
	$MOD = cache_read($keyid.'_setting.php');
	if($MOD['uploadfiletype']) $uploadfiletype = $MOD['uploadfiletype'];
	if($MOD['maxfilesize']) $maxfilesize = $MOD['maxfilesize'];
	$uploaddir = $MOD['uploaddir'] ? $PHPCMS['uploaddir'].'/'.$MOD['moduledir'].'/'.$MOD['uploaddir'] : $PHPCMS['uploaddir'].'/'.$MOD['moduledir'];
}
else
{
	$uploaddir = $uploaddir ? $PHPCMS['uploaddir'].'/'.$uploaddir : $PHPCMS['uploaddir'];
}
$uploaddir = $uploaddir.'/'.date('Ym').'/';
if($type) $uploadfiletype = 'jpg|jpeg|gif|png|bmp';

if(isset($save))
{
	include_once PHPCMS_ROOT."/include/upload.class.php";
	$fileArr = array('file'=>$_FILES['uploadfile']['tmp_name'],'name'=>$_FILES['uploadfile']['name'],'size'=>$_FILES['uploadfile']['size'],'type'=>$_FILES['uploadfile']['type'],'error'=>$_FILES['uploadfile']['error']);
	if(!$uploadfiletype) $uploadfiletype = $PHPCMS['uploadfiletype'];
	dir_create($uploaddir);
	$upload = new upload($fileArr,'',$uploaddir,$uploadfiletype,1,$maxfilesize);
    if($upload->up())
	{
		if($type)
		{
			include PHPCMS_ROOT.'/include/watermark.class.php';
			$water_pos = isset($water_pos) ? $water_pos : $PHPCMS['water_pos'];
			$wm = new watermark($upload->saveto,50,$water_pos);
		}
		$querystring = '';
		if($type == "thumb")
		{
			if($PHPCMS['enablethumb'])
			{
				$wm->thumb($width,$height);
			}
			$querystring = "&width=".$width."&height=".$height;
		}
		else if($type == "both")
		{
			if($PHPCMS['enablethumb'])
			{
				$thumbname='thumb_'.basename($upload->saveto);
				$wm->thumb($width,$height,$uploaddir.$thumbname);
			}
			$querystring = "&width=".$width."&height=".$height;
		}
		elseif($type == "water")
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
		showmessage($LANG['file_upload_success']."<script language='javascript'>window.opener.myform.".$uploadtext.".value='".$upload->saveto."';window.close();</script>","?".$PHP_QUERYSTRING.$querystring);
    }
	else
	{
		showmessage($upload->errmsg(), '?'.$PHP_QUERYSTRING.$querystring);
	}
}
else
{
	$poss = array(1=>$LANG['top_left'],2=>$LANG['top_center'],3=>$LANG['top_right'],4=>$LANG['middle_left'],5=>$LANG['middle_center'],6=>$LANG['middle_right'],7=>$LANG['bottom_left'],8=>$LANG['bottom_center'],9=>$LANG['buttom_right']);
	include template('phpcms','upload');
}
?>