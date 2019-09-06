<?php 
defined('IN_PHPCMS') or exit('Access Denied');

return <<< END
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder">
   <tr>
	   <td class="submenu" align="center">
		 <table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
		  <tr>
			<td class="submenu" width="30%"><a href="#" onclick="history.back(-1);"><img src="admin/skin/images/backward.gif" border="0"></a>&nbsp;<a href="#" onclick="history.go(1);"><img src="admin/skin/images/forward.gif" border="0"></a>&nbsp;<a href="#" onclick="window.location.reload()"><img src="admin/skin/images/reload.gif" border="0"></a>
			</td>
			<td class="submenu" align="center">$menuname</td>
			<td class="submenu" width="10%" align="right"><a href="http://help.phpcms.cn/help.php?mod=$mod&file=$file&action=$action" target="_blank"><img src="admin/skin/images/help.gif" border="0"></a>
			</td>
		  </tr>
		</table>
	   </td>
   </tr>
   <tr>
	   <td class="tablerow">$menu</td>
   </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
END;
?>