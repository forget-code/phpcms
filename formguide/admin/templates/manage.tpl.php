<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="searchform" method="post" action="?">
<input type="hidden" name="mod" value="<?=$mod?>">
<input type="hidden" name="file" value="<?=$file?>">
<input type="hidden" name="action" value="manage">
<table cellpadding="0" cellspacing="1" class="table_form">
<tr>
	<th class="align_l"><strong>表单名称：<input type="text" name="formname" > <input type="submit" name="dosubmit" value="搜索"></strong></th>   
</tr>
</table>
</form>
<form name="myform" method="post" action="?mod=formguide&file=manage&action=delete">
<input type="hidden" name="mod" value="<?=$mod?>">
<input type="hidden" name="file" value="<?=$file?>">
	<table cellpadding="0" cellspacing="1" class="table_list">
		<caption>表单管理</caption>
		<tr>
			<th width="5%">
				<strong>选中</strong>
			</th>
			<th width="*">
				<strong>名称</strong>(信息数)
			</th>               
			<th width="15%">
				<strong>表名</strong>
			</th>                
			<th width="20%">
			   <strong>简介</strong>
			</th>
			<th style="width:100px;">
				<strong><a href="<?=($order=='addtime ASC')?url_par("order=addtime DESC"):url_par("order=addtime ASC")?>" title="按创建时间排序">创建时间</a></strong>
			</th>
			<th style="width:300px;">
				<strong>管理操作</strong>
			</th>
		</tr>
		<?php
		if(is_array($arr_info) && !empty($arr_info))
		{
			foreach($arr_info as $info)
			{
		?>
		<tr>
			<td class="align_c"><input type="checkbox" name="formid[]" id="checkbox" value="<?=$info[formid]?>"></td>
			<td><a href="<?=$M[url]?>index.php?formid=<?=$info[formid]?>" target="_blank"><?=$info[name]?></a><?php if($formguide_admin->rows(DB_PRE.'form_'.$info[tablename])) {?>(<a href="?mod=<?=$mod?>&file=view&action=manage&formid=<?=$info[formid]?>" title="查看信息"><font color="red"><?=$formguide_admin->rows(DB_PRE.'form_'.$info[tablename])?></font></a>)<?php } ?></td>
			<td>
				<a href="?mod=<?=$mod?>&file=manage_fields&action=manage&formid=<?=$info[formid]?>" title="管理字段"><?=DB_PRE?>form_<?=$info[tablename]?></a>
			</td>
			<td><?=str_cut($info[introduce], 20)?></td>
			<td class="align_c"><?=$info[addtime]?></td>
			<td class="align_c" style="width:360px;">
			<a href="?mod=<?=$mod?>&file=view&action=manage&formid=<?=$info[formid]?>" title="信息列表">信息列表</a> | 
            <a href="?mod=<?=$mod?>&file=manage_fields&action=add&formid=<?=$info[formid]?>" title="添加字段">添加字段</a> |
			<a href="?mod=<?=$mod?>&file=manage_fields&action=manage&formid=<?=$info[formid]?>" title="管理字段">管理字段</a> | 
			<a href="?mod=<?=$mod?>&file=manage_fields&action=preview&formid=<?=$info[formid]?>" title="预览">预览</a> | 
			<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&formid=<?=$info[formid]?>" title="修改">修改</a> | 
			<a href="?mod=<?=$mod?>&file=manage&action=disabled&formid=<?=$info[formid]?>&val=<?=($info['disabled']) ? '0' : '1'?>" title="<?=($info['disabled'] ? '禁用' : '启用')?>"><?=($info['disabled'] ? '禁用' : '<font color="red">启用</font>')?></a> | 
			<a href="#" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&formid=<?=$info[formid]?>', '确认要删除‘<?=$info['name']?>’吗？')" title="删除">删除</a>
			</td>
		</tr>
		<?php
			}
		}
		?>
		</table>      
		<div class="button_box">
			<input name='button' type='button' class="button_style" id='chkall' onclick='checkall()' value='全选'>
			<input name="button" type="submit" value="删除">
		</div>
         <div id="pages">
        	<?=$formguide_admin->pages?>
        </div>
</form>
</body>
</html>