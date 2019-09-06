<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script language='JavaScript'>
function CheckForm()
{
	if($F('att_name')=='')
	{
		alert('请添加属性名称！');
		$('att_name').focus();
		return false;
	}
	if($F('att_type')=='1' && $F('att_values')=="")
	{
		alert('您选择了列表方式生成属性值，但没有提供备选值列表！');
		$('att_values').focus();
		return false;
	}
	if($F('pro_id')=='0')
	{
		alert('请选择该属性所属商品类型！');
		$('pro_id').focus();
		return false;
	}
}
</script>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>修改商品属性</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=edit">
<input type="hidden" name='att_id' value="<?=$att_id?>" />
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="30%" class="tablerow">商品属性名称：</td>
<td class="tablerow"  align="left"><input type="text" name="att[att_name]" id="att_name" size="25" value="<?=$att['att_name']?>"/>&nbsp;<font color="Red">*</font></td>
</tr>

<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td width="30%" class="tablerow">所属商品类型：</td>
<td class="tablerow" align="left"><?=$property_select?>&nbsp;<font color="Red">*</font></td>
</tr>

<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="30%" class="tablerow">属性值录入方式：</td>
<td class="tablerow" align="left"><input type="radio" name="att[att_type]" value="0" <? if($att['att_type']==0) echo "checked";?>  />          
          单行文本
          <input type="radio" name="att[att_type]" value="1" id="att_type" <? if($att['att_type']==1) echo "checked";?> />
          从下面的列表中选择（一行一个备选值）
		  <input type="radio" name="att[att_type]" value="2" <? if($att['att_type']==2) echo "checked";?> />          
          多行文本框&nbsp;<font color="Red">*</font></td>
</tr>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="30%" class="tablerow">备选值列表：</td>
<td class="tablerow" align="left"><textarea name="att[att_values]" cols="30" rows="5"><?=$att['att_values']?></textarea></td>
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