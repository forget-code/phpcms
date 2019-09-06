<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption><?=$title?> 操作日志</caption>
<tr>
<th>时间</th>
<th>操作</th>
<th>用户名</th>
<th>IP</th>
</tr>
<?php 
if(is_array($data)){
	foreach($data as $r){
?>
<tr>
<td class="align_c"><?=$r['time']?></td>
<td class="align_c"><?=is_numeric($r['action']) ? $STATUS[$r['action']] : $ACTION[$r['action']]?></td>
<td class="align_c"><a href="<?=member_view_url($r['userid'])?>"><?=$r['username']?></a></td>
<td class="align_c"><a href="<?=ip_url($r['ip'])?>"><?=$r['ip']?></a></td>
</tr>
<?php 
	}
}
?>
</table>
<div><?=$c->pages?></div>
</form>
</body>
</html>