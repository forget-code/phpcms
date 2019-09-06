<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<input type="hidden" name="exmodeild" value="<?=$modelid?>">
<input type="hidden" name="info[userid]" value="<?=$userid?>" />
<input type="hidden" name="forward" value=<?=$forward?> />
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>修改模型</caption>
	<tr>
		<th width="10%"><strong>所在模型：</strong></th>
		<td><?=$MODEL[$modelid][name]?></td>
	</tr>
    <tr>
    	<th><strong>目标模型：</strong></th>
        <td><?=form::select_member_model('tomodelid', 'tomodelid', '请选择', '', 'require="true" ')?></td>
    </tr>
    <tr>
    	<th></th>
    	<td>
        <input type="submit" name="dosubmit" value="提交">
        <input type="reset" name="reset" value="重新填写">
        </td>
    </tr>
</table>
</form>
<table cellpadding="0" cellspacing="1" class="table_info">
	<caption>注意事项</caption>
    <tr>
    	<td>
        当修改用户的模型后，用户以前的模型信息将被删除！
        </td>
    </tr>
</table>
</body>
</html>