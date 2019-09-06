<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<?php if($catid){ ?>
<div class="pos"><strong>当前栏目</strong>：<a href="?mod=yp&file=category&action=manage">栏目管理</a><?=catpos($catid, '?mod=yp&file=category&action=manage&catid=$catid')?></div>
<?php } ?>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption><?=$catid ? $CATEGORY[$catid]['catname'].'子' : ''?>栏目管理</caption>
	<tr>
		<th width="5%">排序</th>
		<th width="5%">ID</th>
		<th>栏目名称</th>
		<th width="8%">栏目类型</th>
		<th width="10%">绑定模型</th>
		<th width="5%">访问</th>
		<th width="320">管理操作</th>
	</tr>
<?php 
foreach($data as $k=>$r)
{
?>
<tr>
	<td class="align_c"><input name='listorder[<?=$r['catid']?>]' type='text' size='3' value='<?=$r['listorder']?>'></td>
	<td class="align_c"><?=$r['catid']?></td>
	<td><a href='?mod=phpcms&file=category&action=edit&catid=<?=$r['catid']?>&parentid=<?=$r['parentid']?>'><span class='<?=$r['style']?>'><?=$r['catname']?></span></a></td>
	<td class="align_c"><?=$r['type'] == 0 ? '内部栏目' : ($r['type'] == 1 ? '<font color="blue">单网页</font>' : '<font color="red">外部链接</font>')?></td>
	<td class="align_c"><?php if($r['type'] == 0) { ?><a href="?mod=phpcms&file=model_field&action=manage&modelid=<?=$r['modelid']?>"><?=$MODEL[$r['modelid']]['name']?></a><?php } ?></td>
	<td class="align_c"><a href='<?=$r['url']?>' target='_blank'>访问</a></td>
	<td class="align_c">
	<?php if($r['type']>1){ ?>
	<font color="#CCCCCC">添加子栏目</font> | 
	<font color="#CCCCCC">子栏目</font> | 
	<a href='?mod=<?=$mod?>&file=<?=$file?>&action=edit&catid=<?=$r['catid']?>&parentid=<?=$r['parentid']?>'>修改</a> | 
	<font color="#CCCCCC">移动</font> | <font color="#CCCCCC">清空</font> | 
	<a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&catid=<?=$r['catid']?>', '确认删除“<?=$r['catname']?>”栏目吗？')">删除</a>
    <?php }else{ ?>
	<a href='?mod=<?=$mod?>&file=<?=$file?>&action=add&catid=<?=$r['catid']?>'>添加子栏目</a> | 
	<a href='?mod=<?=$mod?>&file=<?=$file?>&action=manage&catid=<?=$r['catid']?>'>子栏目</a> | 
	<a href='?mod=<?=$mod?>&file=<?=$file?>&action=edit&catid=<?=$r['catid']?>&parentid=<?=$r['parentid']?>'>修改</a> | 
	<?php if($r['type']==1) { ?>
	<font color="#CCCCCC">移动</font> | <font color="#CCCCCC">清空</font> | 
	<?php }else{ ?>
	<a href='?mod=<?=$mod?>&file=content_all&action=move&catid=<?=$r['catid']?>'>移动</a> | 
	<a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=recycle&catid=<?=$r['catid']?>', '确认清空“<?=$r['catname']?>”栏目吗？')" >清空</a> | 
	<?php } ?>
	<a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&catid=<?=$r['catid']?>', '确认删除“<?=$r['catname']?>”栏目吗？')">删除</a>
	<?php } ?>
	</td>
</tr>
<?php 
}	
?>
</table>
<div class="button_box"><input name="dosubmit" type="submit" value=" 排序 "> <input name="addmenu" type="button" value="添加栏目" onclick="redirect('?mod=<?=$mod?>&file=<?=$file?>&action=add&catid=<?=$catid?>&forward='+escape('<?=URL?>'))" /></div>
</form>
</body>
</html>