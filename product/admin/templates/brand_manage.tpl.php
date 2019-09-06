<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <td class="tablerowhighlight">
    <form  method="post"  action="?mod=<?=$mod?>&file=<?=$file?>&action=add" name='form1' onsubmit="javascript:if($F('brand_name')=='') {alert('请填写品牌名称');$('brand_name').focus(); return false;}">快速添加品牌&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    品牌名称：<input type="text" name="brand_name" id="brand_name" onclick="javascript:this.value='';this.style.color='#000000';" size="30"/>
    <input type="submit" name="submit" value=" 添 加 " /></form></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>品牌列表</th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">ID</td>
<td width="25%" class="tablerowhighlight">品牌名称</td>
<td width="15%" class="tablerowhighlight">品牌图标</td>
<td width="15%" class="tablerowhighlight">品牌描述</td>
<td width="15%" class="tablerowhighlight">使用频度（次）</td>
<td width="25%" class="tablerowhighlight">管理操作</td>
</tr>
<?php
foreach($brands as $brand)
{
?>
<tr align="center">
<td width="5%" class="tablerow"><?=$brand['brand_id']?></td>
<td width="25%" class="tablerow">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&brand_id=<?=$brand['brand_id']?>"><?=$brand['brand_name']?></a></td>
<td width="15%" class="tablerow"><? if($brand['brand_icon']) echo "<img src=".imgurl($brand['brand_icon'])." />"?></td>
<td width="15%" class="tablerow"><?=$brand['brand_description']?></td>
<td width="15%" class="tablerow"><?=$brand['brand_frequency']?></td>
<td width="35%" class="tablerow">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&brand_id=<?=$brand['brand_id']?>">编辑</a>
<a href="javascript:if(confirm('确认删除该品牌？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&brand_id=<?=$brand['brand_id']?>'">删除</a>
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