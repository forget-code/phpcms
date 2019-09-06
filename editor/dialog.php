<?php
require '../include/common.inc.php';
isset($do) or exit;
//$PHP_REFERER or exit;
//preg_match("/".$PHP_DOMAIN."/i",$PHP_REFERER) or exit;
$dialog = $do;
$title['hr'] = '插入水平线';
$title['link'] = '插入超级链接';
$title['fieldset'] = '插入栏目框';
$title['iframe'] = '插入网页文件';
$title['table'] = '插入表格';
$title['swf'] = '插入FLASH动画';
$title['img'] = '插入图片';
$title['mv'] = '插入媒体文件';
$title['att'] = '插入附件';
array_key_exists($dialog, $title) or exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 echo $CONFIG['charset'];?>" />
<title><?php echo $title[$dialog];?></title>
<link rel="stylesheet" type="text/css" href="<?php echo PHPCMS_PATH;?>editor/css/dialog.css" />
</head>
<body oncontextmenu="return false">
<script type="text/javascript">
var Test = parseInt(self.dialogWidth);
if(!Test) { document.body.style.display='none'; setInterval("window.close()", 1); }
function $(ID) { return document.getElementById(ID); }
</script>
<script type="text/javascript" src="<?php echo PHPCMS_PATH;?>editor/js/pickcolor.js"></script>
<?php if($dialog == 'hr') { ?>

<script type="text/javascript">
function doR()
{
	window.returnValue = $('a').value+"*"+$('b').value+"*"+$('c').value+"*"+$('d').value+"*"+$('e').value;
	window.close();
}
</script>
<table width="98%"cellspacing="2" cellpadding="2" border="0" align="center" >
<tr>
<td>

	<fieldset align="left">
	<legend>水平线参数</legend>
	<table>
	<tr> 
	<td>
	线条颜色:  <input id="a" size="6"  maxlength="7" onpropertychange="if(this.value.match('^#[0-9a-f]{6}$')){this.style.color=this.value;}" /> <img src="<?php echo PHPCMS_PATH;?>editor/images/forecolor.gif" alt="选择颜色" onclick="$('a').value=PickColor();" valign="absmiddle" />&nbsp;
	线条粗度:  <input  id="b" value="1" size="4" />
	</td>
	</tr>
	<tr> 
	<td> 页面对齐: 
	<select id="d">
	<option value="left">默认对齐</option>
	<option value="left">左对齐 </option>
	<option value="center">中对齐 </option>
	<option value="right">右对齐 </option>
	</select>
	阴影效果: 
	<select id="c">
	<option value="noshade">无</option>
	<option value="">有</option>
	</select>
	</td>
	</tr>
	<tr> 
	<td> 水平宽度:  <input id="e" value="100%" size="10" /></td>
	</tr>
	</table>
	</fieldset>

</td>
<td align="center">
	<input type="button" value="   确定   " onclick="doR();" /><br/><br/>
	<input type="button" value="   取消   " onclick="window.close();" />
</td>
</tr>
</table>

<?php } else if($dialog == 'link') {?>

<script type="text/javascript">
function doR()
{
	if($('a').value == '' || $('a').value == 'http://') 
	{
		alert('提示:地址不能为空!');
		$('a').focus();
		return;
	}
	window.returnValue = $('a').value+"*"+$('b').value;
	window.close();
}
</script>
<table width="98%"cellspacing="2" cellpadding="2" border="0" align="center" >
<tr>
<td>
	<fieldset align="left">
	<legend>超级链接参数</legend>
	<table>
	<tr> 
	<td>链接地址：</td><td><input id="a" value="http://" size="35" /></td>
	</tr>
	<tr>
	<td>目标窗口：</td>
	<td>
	<input id="b" size="6" />
	<select onchange="$('b').value=this.value;">
	<option value="">默认</option>
	<option value="_blank">新窗口</option>
	<option value="_parent">父框架</option>
	<option value="_self">相同框架</option>
	<option value="_top">当前窗口</option>
	</select>
	</td>
	</tr>
	</table>
	</fieldset>
	</td>
	<td align="center">
	<input type="button" value="   确定   " onclick="doR();" /><br/><br/>
	<input type="button" value="   取消   " onclick="window.close();" />
	</td>
  </tr>
</table>

<?php } else if($dialog == 'fieldset') { ?>

<script type="text/javascript">
function doR()
{
	window.returnValue = $('a').value+"*"+$('b').value+"*"+$('c').value+"*"+$('d').value;
	window.close();
}
</script>
<table width="98%"cellspacing="2" cellpadding="2" border="0" align="center" >
<tr>
<td>
	<fieldset align="left">
	<legend>栏目框参数</legend>
	<table>
	<tr> 
	<td>栏目：
	<select id="a">
	<option value="left">默认对齐</option>
	<option value="left">左对齐</option>
	<option value="center">中对齐</option>
	<option value="right">右对齐</option>
	</select>
	标题：
	<select id="b">
	<option value="left">默认对齐</option>
	<option value="left">左对齐</option>
	<option value="center">中对齐</option>
	<option value="right">右对齐</option>
	</select>
	</td>
	</tr>
	<tr>
	<td>边框颜色：<input id="c" size="6"  maxlength="7" onpropertychange="if(this.value.match('^#[0-9a-f]{6}$')){this.style.color=this.value;}" /> <img src="<?php echo PHPCMS_PATH;?>editor/images/forecolor.gif" alt="选择颜色" onclick="$('c').value=PickColor();" valign="absmiddle" /></td>
	</tr>
	<tr>
	<td>背景颜色：<input id="d" size="6"  maxlength="7" onpropertychange="if(this.value.match('^#[0-9a-f]{6}$')){this.style.color=this.value;}" /> <img src="<?php echo PHPCMS_PATH;?>editor/images/backcolor.gif" alt="选择颜色" onclick="$('d').value=PickColor();" valign="absmiddle" /></td>
	</tr>
	</table>
	</fieldset>
</td>
<td align="center">
	<input type="button" value="   确定   " onclick="doR();" /><br/><br/>
	<input type="button" value="   取消   " onclick="window.close();" />
</td>
</tr>
</table>

<?php } else if($dialog == 'iframe') {?>

<script type="text/javascript">
function doR()
{
	if($('a').value == '' || $('a').value == 'http://') 
	{
		alert('提示:地址不能为空!');
		$('a').focus();
		return;
	}
	window.returnValue = $('a').value+"*"+$('b').value+"*"+$('c').value+"*"+$('d').value+"*"+$('e').value+"*"+$('f').value+"*"+$('g').value;
	window.close();
}
</script>
<table width="98%"cellspacing="2" cellpadding="2" border="0" align="center" >
<tr>
<td>
	<fieldset align="left">
	<legend>网页文件参数</legend>
	<table>
	<tr> 
	<td>文件地址：</td><td><input id="a" value="http://" size="35" /></td>
	</tr>
	<tr>
	<td align="right">滚动条：</td>
	<td>
	<select id="b">
	<option value="noshade">无</option>
	<option value="yes">有</option>
	</select>&nbsp;&nbsp;
	边框线：
	<select id="c">
	<option value="0">无</option> 
	<option value="1">有</option>
	</select>
	</td>
	</tr>
	<tr>
	<td align="right">上下边距：</td>
	<td><input id="d" size="4" value="0"/>
	左右边距：<input  id="e" size="4" value="0" /></td>
	</tr>
	<tr>
	<td align="right">文件宽度：</td>
	<td><input id="f" size="4"  value="500" />
	文件高度：<input id="g" size="4"  value="400" /></td>
	</tr>
	</table>
	</fieldset>
	</td>
	<td align="center">
	<input type="button" value="   确定   " onclick="doR();" /><br/><br/>
	<input type="button" value="   取消   " onclick="window.close();" />
	</td>
  </tr>
</table>

<?php } else if($dialog == 'table') {?>

<script type="text/javascript">
function doR()
{
	if($('a').value == '' || $('a').value == 'http://') 
	{
		alert('地址不能为空');
		$('a').focus();
		return;
	}
	window.returnValue = $('a').value+"*"+$('b').value+"*"+$('c').value+"*"+$('d').value+"*"+$('e').value+"*"+$('f').value+"*"+$('g').value+"*"+$('h').value;
	window.close();
}
</script>
<table width="98%"cellspacing="2" cellpadding="2" border="0" align="center" >
<tr>
<td>
	<fieldset align="left">
	<legend>表格参数</legend>
	<table>
	<tr>
	<td width="50%">表格行数：<input id="a" value="2" size="3" /></td>
	<td width="50%">表格列数：<input id="b" value="2" size="3" /></td>
	</tr>
	<tr>
	<td width="50%">表格宽度：<input id="c" value="100%" size="3" /></td>
	<td width="50%">边框粗度：<input id="d" value="1" size="3" /></td>
	</tr>
	<tr>
	<td width="50%">表格边距：<input id="e" value="0" size="3" /></td>
	<td width="50%">表格间距：<input id="f" value="0" size="3" /></td>
	</tr>
	<tr>
	<td colspan="2">表格边框颜色：<input id="g" size="6"  maxlength="7" onpropertychange="if(this.value.match('^#[0-9a-f]{6}$')){this.style.color=this.value;}" /> <img src="<?php echo PHPCMS_PATH;?>editor/images/forecolor.gif" alt="选择颜色" onclick="$('g').value=PickColor();" valign="absmiddle" />
	</tr>
	<tr>
	<td colspan="2">表格背景颜色：<input id="h" size="6"  maxlength="7" onpropertychange="if(this.value.match('^#[0-9a-f]{6}$')){this.style.color=this.value;}" /> <img src="<?php echo PHPCMS_PATH;?>editor/images/backcolor.gif" alt="选择颜色" onclick="$('h').value=PickColor();" valign="absmiddle" />
	</td>
	</tr>
	</table>
	</fieldset>
	</td>
	<td align="center">
	<input type="button" value="   确定   " onclick="doR();" /><br/><br/>
	<input type="button" value="   取消   " onclick="window.close();" />
	</td>
  </tr>
</table>

<?php } else if($dialog == 'swf') {?>

<script type="text/javascript">
function doR()
{
	if($('a').value == '' || $('a').value == 'http://') 
	{
		alert('提示:地址不能为空!');
		$('a').focus();
		return;
	}
	if($('b').value == '') 
	{
		alert('提示:宽度不能为空!');
		$('b').focus();
		return;
	}
	if($('c').value == '') 
	{
		alert('提示:高度不能为空!');
		$('c').focus();
		return;
	}
	window.returnValue = $('a').value+"*"+$('b').value+"*"+$('c').value;
	window.close();
}
</script>
<table width="98%"cellspacing="2" cellpadding="2" border="0" align="center" >
<tr>
<td>
	<fieldset align="left">
	<legend>FLASH动画参数</legend>
	<table>
	<tr> 
	<td>地址：</td><td><input id="a" value="http://" size="35"  ondblclick="if(this.value!='' && this.value!='http://') window.open(this.value);" title="双击在新窗口打开"/></td>
	</tr>
	<tr>
	<td align="right">宽度：</td>
	<td><input id="b" size="4" />
	高度：<input id="c" size="4" /></td>
	</tr>
	<tr>
	<td align="right">上传：</td>
	<td><iframe scrolling="no" width="250" height="25" border="0" frameborder="0"  src="<?php echo PHPCMS_PATH;?>editor/upload.php?do=swf&keyid=<?php echo $keyid;?>"></iframe></td>
	</tr>
	</table>
	</fieldset>
	</td>
	<td align="center">
	<input type="button" value="   确定   " onclick="doR();" /><br/><br/>
	<input type="button" value="   取消   " onclick="window.close();" />
	</td>
  </tr>
</table>

<?php } else if($dialog == 'img') {?>

<script type="text/javascript">
function doR()
{
	if($('a').value == '' || $('a').value == 'http://') 
	{
		alert('提示:地址不能为空!');
		$('a').focus();
		return;
	}
	window.returnValue = $('a').value+"*"+$('b').value+"*"+$('c').value+"*"+$('d').value;
	window.close();
}
</script>
<table width="98%"cellspacing="2" cellpadding="2" border="0" align="center" >
<tr>
<td>
	<fieldset align="left">
	<legend>图片参数</legend>
	<table>
	<tr> 
	<td>地址：</td><td><input id="a" value="http://" size="35"  ondblclick="if(this.value!='' && this.value!='http://') window.open(this.value);" title="双击在新窗口打开"/></td>
	</tr>
	<tr>
	<td align="right">宽度：</td>
	<td><input id="b" size="4" />
	高度：<input id="c" size="4" /></td>
	</tr>
	<tr> 
	<td>说明：</td><td><input id="d" value="" size="35" /></td>
	</tr>
	<tr>
	<td align="right">上传：</td>
	<td><iframe scrolling="no" width="250" height="25" border="0" frameborder="0"  src="<?php echo PHPCMS_PATH;?>editor/upload.php?do=img&keyid=<?php echo $keyid;?>"></iframe></td>
	</tr>
	</table>
	</fieldset>
	</td>
	<td align="center">
	<input type="button" value="   确定   " onclick="doR();" /><br/><br/>
	<input type="button" value="   取消   " onclick="window.close();" />
	</td>
  </tr>
</table>

<?php } else if($dialog == 'mv') {?>

<script type="text/javascript">
function doR()
{
	if($('a').value == '' || $('a').value == 'http://') 
	{
		alert('提示:地址不能为空!');
		$('a').focus();
		return;
	}
	if($('b').value == '') 
	{
		alert('提示:宽度不能为空!');
		$('b').focus();
		return;
	}
	if($('c').value == '') 
	{
		alert('提示:高度不能为空!');
		$('c').focus();
		return;
	}
	window.returnValue = $('a').value+"*"+$('b').value+"*"+$('c').value;
	window.close();
}
</script>
<table width="98%"cellspacing="2" cellpadding="2" border="0" align="center" >
<tr>
<td>
	<fieldset align="left">
	<legend>媒体参数</legend>
	<table>
	<tr> 
	<td>地址：</td><td><input id="a" value="http://" size="35"  ondblclick="if(this.value!='' && this.value!='http://') window.open(this.value);" title="双击在新窗口打开"/></td>
	</tr>
	<tr>
	<td align="right">宽度：</td>
	<td><input id="b" size="4" />
	高度：<input id="c" size="4" /></td>
	</tr>
	<tr>
	<td align="right">上传：</td>
	<td><iframe scrolling="no" width="250" height="25" border="0" frameborder="0"  src="<?php echo PHPCMS_PATH;?>editor/upload.php?do=mv&keyid=<?php echo $keyid;?>"></iframe></td>
	</tr>
	</table>
	</fieldset>
	</td>
	<td align="center">
	<input type="button" value="   确定   " onclick="doR();" /><br/><br/>
	<input type="button" value="   取消   " onclick="window.close();" />
	</td>
  </tr>
</table>

<?php } else if($dialog == 'att') {?>

<script type="text/javascript">
function doR()
{
	if($('a').value == '' || $('a').value == 'http://') 
	{
		alert('提示:地址不能为空!');
		$('a').focus();
		return;
	}
	window.returnValue = $('a').value+"*"+$('b').value;
	window.close();
}
</script>
<table width="98%"cellspacing="2" cellpadding="2" border="0" align="center" >
<tr>
<td>
	<fieldset align="left">
	<legend>附件参数</legend>
	<table>
	<tr> 
	<td>地址：</td><td><input id="a" value="" size="35" ondblclick="if(this.value!='' && this.value!='http://') window.open(this.value);" title="双击在新窗口打开" /></td>
	</tr>
	<tr> 
	<td>说明：</td><td><input id="b" value="" size="35" /></td>
	</tr>
	<tr>
	<td align="right">上传：</td>
	<td><iframe scrolling="no" width="250" height="25" border="0" frameborder="0"  src="<?php echo PHPCMS_PATH;?>editor/upload.php?do=att&keyid=<?php echo $keyid;?>"></iframe></td>
	</tr>
	</table>
	</fieldset>
	</td>
	<td align="center">
	<input type="button" value="   确定   " onclick="doR();" /><br/><br/>
	<input type="button" value="   取消   " onclick="window.close();" />
	</td>
  </tr>
</table>

<?php } ?>

</body>
</html>