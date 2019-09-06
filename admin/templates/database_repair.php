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
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>数据表优化和修复</th>
  </tr>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<tr align="center">
<td width="20%" class="tablerowhighlight">选中</td>
<td width="80%" class="tablerowhighlight">数据表名</td>
</tr>
<?php 
if(is_array($tables)){
	foreach($tables as $id => $table){
?>
  <tr>
    <td class="tablerow" align="center"><input type="checkbox" name="tables[]" value="<?=$table?>"></td>
    <td class="tablerow"><?=$table?></td>
	</td>
</tr>
<?php 
	}
}
?>
  <tr>
    <td class="tablerow" align="center"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
      <td class="tablerow">
      <input type="radio" name="operation" value="repair">修复表&nbsp;&nbsp;
      <input type="radio" name="operation" value="optimize" checked>优化表&nbsp;&nbsp;
	  <input type="submit" name="submit" value=" 提交 "></td>
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