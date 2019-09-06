<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="images/js/validator.js"></script>
<body>
<form method="post" action="?mod=announce&file=announce&action=add">
<table cellpadding="0" cellspacing="1" class="table_form">
<caption>添加公告</caption>
	<tr>
		<th><strong>公告标题：</strong></th>
		<td><input name="announce[title]" type="text" size="89" require="true" datatype="require" msg="标题不能为空"></td>
	</tr>
	<tr>
		<th><strong>起始日期：</strong></th>
		<td><?=form::date('announce[fromdate]', date('Y-m-d'))?></td>
	</tr>
	<tr>
		<th><strong>截止日期：</strong></th>
		<td><?=form::date('announce[todate]', $todate)?></td>
	</tr>
	<tr>
		<th><strong>公告内容：</strong></th>
		<td><textarea name="announce[content]" id="content"></textarea><?= form::editor("content","introduce",550,400)?></td>
	</tr>
	<tr>
		<th><strong>公告状态：</strong></th>
		<td><input name="announce[passed]" type="radio" value="1" checked>&nbsp;通过&nbsp;&nbsp;<input name="announce[passed]" type="radio" value="0">&nbsp;待审核</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="submit" value=" 确定 ">&nbsp;<input type="reset" value=" 清除 "></td>
	</tr>
</table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
<!--
$().ready(function() {
	  $('form').checkForm(1);
	});
//-->
</script>
