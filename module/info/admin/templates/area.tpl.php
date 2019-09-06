<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>地区管理</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder&channelid=<?=$channelid?>">
<tr align="center">
<td width="15%" class="tablerowhighlight">排序</td>
<td width="15%" class="tablerowhighlight">ID</td>
<td width="25%" class="tablerowhighlight">地区名称</td>
<td class="tablerowhighlight">管理操作</td>
</tr>
<?=$areas?>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td><input name="submit" type="submit" size="4" value=" 更新排序 "></td>
  </tr>
</table>
</form>
</body>
</html>