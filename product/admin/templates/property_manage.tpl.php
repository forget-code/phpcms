<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <td class="tablerowhighlight"><form  method="post"  action="?mod=<?=$mod?>&file=property&action=add" name='form1' onsubmit="javascript:if($F('pro_name')=='') {alert('请填写商品类型名称');$('pro_name').focus(); return false;}">快速添加商品类型&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    商品类型名称：<input type="text" name="pro_name" id="pro_name" onclick="javascript:this.value='';this.style.color='#000000';" size="30"/>
    <input type="submit" name="submit" value="添加" /></form></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>商品类型列表</th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">ID</td>
<td width="25%" class="tablerowhighlight">商品类型名称</td>
<td width="15%" class="tablerowhighlight">属性数</td>
<td width="15%" class="tablerowhighlight">启用</td>
<td width="40%" class="tablerowhighlight">管理操作</td>
</tr>
<?php
foreach($properties as $property)
{
?>
<tr align="center">
<td width="5%" class="tablerow"><?=$property['pid']?></td>
<td width="30%" class="tablerow"><a href="?mod=<?=$mod?>&file=attribute&action=manage&pro_id=<?=$property['pid']?>"><?=$property['pro_name']?></a></td>
<td width="15%" class="tablerow"><?=$property['pro_num']?></td>
<td width="15%" class="tablerow"><?php if($property['disabled']=="0") echo "√";else echo "×"; ?></td>
<td width="35%" class="tablerow">
<a href="?mod=<?=$mod?>&file=attribute&action=add&pro_id=<?=$property['pid']?>">添加属性</a>
<a href="?mod=<?=$mod?>&file=attribute&action=manage&pro_id=<?=$property['pid']?>">查看属性</a>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&pro_id=<?=$property['pid']?>">编辑</a>
<a href="javascript:if(confirm('确认删除该商品类型？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&pro_id=<?=$property['pid']?>'">删除</a>
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
</body>
</html>