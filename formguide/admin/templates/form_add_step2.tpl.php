<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script language='JavaScript'>
function CheckForm(i)
{
	for(var j=0;j<i;j++)
	{
		var se=j+1;
		if(($F('formtype'+se)=='3' || $F('formtype'+se)=='4' ||$F('formtype'+se)=='5') && $F('list'+se)=='')
		{
			alert('检测到有备选值项未填写完整！');
			$('list'+se).focus();
			return false;
			break;
		}		
	}
	return true;
	
}
function previewform(objIndex,value)
{
	switch(value)
	{
		case '1'://单行文本
		$('preview'+objIndex).innerHTML = "<input type='text' />";
		$('list'+objIndex).style.color="#999999";
		$('list'+objIndex).disabled = true;
		$('list'+objIndex).rows = 2;
		$('list'+objIndex).value = '该表单类型不需要提供备选值';
		break;
		
		case '2'://多行文本
		$('preview'+objIndex).innerHTML = "<textarea cols='18' rows='2'></textarea>";
		$('list'+objIndex).style.color="#999999";
		$('list'+objIndex).disabled = true;
		$('list'+objIndex).rows = 2;
		$('list'+objIndex).value = '该表单类型不需要提供备选值';
		break;
		
		case '3'://单选框
		$('preview'+objIndex).innerHTML = "<input name='test'"+value+" type='radio' />是&nbsp;&nbsp;<input name='test'"+value+" type='radio' checked/>否";
		$('list'+objIndex).style.color="#000000";
		$('list'+objIndex).disabled = false;
		$('list'+objIndex).value = '';
		break;
		
		case '4'://复选框
		$('preview'+objIndex).innerHTML = "<input type='checkbox' checked />语文&nbsp;<input type='checkbox' />数学&nbsp;<input type='checkbox'  checked/>英语&";
		$('list'+objIndex).style.color="#000000";
		$('list'+objIndex).disabled = false;
		$('list'+objIndex).rows = 3;
		$('list'+objIndex).value = '';
		break;
		
		case '5'://下拉菜单
		$('preview'+objIndex).innerHTML = "<select><option>下拉1</option><option>下拉2</option></select>";
		$('list'+objIndex).style.color="#000000";
		$('list'+objIndex).disabled = false;
		$('list'+objIndex).rows = 3;
		$('list'+objIndex).value = '';
		break;
		
		case '6'://浏览上传文件
		$('preview'+objIndex).innerHTML = "<input type='file' />";
		$('list'+objIndex).style.color="#999999";
		$('list'+objIndex).disabled = true;
		$('list'+objIndex).rows = 2;
		$('list'+objIndex).value = '该表单类型不需要提供备选值';
		break;
		
		default:
		$('preview'+objIndex).innerHTML = "<input type='text' />";
		break;
	}
}
</script>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>表单向导：第二步 选择各项目对应表单类型</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add">
<input type="hidden" name='step' value="3" />
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="5%" class="tablerowhighlight">序号</td>
<td width="10%"  class="tablerowhighlight">名称</td>
<td width="10%"  class="tablerowhighlight">是否必填</td>
<td width="20%"  class="tablerowhighlight">表单类型</td>
<td width="25%"  class="tablerowhighlight">预设备选值(一行一个)</td>
<td width="30%"  class="tablerowhighlight">样式预览</td>
</tr>
<?php
foreach($items as $i=>$item)
{
?>
<tr class="tablerow" align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td><?=++$i?></td>
<td><?=$item?><input type="hidden" name='itemname[<?=$i?>]' value="<?=$item?>" /></td>
<td>
<select name="ismust[<?=$i?>]"><option  value="1">√</option><option  value="0" selected>×</option></select>
</td>
<td>
	<select name="formtype[<?=$i?>]" id="formtype<?=$i?>" onchange="previewform(<?=$i?>,this.value);">
	<option value="1" selected>单行文本</option>
	<option value="2">多行文本</option>
	<option value="3">单选框</option>
	<option value="4">复选框</option>
	<option value="5">下拉菜单</option>	
	<option value="6">浏览上传文件</option>
	</select>
</td>
<td><textarea name='list[<?=$i?>]'  id="list<?=$i?>" cols='30' rows='2' style="font-size:8pt;color:#999999" disabled>该表单类型不需要提供备选值</textarea></td>
<td id="preview<?=$i?>"><input type="text" /></td>
</tr>
<?php
}
?>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><input name="sss" type="button" value="上 一 步" onclick="history.go(-1);">&nbsp;&nbsp;&nbsp;&nbsp;<input name="dosubmit" type="submit"  value="下 一 步" onclick="return CheckForm(<?=$i?>);"></td>
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