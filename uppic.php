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
require './common.php';

if(!$_userid) message("您还没有登录，不允许上传文件！","goback");

$skindir = PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$defaultskin;

if($channelid)
{
	@extract($_CHA);
    if(!$enableupload) message("本频道不允许上传文件！","goback");
	$uploaddir = $type=="thumb" ? "thumb" : $uploaddir;
}
else
{
	$uploadfiletype = $_PHPCMS['uploadfiletype'];
}

if($save)
{
    include PHPCMS_ROOT."/class/upload.php";
	$fileArr = array('file'=>$uploadfile,'name'=>$uploadfile_name,'size'=>$uploadfile_size,'type'=>$uploadfile_type);
	
	$savepath = $uploaddir ? $channeldir."/".$uploaddir."/".date("Ym")."/" : $_PHPCMS['uploaddir']."/".date("Ym")."/";

	$f->create($savepath);
	$upload = new upload($fileArr,'',$savepath,$uploadfiletype,1,$maxfilesize);
    if($upload->up())
	{
		if($action)
		{
			include PHPCMS_ROOT."/class/watermark.php";
			$water_pos = $water_pos ? $water_pos : $_PHPCMS['water_pos'];
			$wm = new watermark($upload->saveto,10,$water_pos);
		}
		if($action == "thumb")
		{
			if($_PHPCMS['enablethumb'])
			{
				$width = $width ? $width : $_PHPCMS['thumb_width'];
				$height = $height ? $height : $_PHPCMS['thumb_height'];
				$wm->thumb($width,$height);
			}
			$querystring = "&width=".$width."&height=".$height;
		}
		elseif($action == "water")
		{
			if($_PHPCMS['water_type']==1)
			{
				$water_text = $water_text ? $water_text : $_PHPCMS['water_text'];
                $water_fontcolor = $water_fontcolor ? $water_fontcolor : $_PHPCMS['water_fontcolor'];
				$water_fontsize = $water_fontsize ? $water_fontsize : $_PHPCMS['water_fontsize'];
				$wm->text($water_text,$upload->saveto,$water_fontcolor,$water_fontsize,$_PHPCMS['water_font']);
			}
			elseif($_PHPCMS['water_type']==1)
			{
				$water_image = $water_image ? $water_image : PHPCMS_ROOT."/images/watermark.gif";
				$wm->image($water_image,$upload->saveto);
			}
		}
		if(!preg_match("/^http:\/\//i",$oldname)) @$f->unlink(PHPCMS_ROOT."/".$oldname);
    	message("上传成功！<script language='javascript'>window.opener.myform.".$uploadtext.".value='".$upload->saveto."';</script>","?".$PHP_QUERYSTRING.$querystring);
    }
	else
	{
		message($upload->errmsg(),"?".$PHP_QUERYSTRING.$querystring);
	}
}
else
{
	$poss = array(1=>"顶端居左",2=>"顶端居中",3=>"顶端居右",4=>"中部居左",5=>"中部居中",6=>"中部居右",7=>"底端居左",8=>"底端居中",9=>"底端居右");
	include template('phpcms','uppic');
}
?>