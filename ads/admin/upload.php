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

if($extid==1) {
  $upfile_type=	"jpg|png|gif";
} elseif ($extid==2) {
  $upfile_type=	"swf";
}

if($action=='upload')
{
	$fileArr = array(
		'file'=>$uploadfile,
		'name'=>$uploadfile_name,
		'size'=>$uploadfile_size,
		'type'=>$uploadfile_type);

	$showname= $fileArr['name'];
	$tmpext=strtolower(fileext($showname));
	$tmpfilesize=$fileArr['size'];
	$savepath = $mod.'/'.$upfile_dir.'/'.date('Ym');
	$f->create($savepath);

	$up = new upload($fileArr,'',$savepath,$upfile_type,1,$upfile_size);
    if($up->up())
	{	
		$filepath =$mod.'/'.$upfile_dir.'/'.date('Ym').'/'.$up->savename;
			$script='<script>
			var ctl_hurl=window.opener.document.getElementById("'.$url.'");
			var ctl_upbutten=window.opener.document.getElementById("upload");
			ctl_hurl.value="'.$filepath.'";
  		ctl_hurl.style.background="white";
			self.close();
			</script>';
		echo $script;
    }
	else
	{
		$script='<script>
		var ctl_hurl=window.opener.document.getElementById("'.$url.'");
		ctl_hurl.value="'.$up->errmsg().'";
		ctl_hurl.readOnly=true;
		ctl_hurl.style.background="red";
		self.close();
		</script>';
		echo $script;
	}
	die;
}
else
{
	include admintpl('upload');
}
?>