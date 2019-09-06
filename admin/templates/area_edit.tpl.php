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
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=edit&areaid=<?=$areaid?>" onSubmit='return CheckForm();'>
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>修改地区</caption>
  <tr>
  <th><strong>所属地区</strong></th>
  <td>
<?=form::select_area('info[parentid]', '', '无（作为一级地区）', 0, $parentid)?>  <font color="red">*</font>
  </td>
  </tr>
    <tr>
      <th><strong>地区名称</strong></th>
      <td><input name='info[name]' type='text' id='name' size='40' maxlength='50' value='<?=$name?>'>  <?=form::style('info[style]',$style)?></td>
    </tr>
	<tr>
      <th><strong>地区首页模板</strong></th>
      <td><?=form::select_template('phpcms', 'info[template]', 'template', $template, '', 'area')?></td>
    </tr>
	<tr>
      <th></th>
      <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
    </tr>
</table>
</form>
</body>
</html>