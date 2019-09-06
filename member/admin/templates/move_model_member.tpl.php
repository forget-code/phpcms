<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<input type="hidden" name="frommodelid" value="<?=$frommodelid?>">
<input type="hidden" name="forward" value="<?=$forward?>">
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>按模型移动会员</caption>
	<tr>
		<th width="30%"><strong>所在模型</strong></th><td><?=$MODEL[$frommodelid]['name']?></td>
	</tr>
	<tr>
		<th><strong>目标模型</strong></th>
		<td>
			<?=form::select($arr_model, 'tomodelid', 'tomodellid')?>
		</td>
	</tr>
	<tr>
		<th></th>
		<td>
		<input type="submit" name="dosubmit" value="确定" onClick="if(confirm('确认批量删除这些会员吗？')) document.myform.action='?mod=member&file=member&action=delete&dosubmit=1'">
		<input type="reset" name="reset" value="重置">
		</td>
	</tr>
</table>
</form>
</body>
</html>
<script language="javascript">

</script>