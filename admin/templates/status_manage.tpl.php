<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>稿件状态管理</caption>
    <tr>
        <th width="10%">名称</th>
        <th width="10%">值</th>
        <th>描述</th>
        <th width="10%">类型</th>
        <th width="10%">数据量</th>
        <th width="30%">管理操作</th>
    </tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
    <tr>
        <td class="align_c"><?=$info['name']?></td>
        <td class="align_c"><?=$info['status']?></td>
        <td><?=$info['description']?></td>
        <td class="align_c"><?=$info['issystem'] ? '<font color="red">系统</font>' : '自定义'?></td>
        <td class="align_c"><?=cache_count("select count(*) as count from ".DB_PRE."content where status=".$info['status'])?></td>
        <td class="align_c">
        <?php if(!$info['issystem']){ ?>
        <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&status=<?=$info['status']?>">修改</a> | <a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&status=<?=$info['status']?>', '是否删除该稿件状态')">删除</a> 
        <?php } ?>
        </td>
    </tr>
<?php 
	}
}
?>
</table>
</body>
</html>