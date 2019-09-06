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
require PHPCMS_ROOT."/class/upload.php";

if(!$_userid) message("请您先登录或注册！" , PHPCMS_PATH."member/login.php");

if($extid==1) {
  $upfile_type=	"jpg|png|gif";
} else {
  $upfile_type=	"swf";
}

if($action=='upload')
{
	$fileArr = array(
		'file'=>$uploadfile,
		'name'=>$uploadfile_name,
		'size'=>$uploadfile_size,
		'type'=>$uploadfile_type
		);

	$showname= $fileArr['name'];
	$tmpext=strtolower(fileext($showname));
	$tmpfilesize=$fileArr['size'];
	$savepath = 'ads/'.$upfile_dir.'/'.date('Ym');
	$f->create(PHPCMS_ROOT."/".$savepath);
	$up = new upload($fileArr,'',$savepath,$upfile_type,1,$upfile_size);
    if($up->up())
	{	
		$filepath =$up->saveto;
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
	include template('ads','signadsupload');
}
?>