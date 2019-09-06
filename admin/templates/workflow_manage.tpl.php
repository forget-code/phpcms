<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="2" cellspacing="1" class="table_list">
    <caption>工作流方案管理</caption>
    <tr>
        <th width="5%"><strong>ID</strong></th>
        <th width="10%"><strong>方案名称</strong></th>
        <th><strong>方案描述</strong></th>
        <th width="10%"><strong>方案类型</strong></th>
        <th width="30%"><strong>管理操作</strong></th>
    </tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
    <tr>
        <td class="align_c"><?=$info['workflowid']?></td>
        <td class="align_c"><?=$info['name']?></td>
        <td><?=$info['description']?></td>
        <td class="align_c"><?=$info['issystem'] ? '<font color="red">系统</font>' : '自定义'?></td>
        <td class="align_c">
            <a href="?mod=<?=$mod?>&file=process&action=add&workflowid=<?=$info['workflowid']?>">添加步骤</a> | 
            <a href="?mod=<?=$mod?>&file=process&action=manage&workflowid=<?=$info['workflowid']?>">管理步骤</a> | 
            <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&workflowid=<?=$info['workflowid']?>">修改</a> | 
            <a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&workflowid=<?=$info['workflowid']?>', '是否删除该工作流')">删除</a> 
        </td>
    </tr>
<?php 
	}
}
?>
</table>
</body>
</html>