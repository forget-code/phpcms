<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>

<form action="" method="post" name="myform" >
<BR>
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=3>企业LOGO、Banner 管理</th>
<tr>
<td valign="top" colspan=2 class="tablerowhighlight">
企业形象图片
</td>
</tr>
<tr> 
	<td class="tablerow" width="100">Logo</td>
		<td class="tablerow" >
		<input name="logo" type="text" id="logo" size="53" value="<?=$logo?>">
		<input type="hidden" name="logotemp" id="logotemp" value="" onpropertychange="logourls();">
		<input type="button" value="上传图片" onclick="javascript:openwinx('<?=$SITEURL?>/upload.php?keyid=yp&uploadtext=logotemp&type=thumb&width=300&height=200','upload','350','350')">
	</td>
</tr>
<tr>
<td colspan=2 id='showlogo'>
<?php if($logo) echo "<img src=\"$SITEURL/$logo\"";?>
</td>
</tr>
<tr>
<td valign="top" colspan=2 class="tablerowhighlight">
企页主页顶部背景图片 ，尺寸大小为 760*86之间
</td>
</tr>
<tr> 
	<td class="tablerow" width="100">Banner </td>
		<td class="tablerow" title="温馨提示：按照采用的风格设置Banner，能使页面更加美观">
		<input name="banner" type="text" id="banner" size="53" value="<?=$banner?>">
		<input type="hidden" name="temp" id="temp" value="" onpropertychange="bannerurls();">
		<input type="button" value="上传图片" onclick="javascript:openwinx('<?=$SITEURL?>/upload.php?keyid=yp&uploadtext=temp&type=thumb&width=760&height=86','upload','350','350')">
	</td>
</tr>
<tr>
<td colspan=2 id='showpic'>
<?php if($banner) echo "<img src=\"$SITEURL/$banner\"";?>
</td>
</tr>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1" >
  <tr>
    <td width="40%">
	</td>
    <td height="25">
	<input type="submit" name="dosubmit" value=" 确认修改 " />
	</td>
  </tr>
</table>
</form>
<script type="text/javascript">
<!--
function bannerurls() {
	if($('temp').value != '') {
	$('showpic').innerHTML="<img src=<?=$SITEURL?>/"+$('temp').value+" border=0>";
	$('banner').value=$('temp').value;
	}
}
function logourls() {
	if($('logotemp').value != '') {
	$('showlogo').innerHTML="<img src=<?=$SITEURL?>/"+$('logotemp').value+" border=0>";
	$('logo').value=$('logotemp').value;
	}
}
//-->
</script>

</body>
</html>