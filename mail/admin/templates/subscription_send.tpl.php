<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <td class="tablerowhighlight">
    每轮同时发送邮件数：<input type="text" name="maxnum"  value="<?=$MOD['maxnum']?>" id="maxnum" style="text-align:center" size="3" title="请填写每轮发送邮件的最大数量" /> </td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>批量发送邮件邮件</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<tr align="center">
<td class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">期刊号</td>
<td class="tablerowhighlight">所属分类</td>
<td class="tablerowhighlight">邮件标题</td>
<td class="tablerowhighlight">订阅人数</td>
<td class="tablerowhighlight">发送时间</td>
<td class="tablerowhighlight">操作</td>
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
<td class="tablerow"><?=$mail['subnum']?></td>
<td id="subnum<?=$mail['mailid']?>" class="tablerow"><?=$mail['sendtime']?></td>
<td class="tablerow">
<a href="javascript:if($('subnum<?=$mail['mailid']?>').innerHTML.indexOf('未发送')<0){if(confirm('该邮件订阅已经发送过，是否重新发送？')) location='?maxnum='+$('maxnum').value+'&mod=<?=$mod?>&file=<?=$file?>&action=send&job=start&typeid=<?=$mail['typeid']?>&mailid=<?=$mail['mailid']?>';} else location='?maxnum='+$('maxnum').value+'&mod=<?=$mod?>&file=<?=$file?>&action=send&job=start&typeid=<?=$mail['typeid']?>&mailid=<?=$mail['mailid']?>';"><font color="Blue"><strong>开始发送</strong></font></a>
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