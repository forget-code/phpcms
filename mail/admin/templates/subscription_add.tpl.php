<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script language='JavaScript'>
function CheckForm()
{
	if($F('period')=='')
	{
		alert('请填写期刊数！');
		$('period').focus();
		return false;
	}
	if($F('typeid')==0)
	{
		alert('请选择订阅分类！');
		$('typeid').focus();
		return false;
	}
	if($F('title')=='')
	{
		alert('请填写邮件标题！');
		$('title').focus();
		return false;
	}	
}
</script>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>邮件内容添加</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add">
<input type="hidden" name='mail' value="<?=$mail?>" />
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="16%" align="left" class="tablerow">期刊数：</td>
<td class="tablerow"  align="left">第<input type="text" name="period" id="period" style="text-align:center" size="3" <?php if(isset($period)) echo "value=\"".$period."\""; ?> />  期&nbsp;<font color="Red">*</font></td>
</tr>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="16%" align="left" class="tablerow">所属订阅分类：</td>
<td class="tablerow"  align="left"><?=$type_select?> &nbsp;<font color="Red">*</font></td>
</tr>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="16%" align="left" class="tablerow">邮件标题：</td>
<td class="tablerow"  align="left"><input type="text" name="title" id="title" size="50" />&nbsp;<font color="Red">*</font></td>
</tr>

<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td width="16%" align="left" class="tablerow"  valign="top">邮件内容：</td>
<td class="tablerow" align="left"><textarea name="content"  id='content' cols="60" rows="16"></textarea><?=editor('content','phpcms',600,400)?>&nbsp;<font color="Red">*</font></td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><input name="submit" type="submit" size="4" value="确定" onclick="return CheckForm();"></td>
  </tr>
</table>
</form>
</body>
</html>