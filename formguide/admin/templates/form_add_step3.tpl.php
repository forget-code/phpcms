<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script language='JavaScript'>
function CheckForm()
{
	if($F('formname')=='')
	{
		alert('请填写表单名称！');
		$('formname').focus();
		return false;
	}
	if($F('email')!='' && !Common.isemail($F('email')))
	{
		alert('您填写的email不合规范！');
		$('email').focus();
		return false;
	}
}
</script>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>表单向导：第三步 生成表单</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add">
<input type="hidden" name='step' value="4" />
<input type="hidden" name='formitems' value="<?=$itemstr?>" />
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="30%" align="left" class="tablerow"><strong>表单名称：</strong></br>该名称可直接用于构建标签在其他页面上显示，应唯一<br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
<td class="tablerow"  align="left"><input type="text" name="formname" size="25" id="formname" />&nbsp;&nbsp;<input type="button" value=" 检测重名 " onclick="Dialog('?mod=<?=$mod?>&file=tag&action=checkname&tagname='+$('formname').value+'','','300','40','no')"> <br/></td>
</tr>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="30%" align="left" class="tablerow"><strong>表单描述：</strong></br>简洁地描述该表单的作用</td>
<td class="tablerow"  align="left"><textarea name="formintroduce" id="formintroduce"  cols="30" rows="3" /></textarea></td>
</tr>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="30%" align="left" class="tablerow"><strong>将用户提交的结果同时发送到Email：</strong></br>可以不填，自动记录到数据库</td>
<td class="tablerow"  align="left"><input type="text" name="email" size="25" id="email" /></td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><input name="dosubmit" type="submit" size="4" value="完 成" onclick="return CheckForm();"></td>
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