<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script type="text/javascript">
function setcount()
{
	var str='<p>';
	if (window.up.count.value<=0||window.up.count.value>20)
		window.up.count.value=10;
	for (i=1;i<=window.up.count.value;i++)
	{
		str+=' 文件'+i+': <input type="file" name="uploadfiles[]" size="60%"><p>';
		window.ups.innerHTML=str+'<p>';
	}
}
</script>
<body>
<?=$menu?>
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>多文件上传</th>
  </tr>
<form method="post" name="up" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" enctype="multipart/form-data">
<tr align="center">
<td class="tablerowhighlight"> <div align="left">1.上传的文件个数(最大值 20)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="tablerow">
    <input name="count" type="text" size="8" value="6">&nbsp;
    <input type="button" onclick="setcount();" value="设定">
</span></div></td>
</tr>
<tr align="center">
  <td  class="tablerowhighlight" colspan="2"><div align="left">2.文件全部覆盖上传(默认:不覆盖)
    <input type="checkbox" name="overfile" value="1">
  </div></td>
</tr>
  <tr align="center">
    <td  class="tablerowhighlight" colspan="2"><div align="left">3.确认文件上传路径为：<a href="javascript:history.go(-1)" title="点击返回重新选择上传路径"><font color="blue"><?=$currentdir?></font></a></div></td>
  </tr>
  <tr align="center">
    <td class="tablerow" colspan="2" align="left">
	<div id=ups>  文件1: <input type="file" name="uploadfiles[]" size="60%"></div></td>
  </tr>
  <tr align="center">
    <td class="tablerow" colspan="2" align="left">
    <input type="hidden" name="currentdir" value="<?=$currentdir?>">
    <input type="hidden" name="dir" value="<?=$dir?>">
	&nbsp;&nbsp;<input name="dosubmit" type="submit"  value=" 上 传 ">
	&nbsp;&nbsp;<input name="reset" type="reset"  value=" 重 置 "></td>
  </tr>
  <tr align="center">
    <td class="tablerow" colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr align="center">
    <td class="tablerow" colspan="2" align="left">Tips:没有浏览选择文件的项将不上传，默认最大只能同时上传20个文件，且同时上传的文件总大小不宜过大！</td>
  </tr>
</form>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
</body>
</html>