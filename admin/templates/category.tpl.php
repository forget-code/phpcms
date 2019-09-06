<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>栏目管理</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder&channelid=<?=$channelid?>">
<tr align="center">
<td width="5%" class="tablerowhighlight">排序</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="15%" class="tablerowhighlight">栏目名称</td>
<td width="8%" class="tablerowhighlight">栏目类型</td>
<td width="15%" class="tablerowhighlight">目录/链接</td>
<td width="8%" class="tablerowhighlight">栏目权限</td>
<td width="*" class="tablerowhighlight">管理员</td>
<td width="25%" class="tablerowhighlight">管理操作</td>
</tr>
<?=$categorys?>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td><input name="dosubmit" type="submit" value=" 排序 "></td>
  </tr>
</table>
</form>
</body>
</html>