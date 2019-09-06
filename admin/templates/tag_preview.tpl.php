<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align="center">标签预览</td>
  </tr>
  <tr>
    <td class="tablerow">
	<?php eval($eval); ?>
	</td>
  </tr>
<tr>
<td align="right" class="tablerow"><a href="javascript:history.back();"><font color="red">返 回 上 一 步</font></a>&nbsp;</td>
</tr>
</table>
</body>
</html>