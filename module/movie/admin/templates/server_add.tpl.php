<?php defined("IN_PHPCMS") or exit("Access Denied");
include admintpl("header");
?>
<body>
<script LANGUAGE="javascript">
<!--
function Check() {
	if ($F('subject')=="")
	{
		alert("请输入播放器名称");
		Field.clear('subject')
		Field.focus('subject');
		return false
	}
	  if ($F('code')=="")
	{
		alert("请输入播放器代码");
		Field.clear('code')
		Field.focus('code');
		return false
	}
     return true;
}
//-->
</script>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td><?=$menu?></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr align="center">
    <th colspan=3>添加影片服务器</th>
  </tr>
<form method="post" name="myform" onsubmit="return Check()" action="?mod=movie&file=server&action=add&channelid=<?=$channelid?>">
<tr >
<td class="tablerow" align="right">服务器描述：</td>
<td class="tablerow"><input name="servername" size="30" id="servername" maxlength="30" type="text">
</td>
</tr>
<tr >
<td class="tablerow" align="right">在线服务器地址：</td>
<td class="tablerow"><input name="onlineurl" size="60" id="onlineurl" type="text"> 例如：http://online99.do.com/
</td>
</tr>
<tr >
<td class="tablerow" align="right">下载服务器地址：</td>
<td class="tablerow"><input name="downurl" size="60" id="downurl"  type="text"> 例如：http://downserver.do.com/down/
</td>
</tr>
<tr >
<td class="tablerow" align="right">ISAPI服务器地址：</td>
<td class="tablerow"><input name="isapi" size="60" id="isapi"  type="text" > 例如：http://do.com/.h2b?httpurl2bobo?
</td>
</tr>
<tr >
<td class="tablerow" align="right">最高上限人数：</td>
<td class="tablerow"><input name="maxnum" size="6" id="maxnum" maxlength="6" type="text"  value="0"> 
0 表示不限制
</td>
</tr>

<tr >
<td class="tablerow" align="right"></td>
<td class="tablerow">
	<input type="submit" value=" 确定 " name="submit">
	 <input type="reset" value=" 清除 " name="reset">
</td>
</tr>
</form>
</table><BR>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	<font color="#ff0000">1、ISAPI服务器地址是专门为获取bobo播放地址用。<br/>
	</td>
  </tr>
</table>
</body>
</html>