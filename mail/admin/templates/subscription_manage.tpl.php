<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>管理期刊</caption>
  <tr>
    <th style="width:30px">ID</th>
    <th style="width:50px">期刊号</th>
     <th>期刊标题</th>
    <th style="width:60px">所属分类</th>

    <th style="width:120px">添加时间</th>
    <th style="width:120px">发送时间</th>
    <th style="width:80px">操作人</th>
	<th style="width:80px">管理操作</th>
  </tr>
  <?php
foreach($mails['info'] as $mail)
{
?>
<tr>
<td style="text-align:center;"><?=$mail['mailid']?></td>
<td style="text-align:center;"><?=$mail['period']?></td>

<td style="text-align:center;"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&mailid=<?=$mail['mailid']?>"><?=$mail['title']?></a></td>
<td style="text-align:center;"><?=output::style($mail['typename'], $mail['typestyle'])?></td>
<td style="text-align:center;"><?=$mail['addtime']?></td>
<td style="text-align:center;"><?=$mail['sendtime']?></td>
<td style="text-align:center;"><a href="?mod=member&file=member&action=view&userid=<?=$mail['userid']?>"><?=$mail['username']?></a></td>
<td style="text-align:center;">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&mailid=<?=$mail['mailid']?>">编辑</a>|<a href="javascript:if(confirm('确定删除该条记录吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&mailid=<?=$mail['mailid']?>'">删除</a>
</td>
</tr>
<?php
}
?>
</table>
<div id="pages"><?=$pages?></div>
</body>
</html>