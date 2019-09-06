<?php include admintpl('header');?>

<script type="text/javascript" src="<?=PHPCMS_PATH?>fckeditor/fckeditor.js"></script>
<script type="text/javascript">
	var editorBasePath = '<?=PHPCMS_PATH?>fckeditor/';
	var ChannelId = <?=$channelid?> ;
</script>

<script type="text/javascript">
window.onload = function()
{
	var oFCKeditor = new FCKeditor('content') ;
	oFCKeditor.BasePath	= editorBasePath ;
	oFCKeditor.ReplaceTextarea() ;
}
</script>

<?=$menu?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/MyCalendar.js"></script> 
<script language = 'JavaScript'>
function ruselinkurl(){
  if(document.myform.uselinkurl.checked==true){
    document.myform.linkurl.disabled=false;
  }else{
    document.myform.linkurl.disabled=true;
  }
}

// 表单提交检测
function doCheck(){

	// 检测表单的有效性
	// 如：标题不能为空，内容不能为空，等等....
	if (document.myform.catid.value=='0'){
		alert('指定的栏目不允许添加图片！只允许在其子栏目中添加图片。');
		document.myform.catid.focus();
		return false;
	}
	if (myform.title.value=="") {
		alert("请输入标题");
		document.myform.title.focus();
		return false;
	}

}
</script>


<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>&pictureid=<?=$pictureid?>&submit=1" method="post" name="myform" onsubmit="return doCheck();">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>图片退稿</th>
  </tr>
    <tr> 
      <td class="tablerow">图片标题</td>
      <td class="tablerow"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=preview&channelid=<?=$channelid?>&catid=<?=$picture[catid]?>&pictureid=<?=$pictureid?>" target="_blank" title="预览图片"><?=$picture[title]?></td>
    </tr>
    <tr> 
      <td class="tablerow">所属栏目</td>
      <td class="tablerow"><?=$_CAT[$picture[catid]][catname]?></td>
    </tr>
	<tr> 
      <td class="tablerow">会员名称</td>
      <td class="tablerow"><?=$picture[username]?><input name='username' type='hidden' value='<?=$picture[username]?>'> </td>
    </tr>
    <tr> 
      <td class="tablerow">短信通知</td>
      <td width="90%" class="tablerow">
	  <input name='ifpm' type='radio' id='ifpm' value='1'checked> 是
	  <input name='ifpm' type='radio' id='ifpm' value='0'> 否
	  <input name='ifemail' type='checkbox' id='ifemail' value='1'> 同时发送到该会员电子邮箱
	  </td>
    </tr>
    <tr> 
      <td class="tablerow">短信标题</td>
      <td class="tablerow"><input name="title" type="text" id="title" size="60" value="抱歉!您提交的图片'<?=$picture[title]?>'被退回"></td>
    </tr>
    <tr> 
      <td class="tablerow">短信内容 </td>
      <td class="tablerow">
        <textarea name="content" style="display:none"><?=htmlspecialchars($_CHA['emailofreject'])?></textarea>
         </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
	   <input type="hidden" name="referer" value="<?=$referer?>" >
        <input type="submit" name="Submit" value=" 确定 " > &nbsp;
        <input type="reset" name="Reset" value=" 清除 ">
     </td>
    </tr>
  </form>
</table>
</body>
</html>