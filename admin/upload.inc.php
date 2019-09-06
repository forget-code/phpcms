<?php
defined('IN_PHPCMS') or exit('Access Denied');

$rename = isset($rename) ? $rename : '';
$type = isset($type) ? $type : '';
if($rename!='')
{
	$exts = array('.php','.asp','.cgi','.jsp','.aspx','.pl','.cfg');
	foreach($exts as $ext)
	{
		if(strpos($rename, $ext)===FALSE)	continue; 
		else showmessage($LANG['illegal_extension']);
	}
}
if(is_numeric($keyid))
{
	$CHA = cache_read('channel_'.$keyid.'.php');
}
else
{
	$MOD = cache_read($keyid.'_setting.php');
}
if(isset($CHA['uploaddir']))
{
	@extract($CHA);
	$uploaddir = $PHPCMS['uploaddir'].'/'.$channeldir.'/'.$uploaddir;
}
elseif(isset($MOD['uploaddir']))
{
	@extract($MOD);
	$uploaddir = $PHPCMS['uploaddir'].'/'.$mod.'/'.$uploaddir;
}
else 
{
	@extract($PHPCMS);
}

$uploaddir = $rename==''?  $uploaddir.'/'.date('Ym').'/':$uploaddir.'/';
if($type == 'cert') $uploaddir = 'cert/';
if($type == 'favicon') $uploaddir = '/';
$maxfilesize = isset($maxfilesize) ? $maxfilesize : 2048000 ;
if(isset($save))
{
	include_once PHPCMS_ROOT."/include/upload.class.php";
	$fileArr = array('file'=>$_FILES['uploadfile']['tmp_name'],'name'=>$_FILES['uploadfile']['name'],'size'=>$_FILES['uploadfile']['size'],'type'=>$_FILES['uploadfile']['type'],'error'=>$_FILES['uploadfile']['error']);
	dir_create($uploaddir);
	$upload = new upload($fileArr,$rename,$uploaddir,$uploadfiletype,1,$maxfilesize);
    if($upload->up())
	{
		if(isset($oldname) && $oldname && !preg_match("/^http:\/\//i",$oldname) && $oldname!=$upload->saveto)
		{
			@unlink(PHPCMS_ROOT."/".$oldname);
		}
    	showmessage($LANG['upload_success']."<script language='javascript'>window.opener.myform.".$uploadtext.".value='".$upload->saveto."';window.close();</script>","?".$PHP_QUERYSTRING);
    }
	else
	{
		showmessage($upload->errmsg(),"?".$PHP_QUERYSTRING);
	}
}
else
{
	if(!isset($keyid)) $keyid = isset($module) ? $module : $channelid;
	include admintpl('upload');
}
?>