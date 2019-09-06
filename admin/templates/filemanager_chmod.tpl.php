<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>更改<?php if($isdir) echo '目录';else echo '文件';?>属性</caption>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<tr align="center">
<td class="tablerowhighlight">您现在操作的<?php if($isdir) echo '目录';else echo '文件';?>是：<?=$fname?></td>
</tr>
<tr align="center">
  <td colspan="2">当前属性：<?=$currentperm?> &nbsp;&nbsp;更改属性为：
    <input name="chmodstr" type="text" size="10">&nbsp;&nbsp;
	<input name="fname" type="hidden" value="<?=$fname?>">
	<input name="isdir" type="hidden" value="<?=$isdir?>">
	<input name="dir" type="hidden" value="<?=$dir?>">
  <input type="submit" name="dosubmit" value="提交"></td>
</tr>
  <tr align="center">
    <td colspan="2">&nbsp;</td>
  </tr>
</form>
</table>
</body>
</html>