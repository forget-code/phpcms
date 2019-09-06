<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
	<caption>按模型搜索</caption>
	<tr>
		<td>
		<a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">一般搜索</a>
		<?php
			foreach($member->MODEL as $model)
			{
		?>
		 <a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&modelid=<?=$model['modelid']?>"><?=$model['name']?></a>  
		<?php
			}
		?>
		</td>
	</tr>
</table>
<table cellpadding="2" cellspacing="1" class="table_form">
  <caption>会员搜索</caption>
<form method="get" name="search" action="?">
<input type="hidden" name="issearch" value="1">
<?php if($modelid) {?>
<?php foreach($where as $field=>$r) { ?>
    <tr>
      <th width="30%"><?=$r[name]?></th>
      <td><?=$r[form]?></td>
    </tr>
<?php } ?>
<?php if($order) { ?>
    <tr>
      <th>排序方式</th>
      <td><?=form::select($order, 'orderby', 'orderby', 'a.userid DESC', 1)?></td>
    </tr>
	<input type="hidden" name="modelid" value="<?=$modelid?>" /></td>
<?php } ?>
<?php }else{ ?>
<tr>
<th align="center" width="20%"><strong>会员名：</strong></td>
<td><input name='username' type='text' size='15' value='<?=$username?>'></td>
</tr>
<tr>
<th><strong>会员组：</strong></td>
<td><?=form::select($GROUP, 'groupid', 'groupid')?></td>
</tr>
<tr>
<th><strong>扩展会员组：</strong></th>
<td><?=form::select($ext_group, 'extgroup', 'extgroup')?></td>
</tr>
<tr>
<th><strong>会员状态：</strong></td>
<td>
<select name='disabled'>
<option value='-1'>不限</option>
<option value='0'>正常</option>
<option value='1'>锁定</option>
</select>
</td>
</tr>
<tr>
<th><strong>所在地区：</strong></td>
<td>
<?=form::select_area('areaid', 'areaid', '请选择')?>
</tr>
<tr>
<th><strong>E-mail：</strong></td>
<td><input name='email' type='text' size='30' value='<?=$email?>'></td>
</tr>
<tr>
<th><strong>资金余额：</strong></td>
<td><input name='frommoney' type='text' size='5' value='<?=$frommoney?>'> - <input name='tomoney' type='text' size='5' value='<?=$tomoney?>'></td>
</tr>
<tr>
<th><strong>可用点数：</strong></td>
<td colspan="3"><input name='frompoint' type='text' size='5' value='<?=$frompoint?>'> - <input name='topoint' type='text' size='5' value='<?=$topoint?>'></td>
</tr>
<?php } ?>
<tr>
<th></th>
<td>
<input name="modelid" type="hidden" value="<?=$modelid?>">
<input name='mod' type='hidden' value='<?=$mod?>'>
<input name='file' type='hidden' value='<?=$file?>'>
<input name='action' type='hidden' value='manage'>
<input name='dosubmit' type='submit' value=' 会员搜索 '>
<input name='reset' type='reset' value='重新填写'>
</td>
  </tr>
</form>
</table>
</body>
</html>
<script language="javascript">
$('#modelid').change(function(){
	location="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&modelid="+this.value;
});
</script>