<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>管理分类</caption>
  <tr>
    <th style="width:5%">ID</th>
    <th style="width:20%">分类名称</th>
    <th style="width:20%">分类描述</th>
    <th style="width:9%">管理操作</th>
  </tr>
 <?php
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td style="text-align:center;"><?=$info['typeid']?></td>
<td style="text-align:center;"><?=output::style($info['name'], $info['style'])?></td>
<td align="text-align:left"><?=$info['description']?></td>
<td style="text-align:center;"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&typeid=<?=$info['typeid']?>">修改</a> | <a href="javascript:if(confirm('确定要删除该类别吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&typeid=<?=$info['typeid']?>'">删除</a></td>
</tr>
<?php
	}
}
?></table>
</form>
<div id="pages"><?=$type->pages?></div>
</body>
</html>
