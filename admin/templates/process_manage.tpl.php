<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>工作流步骤管理</caption>
<tr>
<th>ID</th>
<th>步骤名称</th>
<th>步骤描述</th>
<th>通过的操作名</th>
<th>退回的操作名</th>
<th>管理操作</th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td class="align_c"><?=$info['processid']?></td>
<td class="align_c"><?=$info['name']?></td>
<td align="left"><?=$info['description']?></td>
<td class="align_c"><?=$info['passname']?></td>
<td class="align_c"><?=$info['rejectname']?></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&processid=<?=$info['processid']?>&workflowid=<?=$info['workflowid']?>">修改</a> | 
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&processid=<?=$info['processid']?>&workflowid=<?=$info['workflowid']?>">删除</a> 
</td>
</tr>
<?php 
	}
}
?>
</table>
</body>
</html>