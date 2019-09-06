<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>Phpcms 数据字典</caption>
<tr>
<th width="33%">数据表</th>
<th width="34%">名称</th>
<th>查看</th>
</tr>
<?php 
if(is_array($tables)){
	foreach($tables as $table){
?>
<tr>
<td><?=$table?></td>
<td><?=$tablenames[$table]?></td>
<td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=field&table=<?=$table?>">查看字段列表</a></td>
</tr>
<?php 
	}
}
?>
</table>
</body>
</html>