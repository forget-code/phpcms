<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>推广联盟注册用户列表</th>
  </tr>
<tr align="center">
<td width="14%" class="tablerowhighlight">用户名</td>
<td width="10%" class="tablerowhighlight">姓名</td>
<td width="22%" class="tablerowhighlight">E-mail</td>
<td width="10%" class="tablerowhighlight">消费额</td>
<td width="18%"  class="tablerowhighlight">注册时间</td>
<td width="18%"  class="tablerowhighlight">最后登录</td>
<td width="8%"  class="tablerowhighlight">联盟ID</td>
</tr>
<?php
if(is_array($users)) 
{
foreach($users AS $user) {
?>
<tr height="20" align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><a href="<?=$user['username']?>" target="_blank"><?=$user['username']?></a></td>
<td><?=$user['truename']?></td>
<td><?=$user['email']?></td>
<td><?=$user['payment']?> 元</td>
<td><?=$user['regtime']?></td>
<td><?=$user['lastlogintime']?></td>
<td><a href="?mod=union&file=settle&userid=<?=$user['introducer']?>"><?=$user['introducer']?></a></td>
</tr>
<?php
	}
}
?>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td height="20" align="center"><?=$pages?></td>
  </tr>
</table>

</body>
</html>