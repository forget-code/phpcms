<?php
include './config.inc.php';

$dirnames = dirname(QUERY_STRING);
$tmp = PHPCMS_ROOT.str_replace($PHPCMS['siteurl'],'',$dirnames).'/';
$tmp_url = str_replace($PHPCMS['siteurl'],'',$dirnames);

if(preg_match("/http:/",$tmp))
{
	$tmp = PHPCMS_ROOT.UPLOAD_URL.date('Y').'/'.date('md').'/';
	$tmp_url = UPLOAD_URL.date('Y').'/'.date('md');
	dir_create($tmp);
}
setcookie('tmp',$tmp);
setcookie('tmp_url',$tmp_url);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8".CHARSET />
<?php
$pic = @trim(QUERY_STRING);
if(empty($pic)){
	echo '<script language="javascript">alert("请选择需要剪切的图片！");window.opener=null;window.close();</script>';
	exit;
}
elseif(!preg_match(FILENAME_CHECK,$pic))
{
	echo '<script language="javascript">alert("请正确选择需要的图片！");window.opener=null;window.close();</script>';
	exit;
}
?>
	<title>在线图片处理 V1.1</title>
	<link rel="stylesheet" type="text/css" href="css/cropandresize.css" />
	<script type="text/javascript" src="js/lib/prototype.js"></script>
</head>
<body OnContextMenu="return false;" onselectstart="return true;">
<table border="0" cellpadding="0" cellspacing="0" align="center" style="display:" id="coordlayer">
	<tr>
	<td>
		<div id="element_container" class="element_container">
			<img src="<?php echo $pic;?>" alt="" id="sampleid"/>
			<img src="images/uploading.gif" id="uploadingid" class="uploading" width="78" height="7"/>
		</div>
	</td>
	</tr>
	<tr>
		<td class="track_bg">
		  <div id="track" class="track">
			<div id="handle" class="handle"><img src="images/magnoliacom.png"></div>
		  </div>
		</td>
	</tr>
	<tr>
		<td>
			<form name="coordsform" id="coordsform" action="process.php" method="post" onsubmit="return false;">
			<input type="hidden" name="x" value="0" id="coord_x" />
			<input type="hidden" name="y" value="0" id="coord_y" />
			<input type="hidden" name="w" value="0" id="coord_w" />
			<input type="hidden" name="h" value="0" id="coord_h" />
			<input type="hidden" name="iw" value="0" id="coord_iw" />
			<input type="hidden" name="ih" value="0" id="coord_ih" />
			<input type="hidden" name="phpcms_path" value="<?=PHPCMS_PATH?>" id="phpcms_path" />
			<input type="hidden" name="pic" value="<?php echo $pic;?>" id="coord_pic" />
			<table border="0" cellpadding="0" cellspacing="0" id="coordinates" width="500">
				<tr>
					<td align="center" width="500" nowrap="nowrap">
					<span style="display:none">
					<strong>x:</strong><span id="sample_x">0</span>px&nbsp;
					<strong>y:</strong><span id="sample_y">0</span>px&nbsp;
					<strong>w:</strong><span id="sample_w">0</span>px&nbsp;
					<strong>h:</strong><span id="sample_h">0</span>px&nbsp;
					<strong>iw:</strong><span id="sample_iw">0</span>px&nbsp;
					<strong>ih:</strong><span id="sample_ih">0</span>px&nbsp;&nbsp;
					</span>
					剪切框：
					宽度=<input type="text" name="c_w" value="160" id="c_w" size=3 onmouseover="this.focus()" onfocus="this.select()" />px
					&nbsp;
					高度=<input type="text" name="c_h" value="120" id="c_h" size=3 onmouseover="this.focus()" onfocus="this.select()" />px
					<input type="button" value="确定" onclick="setCustomCoord()"/>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" value="剪切图片" onclick="sendCropAndResize()"/>
					</td>
				</tr>
				<tr>
					<td align="center" nowrap="nowrap">
					<input type="hidden" value="Zoom out" onclick="imageZoomOut();" />
					&nbsp;
					<input type="hidden" value="Zoom in" onclick="imageZoomIn();" />
					&nbsp;
					<input type="button" value="重置" onclick="resetSelection();" />
					&nbsp;
					<input type="button" value="复位" onclick="resetImage();" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<table border="0" cellpadding="0" cellspacing="0" width="500" height="450" align="center" style="display:none" id="processlayer">
	<tr>
		<td align="center" valign="middle" height="375">
			<img src="images/uploading.gif" alt="" id="processid" />
		</td>
	</tr>
	<tr>
		<td align="center" valign="middle">
			<div id="processcompleteid" style="display:none">
				<input type="button" value="重做" onclick="redoImage();" />
				<span id="fished"></span>
			</div>
		</td>
	</tr>
</table>
<textarea id="error_list" style="display:none">
0.未知错误，请检查配置
1.请选择需要剪切的图片！
2.请正确选择需要的图片！
3.图片读取失败
4.图片文件太小，不能处理
5.图片格式不正确，无法处理
6.图片尺寸太小，无法处理
7.图片剪切失败
8.图片写入失败
</textarea>
<script type="text/javascript" src="js/src/scriptaculous.js?load=effects,slider,rectmarquee,cropandresize,previewtt"></script>
</body>
</html>