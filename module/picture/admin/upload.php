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
defined('IN_PHPCMS') or exit('Access Denied');

if($channelid)
{
	@extract($_CHA);
}

if($save)
{
	$fileArr = array('file'=>$uploadfile,'name'=>$uploadfile_name,'size'=>$uploadfile_size,'type'=>$uploadfile_type);
	$savepath = $channeldir."/".$uploaddir."/".date("Ym")."/";
	$f->create($savepath);
	$upload = new upload($fileArr,'',$savepath,$uploadfiletype,1,$maxfilesize);
    if($upload->up())
	{
		$note = $note ? $note : "图片地址'+(parent.document.myform.PictureUrl.length+1)+'";
		$message = "上传成功！
		            <SCRIPT language='javascript'>
		            var url='".$note."|".$upload->saveto."'; 
                    parent.document.myform.PictureUrl.options[parent.document.myform.PictureUrl.length]=new Option(url,url);
					setTimeout(\"window.location='".$PHP_REFERER."';\", 1250);
					</script>";
		message($message);
    }
	else
	{
		message($upload->errmsg());
	}
}
else
{
	include admintpl('upload');
}
?>