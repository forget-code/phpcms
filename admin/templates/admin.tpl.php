<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=update">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=9>管理员列表</th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="10%" class="tablerowhighlight">用户名</td>
<td width="10%" class="tablerowhighlight">真实姓名</td>
<td width="10%" class="tablerowhighlight">等级</td>
<td width="15%" class="tablerowhighlight">最后登录IP</td>
<td width="15%" class="tablerowhighlight">最后登录时间</td>
<td width="15%" class="tablerowhighlight">登录次数</td>
<td width="15%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($admins)){
	foreach($admins as $a){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input size=50 name="userid[<?=$a['userid']?>]" type="checkbox" value="<?=$a['userid']?>"></td>
<td><?=$a['userid']?></td>
<td><a href='<?=PHPCMS_PATH?>member/member.php?username=<?=$a['username']?>' target='_blank'><?=$a['username']?></a></td>
<td><?=$a['truename']?></td>
<td><?=$grades[$a['grade']]?></td>
<td><?=$a['lastloginip']?></td>
<td><?=$a['lastlogintime']?></td>
<td><?=$a['logintimes']?></td>
<td><a href='?mod=<?=$mod?>&file=<?=$file?>&action=edit&userid=<?=$a['userid']?>'>权限设置</a> | <a href='?mod=phpcms&file=admin&action=delete&userid=<?=$a['userid']?>'>撤消</a></td>
</tr>
<?php 
	}
}
?>
</table>
</form>

</body>
</html>