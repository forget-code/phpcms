<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>
  管理栏目
  </caption>
<tr align="center">
<th width="50">排序</th>
<th width="50">ID</th>
<th>栏目名称</th>
<th width="200">管理操作</th>
</tr>
<?=$categorys?>
</table>
<table cellpadding="0" cellspacing="1" border="0" width="100%" height="30">
  <tr>
    <td><input name="dosubmit" type="submit" value=" 排序 "></td>
  </tr>
</table>
</form>
</body>
</html>