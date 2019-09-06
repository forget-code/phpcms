<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script type="text/javascript">
	window.onload=function(){
	var h = <?=$upnum?>*20+30;
	parent.$('uploads').height = h;
}
</script>
<table width="100%" cellpadding="0" cellspacing="0"  height="100%">
  <tr>
    <td  class="tablerow">
	<input type="radio" value="1" name="uptype" <?php if($uptype==1) { ?>checked<?php } ?> onclick="window.location='?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&uptype=1'"> 本地上传
	<input type="radio" value="2" name="uptype" <?php if($uptype==2) { ?>checked<?php } ?> onclick="window.location='?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&uptype=2'"> 远程获取
	<input type="radio" value="2" name="uptype" <?php if($uptype==3) { ?>checked<?php } ?> onclick="window.location='?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&uptype=3&upnum=<?=$MOD['upnum']?>'"> 批量上传
	</td>
  </tr>


<?php if($uptype==1) { ?>
<script type="text/javascript">
  function Check(){
	var v = $('uploadfile').value;
	if(!v){
		alert('请选择文件');
		return false;
	}
	var fileext = v.substring(v.lastIndexOf('.')+1, v.length);
	if(fileext.length>4 || fileext.length<2){
		alert('无效的文件地址');
		return false;
	}
	fileext = fileext.toLowerCase();
	var allow = "<?=$CHA['uploadfiletype']?>";
	if(allow.indexOf(fileext) == -1){
		alert('允许上传的文件格式是:'+allow);
		return false;
	}
	$('submit').value = '正在上传...';
	return true;
}
</script>

  <tr>
    <td class="tablerow">
	<table cellpadding="0" cellspacing="0" width="100%">
	<form name="upload" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&uptype=<?=$uptype?>&dosubmit=1" enctype="multipart/form-data" onsubmit="return Check();">
	<tr>
	<td class="tablerow">
	说明：<input type="text" name="note" size="20" value="图片说明" onfocus="if(this.value=='图片说明') this.value='';" onblur="if(this.value=='') this.value='图片说明';">
	<input type="file" name="uploadfile" size="15" id="uploadfile">
	<input type="checkbox" name="rename" value="1" checked> 重命名
	<input type="submit" id="submit" value=" 上传 ">
	</td>
	</tr>
	</form>
	</table>
	</td>
  </tr>

  <?php } elseif($uptype==2) { ?>

<script type="text/javascript">
function Check(){
	var v = $('url').value;
	if(!v || v=='http://' || v=='ftp://'){
		alert('请输入远程文件地址');
		return false;
	}
	var fileext = v.substring(v.lastIndexOf('.')+1, v.length);
	if(fileext.length>4 || fileext.length<2){
		alert('无效的文件地址');
		return false;
	}
	fileext = fileext.toLowerCase();
	var allow = "<?=$CHA['uploadfiletype']?>";
	if(allow.indexOf(fileext) == -1){
		alert('允许上传的文件格式是:'+allow);
		return false;
	}
	$('submit').value = '正在获取...';
	return true;
}
function show(id){
	if(id == 1){
		$('nf').disabled = false;
		$('nt').disabled = false;
		$('length').disabled = false;
		$('cf').disabled = true;
		$('ct').disabled = true;
	}else if(id == 2){
		$('cf').disabled = false;
		$('ct').disabled = false;
		$('nf').disabled = true;
		$('nt').disabled = true;
		$('length').disabled = true;
	}
}

</script>

  <tr>
    <td class="tablerow">
		<table cellpadding="0" cellspacing="0" width="100%">
		<form name="upload" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&uptype=<?=$uptype?>&dosubmit=1" onsubmit="return Check()">
		<tr>
		<td class="tablerow">说明：<input type="text" name="note" size="15"  value="图片说明" onfocus="if(this.value=='图片说明') this.value='';" onblur="if(this.value=='') this.value='图片说明';"> 地址：<input type="text" name="url" size="40" value="http://" title="必须是文件真实地址" id="url" onclick="if(this.value=='http://') this.value='';">
		<input type="checkbox" name="rename" value="1" checked> 重命名
		<input type="submit" value="远程获取" id="submit">
		</td>
		</tr>
		<tr>
		<td>数字：<input type="radio" name="type" value="1" onclick="show(1)" id="type1"> 从 <input type="input" size="2" value="1" name="nf" disabled id="nf"> 到 <input type="input" size="2" value="9" name="nt" disabled id="nt">
		通配符长度：
		<select name="length" disabled id="length">
		<option value="0">选择</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		</select>&nbsp;&nbsp;
		<font color="red">&lt;=如需批量获取，请先选择类型</font>
		</td>
		</tr>
		
		<tr>
		<td>字母：<input type="radio" name="type" value="2" onclick="show(2)" id="type2"> 从 <input type="input" size="2" value="a" name="cf" disabled id="cf"> 到 <input type="input" size="2" value="z" name="ct" disabled id="ct">
		<font color="blue">Tips:</font><a href="###" onclick="alert('批量获取功能可以方便的创建多个包含共同特征的获取任务。 例如网站有10个如下的文件地址： \nhttp://www.phpcms.cn/01.jpg\nhttp://www.phpcms.cn/02.jpg \n...\nhttp://www.phpcms.cn/10.jpg\n这10个地址只有数字部分不同，如果用(*)表示不同的部分，这些地址可以写成：\nhttp://www.phpcms.cn/(*).jpg，\n同时，通配符长度指的是这些地址不同部分数字的长度，\n例如\n从1.jpg-100.jpg，那么通配符为空（不选择）\n从01.jpg－10.jpg，那通配符长度就是2，\n从001.jpg－010.jpg时通配符长度就是3。\n注意：在填写从xxx到xxx的时候，虽然是从01－10或者是001到010，但是，当您设定了通配符长度以后，就只需要填写成从1到10。')">如需要批量获取请用通配符(*)，点这里查看详细说明...</a>
		
		</td>
		</tr>

		</form>
		</table>

	</td>
  </tr>

  <?php } elseif($uptype==3) { ?>

	<script type="text/javascript">
	function show(){
		var num;
		var v = Number($('num').value);
		if(v == <?=$upnum?>) return;
		if(isNaN(v))
		{
			alert("个数必须是数字");
			return;
		}
		if(v < 1){
			alert("个数必须大于0");
			return;
		}else{
			num = v;
		}
		window.location = '?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&uptype=<?=$uptype?>&upnum='+num;
	}
	</script>
  <tr>
    <td class="tablerow">
		<table cellpadding="0" cellspacing="0" width="100%">
		<form name="upload" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&uptype=<?=$uptype?>&upnum=<?=$upnum?>&dosubmit=1" enctype="multipart/form-data">
		<tr>
		<td class="tablerow" width="330">
		<?php for($i=1; $i<=$upnum; $i++){ ?>
		<span title="第<?=$i?>个">说明：<input type="text" name="note[]" size="15" value="图片说明<?=$i?>" onfocus="if(this.value=='图片说明<?=$i?>') this.value='';" onblur="if(this.value=='') this.value='图片说明<?=$i?>';"> <input type="file" name="uploadfile[]" size="15"></span><br/>
		<?php } ?>
		</td>
		<td class="tablerow" valign="top"><input type="checkbox" name="rename" value="1" checked> 重命名
		<input type="submit" value=" 上传 "  onclick="this.value='正在上传...';"></td></form>
		<td class="tablerow" valign="top">
		同时上传<input type="text" name="num" size="1" id="num" value="<?=$upnum?>" style="color:red">个
		<input type="button" value="点击生成上传框" style="width:100px;"  title="提示:如果您已经选择了上传文件，&#10;请先上传完毕再改变同时上传个数&#10;否则需要重新选择已选文件！" onclick="show();">
		</td>
		</tr>
		</table>
	</td>
  </tr>

  <?php } ?>

</table>
</body>
</html>