<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>

<script language='JavaScript' type='text/JavaScript'>
function CheckForm(){
  if(document.myform.name.value==''){
    ShowTabs(0);
    alert('请输入地区名称！');
    document.myform.name.focus();
    return false;
  }
}
</script>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add" onSubmit='return CheckForm();'>
<input type="hidden" name="forward" value="<?=$forward?>" />
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>添加地区</caption>
  <tr>
  <th><strong>所属地区</strong></th>
  <td>
<?=form::select_area('info[parentid]', '', '无（作为一级地区）', 0, $areaid)?>  <font color="red">*</font>
  </td>
  </tr>
    <tr>
      <th><strong>地区名称</strong></th>
      <td><textarea name='info[name]' id='name' style="width:200px;height:36px;overflow:visible;"></textarea>
		<?=form::style('area[style]','')?><br/>
		允许批量添加，一行一个，点回车换行
		</td>
    </tr>
	<tr>
      <th><strong>地区页模板</strong></th>
      <td><?=form::select_template('phpcms', 'info[template]', 'template', 'area', '', 'area')?></td>
    </tr>
	<tr>
      <th></th>
      <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
    </tr>
</table>
</form>
</body>
</html>