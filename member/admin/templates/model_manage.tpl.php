<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>会员模型管理</caption>
<tr>
<th width="10%">模型名称</th>
<th width="20%">模型描述</th>
<th width="15%">数据表</th>
<th width="5%">会员数</th>
<th width="5%">状态</th>
<th width="25%">管理操作</th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td class="align_c"><a href="?mod=member&file=member&action=manage&modelid=<?=$info['modelid']?>" title="列出<?=$info['name']?>会员"><?=$info['name']?></a></td>
<td><?=$info['description']?></td>
<td><a href="?mod=<?=$mod?>&file=model_field&action=manage&modelid=<?=$info['modelid']?>"><?=DB_PRE.'member_'.$info['tablename']?></a></td>
<td class="align_c"><a href="?mod=member&file=member&action=manage&modelid=<?=$info['modelid']?>" title="列出<?=$info['name']?>会员"><?=$model->rows(DB_PRE.'member_'.$info['tablename'])?></a></td>
<td class="align_c"><?=($info['disabled']==1)?'':'<font color="red">√</font>'?></td>
<td class="align_c">
	<a href="?mod=<?=$mod?>&file=model_field&action=manage&modelid=<?=$info['modelid']?>">字段管理</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&modelid=<?=$info['modelid']?>">修改</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=disable&modelid=<?=$info['modelid']?>&disabled=<?=($info['disabled']==1 ? 0 : 1)?>"><?=($info['disabled']==1 ? '<font color="blue">启用</font>' : '禁用')?></a> | <?php if($info['tablename'] == 'detail') { ?>
	<font color="#cccccc">删除</font>
	<?php } else { ?>
     <a href="#" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&modelid=<?=$info['modelid']?>', '是否删除该会员模型')">删除</a>
	<?php } ?> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=export&modelid=<?=$info['modelid']?>">导出为模板</a> | <a href="?mod=<?=$mod?>&file=member&action=model_move&frommodelid=<?=$info['modelid']?>">移动</a>
</td>
</tr>
<?php 
	}
}
?>
</table>
<table cellpadding="0" cellspacing="1" class="table_list">
	<caption>提示信息</caption>
	<tr>
		<td>
		1、请谨慎删除模型，当模型里存在会员时请先将该模型里的会员导到其他会员模型中。<br />
		2、移动模型会员，将会把原有模型里的会员信息删除，将不能修复。
		</td>
	</tr>
</table>
</body>
</html>