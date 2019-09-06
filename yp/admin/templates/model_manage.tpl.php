<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="2" cellspacing="1" class="table_list">
    <caption>企业黄页模型管理</caption>
<tr>
<th width="10%">名称</th>
<th>描述</th>
<th width="15%">数据表</th>
<th width="8%">数据量</th>
<th width="35%">管理操作</th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td class="align_c"><?=$info['name']?></td>
<td><?=$info['description']?></td>
<td class="align_l"><a href="?mod=<?=$mod?>&file=model_field&action=manage&modelid=<?=$info['modelid']?>"><?=DB_PRE.'yp_'.$info['tablename']?></a></td>
<td class="align_c"><?=$model->rows(DB_PRE.'yp_'.$info['tablename'])?></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=model_field&action=manage&modelid=<?=$info['modelid']?>">字段管理</a> | 
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&modelid=<?=$info['modelid']?>">修改</a>
</td>
</tr>
<?php 
	}
}
?>
</table>
</body>
</html>