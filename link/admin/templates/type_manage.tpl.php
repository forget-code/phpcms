<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>管理分类</caption>
  <tr>
    <th width="60">排序</th>
    <th>ID</th>
    <th>分类名称</th>
    <th>分类描述</th>
    <th>管理操作</th>
  </tr>
<?php
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td style="text-align:center"><input type="text" name="info[<?=$info['typeid']?>]" value="<?=$info['listorder']?>" size="5"></td>
<td style="text-align:center"><?=$info['typeid']?></td>
<td style="text-align:center"> <?=output::style($info['name'],$info['style'])?></td>
<td style="text-align:center"><?=$info['description']?></td>
<td style="text-align:center"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&typeid=<?=$info['typeid']?>&module=<?=$module?>">修改</a> | <a href="###" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&typeid=<?=$info['typeid']?>&module=<?=$module?>','确认要删除<?=$info['name']?>吗？')">删除</a> </td>
</tr>
<?php
	}
}
?>
</table>
<div class="button_box"><input type="submit" value=" 更新排序 " size="4" name="submit"/></div>
<div id="pages"><?=$type->pages?></div>
</form>
</body>
</html>