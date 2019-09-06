<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<?=$menu?>

<table cellpadding="2" cellspacing="1" class="tableborder"><form method="post" name="myform">
<tr>
	<th colspan=14><font color="white">广告代码调用</font></th>
</tr>
<TR>
	<TD>效果查阅:</TD>
	<TD>&nbsp;<SCRIPT LANGUAGE="JavaScript" src="<?=PHPCMS_PATH?>ads/viewads.php?id=<?=$adsid?>"></SCRIPT></TD>
</TR>
<TR>
	<TD>代码查阅:</TD>
	<TD>&nbsp;<TEXTAREA ROWS="10" COLS="75" name="jscode"><SCRIPT LANGUAGE="JavaScript" src="<?=PHPCMS_PATH?>ads/viewads.php?id=<?=$adsid?>"></SCRIPT></TEXTAREA>&nbsp;<INPUT TYPE="button" onclick="document.all.jscode.select();document.execCommand('copy');" value=" 复制代码至剪贴板 "></TD>
</TR>
</TABLE>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
</body>
</html>