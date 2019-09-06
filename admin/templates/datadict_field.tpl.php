<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption><?=$table?>（<?=$tablenames[$table]?>）字段列表</caption>
<tr>
<th width="33%">字段</th>
<th width="34%">名称</th>
</tr>
<?php 
if(is_array($fields)){
	foreach($fields as $field=>$name){
?>
<tr>
<td><?=$field?></td>
<td><?=$name?></td>
</tr>
<?php 
	}
}
?>
</table>
</body>
</html>