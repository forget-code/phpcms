<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder&modelid=<?=$modelid?>">
<table cellpadding="2" cellspacing="1" class="table_list">
 	<caption><?=$modelname?>模型字段管理</caption>
<tr>
<th width="5%">排序</th>
<th width="15%">字段名</th>
<th width="10%">字段别名</th>
<th width="10%">字段类型</th>
<th width="10%">前台显示</th>
<th width="10%">搜索</th>
<th width="10%">状态</th>
<th width="25%">管理操作</th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info)
	{
?>
<tr>
<td class="align_c"><input type="text" name="info[<?=$info['fieldid']?>]" value="<?=$info['listorder']?>" size="3"/></td>
<td class="align_c"><?=$info['field']?></td>
<td class="align_c"><?=$info['name']?></td>
<td class="align_c"><?=$fields[$info['formtype']]?></td>
<td class="align_c"><?=($info['islist'] ? '<font color="red">√</font>' : '<font color="red">×</font>')?></td>
<td class="align_c"><?=($info['issearch'] ? '<font color="red">√</font>' : '<font color="red">×</font>')?></td>
<td class="align_c"><?=($info['disabled'] ? '<font color="red">×</font>' : '<font color="red">√</font>')?></td>
<td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&modelid=<?=$modelid?>&fieldid=<?=$info['fieldid']?>">修改</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=disable&modelid=<?=$modelid?>&fieldid=<?=$info['fieldid']?>&disabled=<?=($info['disabled']==1 ? 0 : 1)?>"><?=($info['disabled']==1 ? '<font color="blue">启用</font>' : '禁用')?></a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=copy&modelid=<?=$modelid?>&fieldid=<?=$info['fieldid']?>">复制</a> | <a href="#" onclick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&modelid=<?=$modelid?>&fieldid=<?=$info['fieldid']?>', '是否删除该字段')">删除</a></td>
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