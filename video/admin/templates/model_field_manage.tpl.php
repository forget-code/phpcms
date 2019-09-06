<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder&modelid=<?=$modelid?>">
<table cellpadding="2" cellspacing="1" class="table_list">
<caption>视频模块字段管理</caption>
<tr>
<th>排序</th>
<th>字段名</th>
<th>别名</th>
<th>类型</th>
<th>系统</th>
<th>必填</th>
<th>搜索</th>
<th>排序</th>
<th>投稿</th>
<th>管理操作</th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td class="align_c"><input type="text" name="info[<?=$info['fieldid']?>]" value="<?=$info['listorder']?>" size="3"/></td>
<td><?=$info['field']?></td>
<td><?=$info['name']?></td>
<td><?=$fields[$info['formtype']]?></td>
<td class="align_c"><?=($info['issystem'] ? '<font color="red">√</font>' : '')?></td>
<td class="align_c"><?=($info['minlength'] ? '<font color="red">√</font>' : '')?></td>
<td class="align_c"><?=($info['issearch'] ? '<font color="red">√</font>' : '')?></td>
<td class="align_c"><?=($info['isorder'] ? '<font color="red">√</font>' : '')?></td>
<td class="align_c"><?=($info['isadd'] ? '<font color="red">√</font>' : '')?></td>
<td class="align_c">
<?php if($info['iscore']){ ?>
	<span style="color:#cccccc">修改 | 复制 | 禁用 | 删除</span>
<?php }else{ ?>
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&modelid=<?=$modelid?>&fieldid=<?=$info['fieldid']?>">修改</a> | 
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=copy&modelid=<?=$modelid?>&fieldid=<?=$info['fieldid']?>">复制</a> | 
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=disable&modelid=<?=$modelid?>&fieldid=<?=$info['fieldid']?>&disabled=<?=($info['disabled']==1 ? 0 : 1)?>"><?=($info['disabled']==1 ? '<font color="red">启用</font>' : '禁用')?></a> | 
	<?php if($info['issystem']){ ?>
	<span style="color:#cccccc">删除</a></span>
	<?php }else{ ?>
	<a href=javascript:confirmurl("?mod=<?=$mod?>&file=<?=$file?>&action=delete&modelid=<?=$modelid?>&fieldid=<?=$info['fieldid']?>","确认要删除‘<?=$info['name']?>’字段吗？")>删除</a>
	<?php } ?>
<?php } ?>
</td>
</tr>
<?php 
	}
}
?>
</table>
<div class="button_box"><input type="submit" name="dosubmit" value=" 排序 "></div>
</form>
</body>
</html>