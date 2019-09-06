<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
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
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>添加自定义标签</th>
  </tr>
  <form name="myform" id="myform" method="post" action="?file=mytag&action=add&channelid=<?=$channelid?>&function=phpcms_mytag" onsubmit="return doCheck();">
    <tr> 
      <td width="30%" class="tablerow"><b>自定义标签名</b><font color="red">*</font></td>
      <td width="70%" class="tablerow"><input name="tagname" type="text" size="20"> 可以用中文</td>
    </tr>
   <tr>
    <td class="tablerow"><b>自定义标签说明</b></td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="60" /></td>
	</tr>
    <tr> 
      <td class="tablerow"><b>自定义标签内容</b><font color="red">*</font>
	  <br>
	  自定义标签内容中可以插入html代码，也可以插入多个函数标签或者变量标签，具有非常强的灵活性
	  </td>
      <td class="tablerow">
<textarea name="content" id='content' style="width: 100%; height: 400px"></textarea>
<?=editor('content','phpcms','600','400')?>
</td>
    </tr>                      
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
	     <input name="tag_config[func]" type="hidden" value="<?=$function?>">
        <input type="submit" name="dosubmit" value=" 确 定 "> &nbsp;
        <input type="reset" name="reset" value=" 重新填写 ">
      </td>
    </tr>
  </form>
</table>
</body>
</html>   