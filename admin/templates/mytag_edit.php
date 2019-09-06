<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

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

<script language=JavaScript>

// 表单提交检测
function doCheck(){
	if (myform.tagname.value=="") {
		alert("请输入自定义标签名称！");
		myform.tagname.focus();
		return false;
	}
	if (document.myform.type[0].checked && frames.message.document.body.innerHTML=="") {
		alert("请输入自定义标签内容！");
		return false;
	}
	if (document.myform.type[1].checked && document.myform.content.value=="") {
		alert("请输入自定义标签内容！");
		myform.content.focus();
		return false;
	}
}
</script>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>修改自定义标签</th>
  </tr>
  <form name="myform" id="myform" method="post" action="?mod=<?=$mod?>&file=mytag&action=edit&channelid=<?=$channelid?>&tagid=<?=$tagid?>&submit=1" onsubmit="return doCheck();">
    <tr> 
      <td width="30%" class="tablerow"><b>自定义标签名</b><font color="red">*</font><br>必须由英文字母、数字和下划线组成</td>
      <td width="70%" class="tablerow"><input name="tagname" type="text" size="20" value="<?=$tagname?>" disabled></td>
    </tr>
   <tr>
    <td class="tablerow"><b>自定义标签说明</b><br>可以用中文</td>
    <td class="tablerow"><textarea name="introduce" cols='60' rows='4'><?=$introduce?></textarea></td></tr>
    <tr> 
      <td class="tablerow"><b>自定义标签内容</b><font color="red">*</font>
	  	  <br>
	  自定义标签内容中可以插入html代码，也可以插入多个函数标签或者变量标签，具有非常强的灵活性
	  </td>
      <td class="tablerow">
<textarea name="content" style="width: 100%; height: 400px"><?=$content?></textarea>
</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>立即启用</b></td>
      <td class="tablerow">
          <input name='passed' id='passed' type='radio' value='1' <?php if($passed){?> checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;<input name='passed' id='passed' type='radio' value='0' <?php if(!$passed){?> checked <?php } ?>> 否
      </td>
    </tr>                       
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
        <input type="submit" name="Submit" value=" 确 定 "> &nbsp;
        <input type="reset" name="Reset" value=" 重新填写 ">
      </td>
    </tr>
  </form>
</table>
</body>
</html>   