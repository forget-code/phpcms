<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>
  管理栏目
  </caption>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<tr align="center">
<th width="50">排序</td>
<th width="50">ID</td>
<th>栏目名称</td>
<th width="100">访问</td>
<th width="200">管理操作</td>
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