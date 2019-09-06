<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="2" cellspacing="1" class="table_form">
<form action="?" method="post" name="myform">
  <input type="hidden" name="mod" value="<?=$mod?>"> 
  <input type="hidden" name="file" value="<?=$file?>"> 
  <input type="hidden" name="action" value="<?=$action?>"> 
  <input type="hidden" name="forward" value="<?=URL?>"> 
  <input type="hidden" name="dosubmit" value="1"> 
  <tr>
    <caption>批量获取关键字</caption>
  <tr>
	<th width="25%"><strong>选择栏目</strong><br />可以同时选择多个栏目</th>
	<td><?=form::select_category($mod, 0, 'catids[]', 'catids', '所有栏目', 0, ' multiple="multiple"  style="height:200px;width:250px;" title="按住“Ctrl”或“Shift”键可以多选，按住“Ctrl”可取消选择"', 2)?></td>
  </tr>
	<tr> 
      <td></td>
      <td><input type="submit" name="dosubmit" value=" 开始 "></td>
    </tr>
	</form>
</table>
</body>
</html>