<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=9>用户组管理</th>
  </tr>
<tr align="center">
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
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><?=$group['groupid']?></td>
<td><?=$group['groupname']?></td>
<td><?=$group['introduce']?></td>
<td><?=$group['chargetype']?></td>
<td><?=$group['charge']?></td>
<td><?=$group['discount']?>%</td>
<td><?=$group['enableaddalways']?></td>
<td><?=$group['type']?></td>
<td>
<?php if($group['groupid']==6){ ?>
<a href='?mod=<?=$mod?>&file=<?=$file?>&action=edit&groupid=<?=$group['groupid']?>'>修改</a> | &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php }elseif($group['grouptype']=="special"){ ?>
<a href='?mod=<?=$mod?>&file=<?=$file?>&action=edit&groupid=<?=$group['groupid']?>'>修改</a> | 
<a href='?mod=<?=$mod?>&file=<?=$file?>&action=delete&groupid=<?=$group['groupid']?>'>删除</a>
<?php } ?>
</td>
</tr>
<?php } 
}
?>
</table>
</body>
</html>