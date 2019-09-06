<?php
require '../include/common.inc.php';
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $CONFIG['charset'];?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo PHPCMS_PATH;?>editor/css/dialog.css"/>
<body>
<?php
$_userid or exit;
$PHP_REFERER or exit;
preg_match("/".$PHP_DOMAIN."/i",$PHP_REFERER) or exit;
$keyid or exit;
$up = is_numeric($keyid) ? cache_read('channel_'.$keyid.'.php') : cache_read($keyid.'_setting.php');
$up or exit;
$ext['img'] = 'jpg|jpeg|gif|png|bmp';
$ext['swf'] = 'swf|flv';
$ext['mv'] = 'mp3|mid|wma|wmv|asf|asx|avi|mpg|mpeg|rm|ra|ram|rmvb|mov';
$ext['att'] = $up['uploadfiletype'];
array_key_exists($do, $ext) or exit;

if($dosubmit)
{
	function msg($msg, $filepath = '')
	{
		global $PHP_REFERER;
		if($filepath) echo '<script>parent.document.getElementById("a").value="'.$filepath.'";</script>';
		echo '<script>alert("'.$msg.'");window.location="'.$PHP_REFERER.'";</script>';
		exit;
	}
	$fileext = fileext($_FILES['uploadfile']['name']);
	$exts = array('php','php3','asp','aspx','cgi','jsp','pl','cfg');
	if(!preg_match("/^(".$ext[$do].")$/i",$fileext)) msg("不允许上传该格式文件");
	if(!preg_match("/^(".$up['uploadfiletype'].")$/i",$fileext)) msg("不允许上传该格式文件");
	if(in_array($fileext, $exts)) msg('非法后缀！');

	include PHPCMS_ROOT.'/include/attachment.class.php';
	session_start();
	$att = new attachment;

	$tmpdir = $up['channeldir'] ? $up['channeldir'] : $up['moduledir'];
	$filepath = $keyid == 'phpcms' ? $PHPCMS['uploaddir'].'/'.date('Ym').'/' : $PHPCMS['uploaddir'].'/'.$tmpdir.'/'.$up['uploaddir'].'/'.date('Ym').'/';

	is_dir(PHPCMS_ROOT.'/'.$filepath) or dir_create(PHPCMS_ROOT.'/'.$filepath);
	require_once PHPCMS_ROOT.'/include/upload.class.php';
	$filearray = array('file'=>$_FILES['uploadfile']['tmp_name'],'name'=>$_FILES['uploadfile']['name'],'size'=>$_FILES['uploadfile']['size'],'type'=>$_FILES['uploadfile']['type'],'error'=>$_FILES['uploadfile']['error']);
	$up['maxfilesize'] = isset($up['maxfilesize']) ? $up['maxfilesize'] : 0;
	$upload = new upload($filearray, '', $filepath, $up['uploadfiletype'], 1, $up['maxfilesize']);
	if($upload->up())
	{
		if($do == 'img')
		{
			include PHPCMS_ROOT.'/include/watermark.class.php';
			$water_pos = $PHPCMS['water_pos'];
			$wm = new watermark(PHPCMS_ROOT.'/'.$upload->saveto, 10, $water_pos);
			if($PHPCMS['water_type']==1)
			{
				$wm->text($PHPCMS['water_text'], $upload->saveto, $PHPCMS['water_fontcolor'], $PHPCMS['water_fontsize'], $PHPCMS['water_font']);
			}
			elseif($PHPCMS['water_type']==2)
			{
				$wm->image(PHPCMS_ROOT.'/'.$PHPCMS['water_image'], PHPCMS_ROOT.'/'.$upload->saveto);
			}
		}
		$att->addfile($upload->saveto);
		msg('上传成功!', PHPCMS_PATH.$upload->saveto);
	}
	else
	{
		msg('上传失败!');
	}
}
else
{
?>
<script type="text/javascript">
if(typeof(parent.document) != "object") { document.body.style.display='none'; setInterval("window.close()", 1); }
function $(ID) { return document.getElementById(ID); }
function Check(){
	var v = $('uploadfile').value;
	if(!v){
		alert('请选择文件');
		return false;
	}
	var fileext = v.substring(v.lastIndexOf('.')+1, v.length);
	fileext = fileext.toLowerCase();
	if(fileext.length>4 || fileext.length<2){
		alert('无效的文件地址');
		$('uploadfile').value = '';
		return false;
	}
	var do_allow = "<?=$ext[$do]?>";
	var allow = "<?=$up['uploadfiletype']?>";
	if(do_allow.indexOf(fileext) == -1){
		alert('格式错误');
		return false;
	}
	if(allow.indexOf(fileext) == -1){
		alert('本站不允许上传此格式文件');
		return false;
	}
	$('upload').submit();
}
</script>
<form name="upload" id="upload" method="post" enctype="multipart/form-data" action="<?php echo PHPCMS_PATH;?>editor/upload.php?do=<?php echo $do;?>&keyid=<?php echo $keyid;?>">
<input type="hidden" name="dosubmit" value="1"/>
<input type="file" name="uploadfile" size="8" id="uploadfile"/>
<input type="button" value="上传" onclick="Check();"/>
</form>
<body>
</html>
<?php
}
?>