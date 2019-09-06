<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&workflowid=<?=$workflowid?>" method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="table_form">
    <caption>添加工作流步骤</caption>
	<tr> 
      <th><strong>步骤名称</strong></th>
      <td><input type="text" name="info[name]" size="30"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>步骤描述</strong></th>
      <td><textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:100px;width:300px;"></textarea></td>
    </tr>
	<tr> 
      <th><strong>通过的操作名称</strong></th>
      <td><input type="text" name="info[passname]" size="30"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>通过的状态</strong></th>
      <td><?=form::select($STATUS, 'info[passstatus]', 'passstatus', $passstatus)?> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>退回的操作名称</strong></th>
      <td><input type="text" name="info[rejectname]" size="30"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>退回的状态</strong></th>
      <td><?=form::select($STATUS, 'info[rejectstatus]', 'rejectstatus', $rejectstatus)?> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>可执行此步骤的角色</strong></th>
      <td><?=form::checkbox($ROLE, 'priv_roleid', 'priv_roleid', '', 5)?></td>
    </tr>
	<tr> 
      <th><strong>此步骤可操作的状态</strong></th>
      <td><?=form::checkbox($STATUS, 'status', 'status', '', 5)?></td>
    </tr>

    <tr> 
      <th></th>
      <td> 
	  <input type="hidden" name="forward" value="?mod=<?=$mod?>&file=<?=$file?>&action=manage&workflowid=<?=$workflowid?>"> 
	  <input type="submit" name="dosubmit" value=" 确定 "> 
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>
</table>
</form>
</body>
</html>