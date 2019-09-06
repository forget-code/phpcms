<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script language='JavaScript'>
function CheckForm()
{
	if($F('formitem')=='')
	{
		alert('请填写完整！');
		$('formitem').focus();
		return false;
	}
}
</script>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>表单向导：第一步 收集表单项目</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add">
<input type="hidden" name='step' value="2" />
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="70" align="left" class="tablerow"><strong>表单项目：</strong>各个项目间用英文逗号,分开</td>
<td class="tablerow"  align="left"><textarea name="formitem"  id='formitem' cols="60" rows="6">姓名,性别,年龄,地址,内容,图片</textarea></td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><input name="dosubmit" type="submit" size="4" value="下 一 步" onclick="return CheckForm();"></td>
  </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%"  class="tableborder">
  <tr>
    <th colspan=7>提示信息</th>
  </tr>
    <tr>
    <td class="tablerow">
&nbsp;&nbsp;1、表单向导自动生成各种样式的表单，方便从后台插入其他页面中，用于与用户之间搜集各种交互式信息。</br> 
&nbsp;&nbsp;2、可以选择发送到数据库和特定的邮箱内。</br></br></td>
  </tr>
</table>
</form>
</body>
</html>