<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<table align="center" cellpadding="0" cellspacing="1" class="table_list">
    <caption><?=$parentid && $parentname ? '['.$parentname.'] 子' : ''?>菜单管理</caption>
<tr>
<th width="5%">排序</th>
<th width="5%">ID</th>
<th>名称</th>
<th width="10%">打开窗口</th>
<th width="5%">类型</th>
<th width="30%">管理操作</th>
</tr>
<?php
	foreach($infos as $id=>$menu)
	{
?>
<tr>
<td class="align_c"><input type="text" name="listorder[<?=$menu['menuid']?>]" value="<?=$menu['listorder']?>" size="5"></td>
<td class="align_c"><?=$menu['menuid']?></td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&parentid=<?=$menu['menuid']?>&parentname=<?=urlencode($menu['name'])?>"><?=$menu['name']?></a></td>
<td class="align_c"><?=$TARGET[$menu['target']]?></td>
<td class="align_c"><?=$menu['isfolder'] ? '目录' : '链接'?></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&parentid=<?=$menu['menuid']?>&parentname=<?=urlencode($menu['name'])?>">添加子菜单</a> |
<?php if($menu['isfolder']){ ?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&parentid=<?=$menu['menuid']?>&parentname=<?=urlencode($menu['name'])?>">子菜单</a> <?php }else{ ?><font color="#cccccc">子菜单</font><?php } ?> |
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&menuid=<?=$menu['menuid']?>">修改</a> |
<a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&menuid=<?=$menu['menuid']?>&forward='+escape('<?=$forward?>'), '确认删除菜单“<?=$menu['name']?>”吗')">删除</a>
</td>
</tr>
<?php
	}
?>
</table>

<div class="button_box">
	 <input name="dosubmit" type="submit" value=" 排序 " /> 
	 <input name="addmenu" type="button" value="添加菜单" onclick="redirect('?mod=phpcms&file=menu&action=add&parentid=<?=$parentid?>&parentname=<?=urlencode($parentname)?>')" />
</div>
<div id="pages">
	<?=$m->pages?>
</div>

</form>

</body>
</html>