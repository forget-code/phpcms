<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>分类管理</caption>
	<tr align="center">
		<th width="5%">排序</th>
		<th width="10%">分类</th>
		<th width="12%">名称</th>
		<th width="12%">密钥</th>
		<th>描述</th>
		<th width="20%">管理操作</th>
	</tr>
<?php
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td class="align_c"><input type="text" name="info[<?=$info['type']?>]" value="<?=$info['listorder']?>" size="5"></td>
<td class="align_c"><?=$info['type']?></td>
<td class="align_c"><?=$info['name']?></td>
<td><?=$info['md5key']?></td>
<td><?=$info['description']?></td>
<td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&type=<?=$info['type']?>">修改</a> | <a href="javascript:if(confirm('确定删除该条记录吗？')) location= '?mod=<?=$mod?>&file=<?=$file?>&action=delete&type=<?=$info['type']?>&typeid=<?=$info['type']?>'">删除</a> </td>
</tr>
<?php
	}
}
?>
</table>
<div class="button_box">
<input type="submit" name="dosubmit" value=" 排序 ">
</div>
</form>
</body>
</html>