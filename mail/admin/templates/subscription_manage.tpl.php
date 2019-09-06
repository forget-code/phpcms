<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <td class="tablerowhighlight">
    添加订阅邮件内容： 第<input type="text" name="period" id="period" style="text-align:center" size="3" title="请填写每轮发送邮件的数字ID号（期刊ID）" />  期
    <input type="button" onclick="if(isNaN($('period').value)==true || $('period').value==''){ alert('请填写数字ID号！');$('period').focus();} else location='?mod=<?=$mod?>&file=<?=$file?>&action=add&period='+$('period').value" value="添加" /></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>邮件内容列表</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<tr align="center">
<td class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">期刊号</td>
<td class="tablerowhighlight">所属分类</td>
<td class="tablerowhighlight">邮件标题</td>
<td class="tablerowhighlight">添加时间</td>
<td class="tablerowhighlight">发送时间</td>
<td class="tablerowhighlight">操作人</td>
<td class="tablerowhighlight">管理操作</td>
</tr>
<?php
foreach($mails as $mail)
{
?>
<tr align="center">
<td class="tablerow"><?=$mail['mailid']?></td>
<td class="tablerow"><?=$mail['period']?></td>
<td class="tablerow"><font style="<?=$TYPE[$mail['typeid']]['style']?>"><?=$TYPE[$mail['typeid']]['name']?></font></td>
<td class="tablerow"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&mailid=<?=$mail['mailid']?>"><?=$mail['title']?></a></td>
<td class="tablerow"><?=$mail['addtime']?></td>
<td class="tablerow"><?=$mail['sendtime']?></td>
<td class="tablerow"><?=$mail['username']?></td>
<td class="tablerow">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&mailid=<?=$mail['mailid']?>">编辑</a>
<a href="javascript:if(confirm('确定删除该条记录吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&mailid=<?=$mail['mailid']?>'">删除</a>
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