<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="images/js/form.js"></script>
<script type="text/javascript" src="images/js/swfobject.js"></script>
<style>
<!--
#uploadp{background-color: #FFFFFF; border:#666666 1px solid; height: 21px; line-height:21px;  width: 238px; margin: 0px 0px 0px 25px; padding:1px;text-align: center;overflow:hidden;font-size:14px;}
#e{float:left; margin-top:0px;background-color: #83BAEC;text-align:right; height:20px; line-height:20px; color:#fff;font-size:14px;}
-->
</style>
<body>
<?=$menu?>
<div class="tag_menu" style="width:99%;margin-top:10px;">
<ul>
  <li><a href="###" id='TabTitle0' onclick='ShowTabs(0)' class="selected">基本信息</a></li>
  <li><a href="###" id='TabTitle1' onclick='ShowTabs(1)'>高级设置</a></li>
</ul></div>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&catid=<?=$catid?>&modelid=<?=$modelid?>" method="post" name="myform" id="myform" enctype="multipart/form-data" onSubmit="return false;">
<div id='Tabs0' style='display:'>
<input type="hidden" name="dosubmit" value="1" />
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>基本信息</caption>
  <tr>
      <th width="20%"><strong>选择视频</strong></th>
      <td>
<table>
<tr>
	<td><div id="uploadp"></div></td>
	<td><div id="upload_flash_video"></div> <div id="filesize"></div><input type="hidden" name="sid" value="<?=$sid?>">
      <input type="hidden" id="video_uploader" value="0"></td>
</tr>
</table>
      </td>
    </tr>
 <?php
if(is_array($forminfos['base']))
{
 foreach($forminfos['base'] as $field=>$info)
 {
 ?>
	<tr>
      <th width="20%"><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <strong><?=$info['name']?></strong> <br />
	  <?=$info['tips']?>
	  </th>
      <td><?=$info['form']?> </td>
    </tr>
<?php
} }
?>
<tr>
      <th width="20%"><strong>状态</strong><br />
	  </th>
      <td>
	  <?php if($allow_manage){ ?>
	  <label><input type="radio" name="status" value="99" checked/> 发布</label>
	  <?php } ?>
	  <label><input type="radio" name="status" value="3" <?=$allow_manage ? '' : 'checked'?>> 审核</label>
	  <label><input type="radio" name="status" value="2"> 草稿</label>
	  </td>
    </tr>
    <tr>
      <td></td>
      <td>
	  <input type="hidden" name="forward" value="<?=$forward?>">
	  <input type="submit" name="dosubmit" value=" 确定 ">
	  &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>
</table>
</div>
<div id='Tabs1' style='display:none'>
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>高级设置</caption>
 <?php
if(is_array($forminfos['senior']))
{
 foreach($forminfos['senior'] as $field=>$info)
 {
 ?>
	<tr>
      <th width="20%"><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <strong><?=$info['name']?></strong> <br />
	  <?=$info['tips']?>
	  </th>
      <td><?=$info['form']?> </td>
    </tr>
<?php
} }
?>
    <tr>
      <td></td>
      <td>
	  <input type="hidden" name="forward" value="<?=$forward?>">
	  <input type="submit" name="dosubmit" value=" 确定 ">
	  &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>
</table>
</div>

</div>
</form>
<script type="text/javascript">
var selectVideo = false;
function uploadVideo()
{
	var sid='<?php echo $sid;?>';
	var som = new SWFObject('http://img.ku6.com/ku6vms/player/uploadfile/upV1.1.swf', 'uploader_video', '84', '25', '8', '');
	som.addParam('allowScriptAccess', 'always');
	som.addParam('FlashVars',"t=1&m=0&s=819200&n=UploadVideo&c=1&sid="+sid);
	som.addParam('wmode','transparent');
	som.write('upload_flash_video');
}

var UploadVideo = {
isUploading:false,
onSelect:function(args){
//选择视频文件
if (args[0].status == 1){
selectVideo = true;
$('#uploadp').html(args[0].name);
if($('#title').val() == '') $('#title').val(args[0].name.replace(args[0].type, ''));
$('#type').val(args[0].type);
} 
if (args[0].status == '-1') {
alert('文件超过最大尺寸');
}

},
onProgress:function(args){
//正在进行文件上传
var width=parseInt((args.bytesLoaded/args.bytesTotal)*236)+'px';
$('#e').css("width", width);
$('#e').html(parseInt((args.bytesLoaded/args.bytesTotal)*100)+"%");
$('#filesize').html((args.bytesLoaded/1024).float_n(2)+'KB/'+(args.bytesTotal/1024).float_n(2)+'KB');
},
onComplete:function(args){
//文件上传成功
if(args){
if(args.status=='1'){
document.getElementById('myform').submit();
return true;
}
if(args.status=='-4') {
alert('IO错误');
return false;
}
if(args.status=='3') {
alert('安全错误。');
return false;
}
alert('对不起,服务器忙,请稍后重试.');
return false;
}else{
alert('对不起,服务器忙,请稍后重试.');
return false;
}
},
onAllComplete:function(args){
//批量上传时，所有文件上传完成
},
onAllRemove:function(args){
//所有文件都移除
},
reset:function(){
//重新上传
},
submit:function(){
//上传视频
if(this.isUploading){
alert('文件正在上传中');
return false;
}
this.isUploading=true;

document.getElementById('uploader_video').onSubmit('http://upload.ku6.com/videoUpload.htm?type=1&sid=<?php echo $sid;?>');

$('#uploadp').html('<div id="e"></div>');
$('#upload_flash_video').hide();
$('#title').attr('readonly', 'readonly');
$('#description').attr('readonly', 'readonly');
$('#tag').attr('readonly', 'readonly');
$('#cid').attr('readonly', 'readonly');

}	
}
uploadVideo();


Number.prototype.float_n=function(n){
var num=this;
num=""+num;
var pos=num.indexOf(".");
if(pos>0) {
return parseFloat(num.substr(0,pos+n+1));
} else {
return num;
}
}
</script>
<script LANGUAGE="javascript">
<!--
$().ready(function() {
	$('form').checkForm(1);
	});

function check_catid(catid)
{
	$.get('?mod=video&file=video&action=check_catid&catid='+catid,function(data)
	{
		if(data=='1') {
			$('#catiderror').html("<span tag='err' class='no'>父栏目不允许发布视频，请选择子栏目</span>");
			document.getElementById('catid').options[0].selected=true;
		}
	});
}
//-->
</script>
</body>
</html>