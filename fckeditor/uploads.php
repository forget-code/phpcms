<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/
include_once "../common.php";

if(!$_userid) message("<script>alert('您还没有登录，不允许上传文件！');</script>");

if($channelid)
{
	@extract($_CHA);
    if(!$enableupload) message("<script>alert('本频道不允许上传文件！');</script>");
}
else
{
	$uploadfiletype = $_PHPCMS['uploadfiletype'];
}

include PHPCMS_ROOT."/class/upload.php";
$fileArr = array('file'=>$uploadfile,'name'=>$uploadfile_name,'size'=>$uploadfile_size,'type'=>$uploadfile_type);

$savepath = $uploaddir ? $channeldir."/".$uploaddir."/".date("Ym")."/" : $_PHPCMS['uploaddir']."/".date("Ym")."/";

$f->create(PHPCMS_ROOT."/".$savepath);
$upload = new upload($fileArr,'',$savepath,$uploadfiletype,1,$maxfilesize);

if($upload->up())
{
	include PHPCMS_ROOT."/class/watermark.php";
	$imgpath = PHPCMS_ROOT."/".$upload->saveto;
	$water_pos = $water_pos ? $water_pos : $_PHPCMS['water_pos'];
	$wm = new watermark($imgpath,10,$water_pos);
    $wm->transition = 60;
	if($_PHPCMS['water_type']==1)
	{
		$water_text = $water_text ? $water_text : $_PHPCMS['water_text'];
		$water_fontcolor = $water_fontcolor ? $water_fontcolor : $_PHPCMS['water_fontcolor'];
		$water_fontsize = $water_fontsize ? $water_fontsize : $_PHPCMS['water_fontsize'];
		$wm->text($water_text,$imgpath,$water_fontcolor,$water_fontsize,PHPCMS_ROOT."/".$_PHPCMS['water_font']);
	}
	elseif($_PHPCMS['water_type']==2)
	{
		$water_image = $water_image ? $water_image : PHPCMS_ROOT."/".$_PHPCMS['water_image'];
		$wm->image($water_image,$imgpath);
	}

	if(!$needjump)
	{
		$message = "<script language='javascript'>";
		$message .= "alert('上传成功！');";
		$message .= "window.parent.ext_gif = '".substr($upload->saveto,-3).".gif';";
		$message .= "window.parent.phpcms_path = '".PHPCMS_PATH."';";
		$message .= "window.parent.".$uploadtext.".value='".PHPCMS_PATH.$upload->saveto."';";
		$message .= "</script>";
	}
	else
	{
		$message = "<script language='javascript'>";
		$message .= "alert('上传成功！');";
		$message .= "window.parent.SetUrl('".PHPCMS_PATH.$upload->saveto."');";
		$message .= "window.parent.GetE('frmUpload').reset() ;";
		$message .= "</script>";
	}
	message($message);
}
else
{
	message("<script language='javascript'>alert('".$upload->errmsg()."');</script>");
}
?>