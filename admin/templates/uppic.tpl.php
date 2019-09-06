<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header','phpcms');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td ></td>
  </tr>
</table>
<script type="text/javascript">
function doCheck() {
	if(upload.uploadfile.value == '') {
		alert('请选择文件!');
		return false;
	}
	return true;
}
</script>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th>图片上传</th>
  </tr>
	<form name="upload" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&uploadtext=<?=$uploadtext?>&type=<?=$type?>&width=<?=$width?>&height=<?=$height?>" enctype="multipart/form-data" onsubmit="return doCheck();">
  <tr>
     <td class="tablerow" height="30">
             <input name="uploadfile" type="file" size="15" onchange="upload.previewpic.src=upload.uploadfile.value">
             <input type="hidden" name="oldname">
             <input type="hidden" name="rename" value="<?=$rename?>">
             <input type="hidden" name="MAX_FILE_SIZE" value="<?=$maxfilesize?>"> 
             <input type="submit" name="dosubmit" value=" 上传 ">
			 <input type="button" name="submit" value=" 预览 " onclick="if(upload.uploadfile.value!='') upload.previewpic.src=upload.uploadfile.value">
			 </td>
   </tr>
  <?php if($type=="thumb"){ ?>
  <tr>
     <td class="tablerow" height="30">
			 缩略图宽度：<input name="newwidth" type="text" size="5" value="<?=$width?>"> px 
             高度：<input name="newheight" type="text" size="5" value="<?=$height?>"> px 
			 </td>
   </tr>
  <tr>
     <td class="tablerow">
			 说明：系统将按照指定的高度和宽度生成缩略图 
			 </td>
   </tr>
   <?php }elseif($type=="water"){ ?>

   <?php if($PHPCMS['water_type']==1){ 
	   $poss = array(1=>"顶端居左",2=>"顶端居中",3=>"顶端居右",4=>"中部居左",5=>"中部居中",6=>"中部居右",7=>"底端居左",8=>"底端居中",9=>"底端居右");
	   ?>
  <tr>
     <td class="tablerow">
			 水印文字：<input name="water_text" type="text" size="34" value="<?=$PHPCMS['water_text']?>"> <br>
             文字颜色：<input name="water_fontcolor" type="text" size="7" value="<?=$PHPCMS['water_fontcolor']?>">
			 <?=color_select("fontcolor","颜色",$PHPCMS['water_fontcolor'],0," onchange='upload.water_fontcolor.value=this.value'") ?>
			 文字大小：<input name="water_fontsize" type="text" size="5" value="<?=$PHPCMS['water_fontsize']?>"> <br> 
             水印位置：<select name="water_pos">
			        <?php foreach($poss as $id=>$pos){ ?>
			         <option value="<?=$id?>" <?php if($PHPCMS['water_pos']==$id){ ?>selected<?php } ?>><?=$pos?></option>
					 <?php } ?>
			       </select>
			 </td>
   </tr>
   <?php }elseif($PHPCMS['water_type']==2){ ?>
			 水印图片：<input name="water_image" type="text" size="5" value="<?=$PHPCMS['water_image']?>"> px 
   <?php } ?>
  <tr>
     <td class="tablerow">
			 说明：系统将按照指定的条件给图片加水印 
			 </td>
   </tr>
   <?php } ?>
  <tr>
     <td class="tablerow">
<img id="previewpic" onload="setpicWH(this,300,300)">
<script>
if(window.opener.myform.<?=$uploadtext?>.value!="")
{
	upload.oldname.value = window.opener.myform.<?=$uploadtext?>.value;
    upload.previewpic.src = "<?=PHPCMS_PATH?>"+window.opener.myform.<?=$uploadtext?>.value;
}
else
{
    upload.previewpic.src = "<?=PHPCMS_PATH?>images/nopic.gif";
}
</script>
			 </td>
   </tr>
	</form>
</table>
</body>
</html>