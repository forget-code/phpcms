<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script language='JavaScript'>
function CheckForm()
{
	if($F('brand_name')=='')
	{
		alert('请填写品牌名称！');
		$('brand_name').focus();
		return false;
	}
}
</script>
<body>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>编辑默认选项</th>
	  </tr>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td  colspan="4">Tips:一行一个，请在添加信息前设置完全相应选项</td>
</tr>

  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=option" name="myform">
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td width="25%" class="tablerow">房屋朝向：</td>
<td class="tablerow" align="left"><textarea name='towards' id='towards' rows='4' cols='60'><?=$towardsstr?>
</textarea>
</td>
</tr>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td width="25%" class="tablerow">装修程度：</td>
<td class="tablerow" align="left"><textarea name='decorate' id='decorate' rows='4' cols='60'><?=$decoratestr?>
</textarea></td>
</tr>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="25%" class="tablerow">房屋类型：</td>
<td class="tablerow" align="left"><textarea name='housetype' id='housetype' rows='4' cols='60'><?=$housetypestr?></textarea></td>
</tr>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
  <td class="tablerow">基础设施：</td>
  <td class="tablerow" align="left"><textarea name='infrastructure' id='infrastructure' rows='4' cols='60'><?=$infrastructurestr?>
  </textarea></td>
</tr>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
  <td class="tablerow">室内设施：</td>
  <td class="tablerow" align="left"><textarea name='indoor' id='indoor' rows='4' cols='60'><?=$indoorstr?>
  </textarea></td>
</tr>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
  <td class="tablerow">周边配套：</td>
  <td class="tablerow" align="left"><textarea name='peripheral' id='peripheral' rows='4' cols='60'><?=$peripheralstr?>
  </textarea></td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><input name="submit" type="submit" size="4" value="确定" onclick="return CheckForm();"> </form></td>
  </tr>
</table>

</body>
</html>