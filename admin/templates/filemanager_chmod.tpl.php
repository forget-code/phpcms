<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>更改<?php if($isdir) echo '目录';else echo '文件';?>属性</th>
  </tr>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<tr align="center">
<td class="tablerowhighlight">您现在操作的<?php if($isdir) echo '目录';else echo '文件';?>是：<?=$fname?></td>
</tr>
<tr align="center">
  <td class="tablerow" colspan="2">当前属性：<?=$currentperm?> &nbsp;&nbsp;更改属性为：
    <input name="chmodstr" type="text" size="10">&nbsp;&nbsp;
	<input name="fname" type="hidden" value="<?=$fname?>">
	<input name="isdir" type="hidden" value="<?=$isdir?>">
	<input name="dir" type="hidden" value="<?=$dir?>">
  <input type="submit" name="dosubmit" value="提交"></td>
</tr>
  <tr align="center">
    <td class="tablerow" colspan="2">&nbsp;</td>
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