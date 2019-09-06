<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script type="text/javascript">
function checkform()
{
	if(!Common.isemail($('searchemail').value))
	{ 
		alert('请输入正确的email！');
		$('searchemail').focus();
	}
	else 
	location='?mod=<?=$mod?>&file=<?=$file?>&action=manage&searchemail='+$('searchemail').value;
}
</script>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <td class="tablerowhighlight">
    Email：<input type="text" name="searchemail" id="searchemail" />  
    <input type="button" onclick="checkform();" value=" 搜 索 " /></td>
  <td class="tablerowhighlight" align="right">按订阅的分类查看：<?=$typeid_select?></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>订阅email列表</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<tr align="center">
<td class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">Email</td>
<td class="tablerowhighlight">用户名</td>
<td class="tablerowhighlight">订阅者IP</td>
<td class="tablerowhighlight">订阅时间</td>
<td class="tablerowhighlight">是否激活</td>
<td class="tablerowhighlight">管理操作</td>
</tr>
<?php
foreach($emails as $email)
{
?>
<tr align="center" title="<?=$email['email']?>&#10;订阅的类别：&#10;<?=$email['type']?>">
<td class="tablerow"><?=$email['emailid']?></td>
<td class="tablerow"><a href="?mod=<?=$mod?>&file=send&type=1&email=<?=$email['email']?>" ><?=$email['email']?></a></td>
<td class="tablerow"><?=$email['username']?></td>
<td class="tablerow"><?=$email['ip']?></td>
<td class="tablerow"><?=$email['addtime']?></td>
<td class="tablerow"><?=$email['authcode']?></td>
<td class="tablerow">
<a href="javascript:if(confirm('确定审核激活该条记录吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=verify&emailid=<?=$email['emailid']?>'">激活</a>
<a href="javascript:if(confirm('确定删除该条记录吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&emailid=<?=$email['emailid']?>'">删除</a>
</td>
</tr>
<?php
}
?>

</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center><?=$pages?></td>
  </tr>
</table>
</form>
</body>
</html>