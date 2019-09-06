<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=update">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>PHP 错误日志</caption>
<tr>
<th>ID</th>
<th>路径</th>
<th>行数</th>
<th>提示</th>
<th>级别</th>
<th>时间</th>
</tr>
<?php 
if(is_array($logarr)){
	foreach($logarr as $log){
?>
<tr>
<td><?=$log['errornum']?></td>
<td align="left"><?=str_replace(PHPCMS_ROOT,'',$log['scriptname'])?></td>
<td><?=$log['scriptlinenum']?></td>
<td align="left"><?=$log['errormsg']?></td>
<td><?=$log['errortype']?></td>
<td><?=$log['datetime']?></td>
</tr>
<?php 
	}
}
?>
</table>
</form>

</body>
</html>