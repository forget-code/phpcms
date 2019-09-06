<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<base target='_self'>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>来源管理</caption>
<tr>
<th>来源名称</th>
<th>来源网址</th>
<th>引用次数</th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr onclick="window.returnValue='<?=$info['name']?>|<?=$info['url']?>';window.close();" style="cursor:pointer">
<td><?=$info['name']?></td>
<td align="left"><?=$info['url']?></td>
<td><?=$info['usetimes']?></td>
</tr>
<?php 
	}
}
?>
</table>
<div id="pages"><?=$copyfrom->pages?></div>
</form>
</body>
</html>