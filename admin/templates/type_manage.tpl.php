<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>类别管理</caption>
<tr>
<th width="5%"><strong>排序</strong></td>
<th width="5%"><strong>ID</strong></th>
<th width="20%"><strong>类别名称</strong></th>
<th width="*"><strong>类别描述</strong></th>
<th width="30%"><strong>管理操作</strong></th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td class="align_c"><input type="text" name="info[<?=$info['typeid']?>]" value="<?=$info['listorder']?>" size="5"></td>
<td class="align_c"><?=$info['typeid']?></td>
<td class="align_c"><span style="<?=$info['style']?>"><?=$info['name']?></span></td>
<td class="align_c"><?=$info['description']?></td>
<td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&typeid=<?=$info['typeid']?>&module=<?=$module?>">修改</a> | <a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&typeid=<?=$info['typeid']?>&module=<?=$module?>', '是否删除该类型')">删除</a> </td>
</tr>
<?php 
	}
}
?>
</table>
<div class="button_box"><input type="submit" name="dosubmit" value=" 更新排序 "></div>
<div id="pages"><?=$type->pages?></div>
</form>
</body>
</html>