<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="0" class="table_form">
<caption></caption>
<tr>
     <td>
    每轮同时发送邮件数：<input type="text" name="maxnum"  value="<?=$M['maxnum']?>" id="maxnum" class="align_c" size="3" title="请填写每轮发送邮件的最大数量" /> </td>
  </tr>
</table>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>群发期刊</caption>
  <tr>
    <th style="width:50px">期刊号</th>
    <th>期刊标题</th>
    <th style="width:60px">所属分类</th>
    <th style="width:50px">订阅数</th>
    <th style="width:120px">添加时间</th>
    <th style="width:120px">发送时间</th>
	<th style="width:60px">状态</th>
    <th style="width:60px">发送次数</th>
    <th style="width:80px">操作</th>
  </tr>
  <?php
foreach($mails['info'] as $mail)
{
?>
<tr>
<td style="text-align:center;"><?=$mail['period']?></td>
<td style="text-align:left;"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&mailid=<?=$mail['mailid']?>" title="点击编辑邮件内容"><?=$mail['title']?></a></td>
<td style="text-align:center;"><?=output::style($TYPE[$mail['typeid']]['name'], $TYPE[$mail['typeid']]['style'])?>
</td>
<td style="text-align:center;"><?=$mail['num']?></td>
<td style="text-align:center;"><?=$mail['addtime']?></td>
<td style="text-align:center;"><?=$mail['sendtime']?></td>
<td id="subnum<?=$mail['mailid']?>" style="text-align:center;"><?=$mail['stauts']?></td>
<td style="text-align:center;"><?=$mail['count']?></td>
<td style="text-align:center;">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=send&job=start&typeid=<?=$mail['typeid']?>&mailid=<?=$mail['mailid']?>"><font color="Blue"><strong>开始发送</strong></font></a>
</td>
</tr>
<?php
}
?>
</table>
</form>
<div id="pages"><?=$pages?></div>
</body>
</html>