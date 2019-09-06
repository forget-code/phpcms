<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align="center"> 奖励记录清理 </td>
  </tr>
<form method="get" name="search">
  <tr>
    <td class="tablerow" align="center">
	<input type="hidden" name="mod" value="<?=$mod?>">
	<input type="hidden" name="file" value="<?=$file?>">
<?=date_select('begindate', $begindate)?>
 &nbsp;&nbsp; <input name='dosubmit' type='submit' value=' 清除之前记录 '>
 </td>
  </tr>
</form>
</table>
</body>
</html>