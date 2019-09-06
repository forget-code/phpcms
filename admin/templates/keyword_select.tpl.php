<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<base target='_self'>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>关键词管理</caption>
<tr>
<th>关键词</th>
<th>引用次数</th>
<th>点击次数</th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr onclick="window.returnValue='<?=$info['tag']?>';window.close();" style="cursor:pointer">
<td><?=$info['tag']?></td>
<td><?=$info['usetimes']?></td>
<td><?=$info['hits']?></td>
</tr>
<?php 
	}
}
?>
</table>
<div id="pages"><?=$keyword->pages?></div>
</body>
</html>