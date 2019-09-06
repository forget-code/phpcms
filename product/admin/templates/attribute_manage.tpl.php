<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>商品属性</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<tr align="center">
<td width="7%" class="tablerowhighlight">排序</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="20%" class="tablerowhighlight">属性名称</td>
<td width="15%" class="tablerowhighlight">所属商品类型</td>
<td width="12%" class="tablerowhighlight">属性值录入方式</td>
<td width="21%" class="tablerowhighlight">备选属性值</td>
<td width="20%" class="tablerowhighlight">管理操作</td>
</tr>
<?php
foreach($atts as $att)
{
?>
<tr align="center">
<td width="7%" class="tablerow"><input name='listorder[<?=$att['att_id']?>]' type='text' size='3' value='<?=$att['listorder']?>'></td>
<td width="5%" class="tablerow"><?=$att['att_id']?></td>
<td width="20%" class="tablerow"><a href="?mod=<?=$mod?>&file=attribute&action=edit&att_id=<?=$att['att_id']?>"><?=$att['att_name']?></a></td>
<td width="15%" class="tablerow"><?=$att['pro_name']?></td>
<td width="12%" class="tablerow"><?=$atttype[$att['att_type']]?></td>
<td width="21%" class="tablerow"><?=str_replace("\n","<br>",$att['att_values'])?></td>
<td width="20%" class="tablerow">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&att_id=<?=$att['att_id']?>">编辑</a>
<a href="javascript:if(confirm('确定删除该条记录吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&att_id=<?=$att['att_id']?>&pro_id=<?=$pro_id?>'">删除</a>
</td>
</tr>
<?php
}
?>

</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td><input name="submit" type="submit" size="4" value=" 更新排序 "></td>
  </tr>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center><?=$pages?></td>
  </tr>
</table>
</form>
</body>
</html>