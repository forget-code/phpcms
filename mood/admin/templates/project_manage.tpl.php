<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<?=$menu?>
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="table_list">
<caption>方案管理</caption>
	<tr>
		<th width="10%">ID</th>
		<th>方案名称</th>
		<th width="10%">数量</th>
		<th width="10%">管理操作</th>
	</tr>
<?php
foreach($infos AS $info)
{
?>
	<tr>
		<td class="align_c"><?=$info['moodid']?></td>
		<td class="align_c"><?=$info['name']?></td>
		<td class="align_c"><?=$info['number']?></td>
		<td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&moodid=<?=$info['moodid']?>">编辑</a> | <a href="javascript:if(confirm('确定删除该条记录吗？'))  location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&moodid=<?=$info['moodid']?>'">删除</a></td>
	</tr>
<?php
}
?>
</table>

</body>
</html>