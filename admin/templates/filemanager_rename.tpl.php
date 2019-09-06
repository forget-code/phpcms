<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption><?php if($isdir) echo '目录';else echo '文件';?>重命名</caption>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<tr>
<th>您现在对<?php if($isdir) echo '目录';else echo '文件';?>：<?=$fname?>进行重命名操作</th>
</tr>
<tr>
  <td>更名为：
    <input name="newname" type="text" size="20" value="<?=basename($fname)?>">&nbsp;&nbsp;
	<input name="fname" type="hidden" value="<?=$fname?>">
	<input name="isdir" type="hidden" value="<?=$isdir?>">
	<input name="dir" type="hidden" value="<?=$dir?>">
  <input type="submit" name="dosubmit" value="提交" /></td>
</tr>
  <tr>
    <td colspan="2">&nbsp;    </td>
  </tr>
</form>
</table>
</body>
</html>