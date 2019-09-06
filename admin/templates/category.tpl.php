<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>栏目管理</caption>
	<tr>
		<th width="5%">排序</th>
		<th width="5%">ID</th>
		<th>栏目名称</th>
		<th width="8%">栏目类型</th>
		<th width="10%">绑定模型</th>
		<th width="8%">数据量</th>
		<th width="5%">访问</th>
		<th width="300">管理操作</th>
	</tr>
<?=$categorys?>
</table>
<div class="button_box"><input name="dosubmit" type="submit" value=" 排序 "></div>
</form>
</body>
</html>