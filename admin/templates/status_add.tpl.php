<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>添加稿件状态</caption>
  	<tr> 
      <th><strong>状态值</strong></th>
      <td>
	  <?=form::select($options, 'info[status]', 'status', $status)?>
	  <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>状态名称</strong></th>
      <td><input type="text" name="info[name]" size="30"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>状态描述</strong></th>
      <td><textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:100px;width:300px;"></textarea></td>
    </tr>
    <tr> 
      <th></th>
      <td> 
	  <input type="hidden" name="forward" value="?mod=<?=$mod?>&file=<?=$file?>&action=manage"> 
	  <input type="submit" name="dosubmit" value=" 确定 "> 
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>
	</form>
</table>
</body>
</html>