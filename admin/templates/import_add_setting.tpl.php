<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>" >
<input type="hidden" name="action" value="setting">
<table cellpadding="2" cellspacing="1" class="table_form">
	<caption>添加数据导入规则</caption>
	<tr>
		<th><strong>数据导入类型：</strong></th>
		<td><input type="radio" name="type" value="content" checked onclick="$('#member_model').hide();$('#content_model').show();"/> 内容 <input type="radio" name="type" value="member"  onclick="$('#member_model').show();$('#content_model').hide();"> 会员</td>
	</tr>
	<tr>
		<th><strong>请选择模型：</strong></th>
		<td id="content_model"><?=form::select_model('contentmodelid', 'contentmodelid', '请选择', '', '')?></td>
		<td id="member_model" style="display:none;"><?=form::select_member_model('membermodelid', 'membermodelid', '请选择', '', '')?></td>
	</tr>
	<tr>
		<th></th>
		<td>
			<input type="submit" name="submit" value=" 下一步 " />&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 " />
		</td>
	</tr>
</table>
</form>
</body>
</html>