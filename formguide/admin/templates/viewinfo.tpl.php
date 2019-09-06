<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<table cellpadding="0" cellspacing="1" class="table_list">
<caption>表单详情</caption>
<?php
	foreach($info as $k=>$v)
	{
?>
<tr>
	<th width="20%"><strong><?=$formguide_output->fields[$k][name]?></strong></th>
	<td><?=$v?></td>
</tr>
<?php
	}
?>
</table>
</body>
</html>