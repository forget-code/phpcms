<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption><?=$areaid ? $AREA[$areaid]['name'] : ''?>地区管理</caption>
	<tr>
		<th width="5%">排序</th>
		<th width="5%">ID</th>
		<th>地区名称</th>
		<th width="320">管理操作</th>
	</tr>
<?php 
foreach($data as $k=>$r)
{
?>
<tr>
	<td class="align_c"><input name='listorder[<?=$r['areaid']?>]' type='text' size='3' value='<?=$r['listorder']?>'></td>
	<td class="align_c"><?=$r['areaid']?></td>
	<td><a href='?mod=phpcms&file=area&action=edit&areaid=<?=$r['areaid']?>&parentid=<?=$r['parentid']?>'><span class='<?=$r['style']?>'><?=$r['name']?></span></a></td>
	<td class="align_c">
	<a href='?mod=<?=$mod?>&file=<?=$file?>&action=add&areaid=<?=$r['areaid']?>'>添加子地区</a> | 
	<?php if($r['child']) { ?><a href='?mod=<?=$mod?>&file=<?=$file?>&action=manage&areaid=<?=$r['areaid']?>'>子地区</a> | <?php } ?>
	<a href='?mod=<?=$mod?>&file=<?=$file?>&action=edit&areaid=<?=$r['areaid']?>&parentid=<?=$r['parentid']?>'>修改</a> | 
	<a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&areaid=<?=$r['areaid']?>', '确认删除“<?=$r['name']?>”地区吗？')">删除</a>
	</td>
</tr>
<?php 
}	
?>
</table>
<div class="button_box"><input name="dosubmit" type="submit" value=" 排序 "></div>
</form>
</body>
</html>