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
<td width="5%" class="tablerowhighlight">排序</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="25%" class="tablerowhighlight">属性名</td>
<td width="15%" class="tablerowhighlight">所属类型</td>
<td width="15%" class="tablerowhighlight">属性录入方式</td>
<td width="15%" class="tablerowhighlight">属性备选值</td>
<td width="40%" class="tablerowhighlight">管理操作</td>
</tr>
<?php
foreach($atts as $att)
{
?>
<tr align="center">
<td width="5%" class="tablerow">排序</td>
<td width="5%" class="tablerow"><?=$att['att_id']?></td>
<td width="30%" class="tablerow"><?=$att['pro_name']?></td>
<td width="15%" class="tablerow"><?=$att['pro_num']?></td>
<td width="15%" class="tablerow"><?php if($property['disabled']=="0") echo "√";else echo "×"; ?></td>
<td width="15%" class="tablerow"><?=$att['pro_num']?></td>
<td width="35%" class="tablerow">
<a href="#">编辑</a>|
<a href="#">删除</a>
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
</form>
</body>
</html>