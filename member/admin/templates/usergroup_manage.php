<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=9>用户组管理</th>
  </tr>
<tr align=center>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="10%" class="tablerowhighlight">用户组</td>
<td width="28%" class="tablerowhighlight">说明</td>
<td width="8%" class="tablerowhighlight">计费方式</td>
<td width="12%" class="tablerowhighlight">点数/有效期</td>
<td width="6%" class="tablerowhighlight">折扣</td>
<td width="8%" class="tablerowhighlight">发布特权</td>
<td width="10%" class="tablerowhighlight">类型</td>
<td width="13%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($groups))
{
  foreach($groups as $group){
?>
<tr align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td class=forumrow><?=$group[groupid]?></td>
<td class=forumrow><?=$group[groupname]?></td>
<td class=forumrow><?=$group[introduce]?></td>
<td class=forumrow><?=$group[chargetype]?></td>
<td class=forumrow><?=$group[charge]?></td>
<td class=forumrow><?=$group[discount]?>%</td>
<td class=forumrow><?=$group[enableaddalways]?></td>
<td class=forumrow><?=$group[type]?></td>
<td class=forumrow align=center>
<?php if($group['grouptype']=="special"){ ?>
<a href='?mod=<?=$mod?>&file=usergroup&action=edit&groupid=<?=$group[groupid]?>'>修改</a> | 
<a href='?mod=<?=$mod?>&file=usergroup&action=delete&groupid=<?=$group[groupid]?>'>删除</a>
<?php } ?>
</td>
</tr>
<?php } 
}
?>
</table>
</body>
</html>