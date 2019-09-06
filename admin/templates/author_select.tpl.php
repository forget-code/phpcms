<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<base target='_self'>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>选择作者</caption>
<tr>
<th>ID</th>
<th>姓名</th>
<th>用户名</th>
<th>性别</th>
<th>推荐</th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr onclick="window.returnValue='<?=$info['name']?>';window.close();" style="cursor:pointer">
<td class="align_c"><?=$info['authorid']?></td>
<td><?=$info['name']?></td>
<td><?=$info['username']?></td>
<td class="align_c"><?=$info['gender'] ? '男' : '女'?></td>
<td class="align_c"><?=$info['elite'] ? '√' : ''?></td>
</tr>
<?php 
	}
}
?>
</table>
<div id="pages"><?=$author->pages?></div>
</body>
</html>