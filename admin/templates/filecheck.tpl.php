<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>文件校验结果</caption>
	 <tr>
		<th>文件路径</th>
		<th>最后修改时间</th>
		<th>状态</th>
	 </tr>
<?php 
if(is_array($files)){
	foreach($files['edited'] as $filepath){
?>
	<tr>
		<td style="text-align:left"><?=$filepath?></td>
		<td class="align_c"><?=date('Y-m-d H:i:s', @filemtime(PHPCMS_ROOT.$filepath))?></td>
		<td style="text-align:center;color:red;">被修改</td>
	</tr>
<?php 
	}
}
?>
<?php 
if(is_array($files)){
	foreach($files['unknow'] as $filepath){
?>
	<tr>
		<td style="text-align:left"><?=$filepath?></td>
		<td class="align_c"><?=date('Y-m-d H:i:s', @filemtime(PHPCMS_ROOT.$filepath))?></td>
		<td style="text-align:center;color:blue;">未知</td>
	</tr>
<?php 
	}
}
?>
</table>
</form>
</body>
</html>