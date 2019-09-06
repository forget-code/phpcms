<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form action="?" method="get" name="myform_index">
  <input type="hidden" name="mod" value="<?=$mod?>"> 
  <input type="hidden" name="file" value="<?=$file?>"> 
  <input type="hidden" name="action" value="<?=$action?>"> 
  <input type="hidden" name="forward" value="<?=URL?>"> 
  <input type="hidden" name="dosubmit" value="1"> 
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>更新专题首页</caption>
	<tr> 
      <td style='text-align:center'><input type="button" name="dosubmit4" value=" 开始更新 " onclick="myform_index.action.value='index';myform_index.submit();"></td>
    </tr>
</table>
</form>
<br />
<form action="?" method="get" name="myform_type">
  <input type="hidden" name="mod" value="<?=$mod?>"> 
  <input type="hidden" name="file" value="<?=$file?>"> 
  <input type="hidden" name="action" value="<?=$action?>"> 
  <input type="hidden" name="forward" value="<?=URL?>"> 
  <input type="hidden" name="dosubmit" value="1"> 
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>更新类别页</caption>
  <tr>
	<th>选择类别范围</th>
	<th>生成html</th>
  </tr>
	<tr> 
      <td style='text-align:center'><?=form::select_type($mod, 'typeids[]', 'typeids', '所有类别', 0, ' multiple="multiple"  style="height:200px;width:250px;" title="按住“Ctrl”或“Shift”键可以多选，按住“Ctrl”可取消选择"')?></td>
      <td><font color="red">每轮更新 <input type="text" name="pagesize" value="100" size="4"> 个网页</font> <input type="button" name="dosubmit1" value=" 开始更新 " onclick="myform_type.action.value='type';myform_type.submit();"></td>
    </tr>
</table>
</form>
<br />
<form action="?" method="get" name="myform_show">
  <input type="hidden" name="mod" value="<?=$mod?>"> 
  <input type="hidden" name="file" value="<?=$file?>"> 
  <input type="hidden" name="action" value="<?=$action?>"> 
  <input type="hidden" name="forward" value="<?=URL?>"> 
  <input type="hidden" name="dosubmit" value="1"> 
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>更新专题页</caption>
  <tr>
	<th>选择类别范围</th>
	<th>生成html</th>
  </tr>
	<tr> 
      <td style='text-align:center'><?=form::select_type($mod, 'typeids[]', 'typeids', '所有类别', 0, ' multiple="multiple"  style="height:200px;width:250px;" title="按住“Ctrl”或“Shift”键可以多选，按住“Ctrl”可取消选择"')?></td>
      <td><font color="red">每轮更新 <input type="text" name="pagesize" value="100" size="4"> 个网页</font> <input type="button" name="dosubmit1" value=" 开始更新 " onclick="myform_show.action.value='show';myform_show.submit();"></td>
    </tr>
</table>
</form>
</body>
</html>