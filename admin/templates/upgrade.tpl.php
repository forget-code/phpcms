<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>在线更新</caption>
	<tr>
	<th>模块</th>
	<th>模块目录</th>
	<th>版本号</th>
	<th>更新日期</th>
	<th>发布日期</th>
	</tr>
<?php 
$data = get("select * from ".DB_PRE."module ");
foreach($data as $r){
?>
<tr>
<td><?=$r['module']?></td>
<td><?=$r['path']?></td>
<td class="align_c"><?=$r['version']?></td>
<td class="align_c"><?=$r['updatedate']?></td>
<td class="align_c"><?=$r['publishdate']?></td>
</tr>
<?php 
}
?>
</table>
</body>
</html>