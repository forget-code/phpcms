<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_form">
	<tr>
    	<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage" title="管理播放器">管理播放器</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=add" title="添加播放器">添加播放器</a></td>
    </tr>
</table>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>">
<input type="hidden" name="action" value="add">
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>添加播放器代码</caption>
    <tr>
    	<th width="20%"><strong>名称：</strong></th>
        <td><input type="text" name="info[subject]" size="50" /></td>
    </tr>
    <tr>
    	<th><strong>播放器代码：</strong></th>
        <td><textarea name="info[code]" cols="80" rows="20" style="width:100%"></textarea></td>
    </tr>
    <tr>
    	<th><strong>禁用：</strong></th>
        <td><?=form::radio(array(1=>'是',0=>'否'), 'info[disabled]', 'disabled')?></td>
    </tr>
    <tr>
    	<th><strong></strong></th>
        <td><input type="submit" name="dosubmit" value="确定" /> <input type="reset" value="重置" /></td>
    </tr>
</table>
</form>
</body>
</html>
<script language="javascript">
<!--
$().ready(function() {
	  $('form').checkForm(1);
	});
//-->
</script>