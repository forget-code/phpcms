<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_form">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&workflowid=<?=$workflowid?>&processid=<?=$processid?>" method="post" name="myform">
    <caption>修改工作流步骤</caption>
	<tr> 
      <th><strong>步骤名称</strong></th>
      <td><input type="text" name="info[name]" value="<?=$name?>" size="30"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>步骤描述</strong></th>
      <td><textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:100px;width:300px;"><?=$description?></textarea></td>
    </tr>
	<tr> 
      <th><strong>通过的操作名称</strong></th>
      <td><input type="text" name="info[passname]" value="<?=$passname?>" size="30"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>通过的状态</strong></th>
      <td><?=form::select($STATUS, 'info[passstatus]', 'passstatus', $passstatus)?> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>退回的操作名称</strong></th>
      <td><input type="text" name="info[rejectname]" value="<?=$rejectname?>" size="30"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>退回的状态</strong></th>
      <td><?=form::select($STATUS, 'info[rejectstatus]', 'rejectstatus', $rejectstatus)?> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>可执行此步骤的角色</strong></th>
      <td><?=form::checkbox($ROLE, 'priv_roleid', 'priv_roleid', $priv_roleids, 5)?></td>
    </tr>
	<tr> 
      <th><strong>此步骤可操作的状态</strong></th>
      <td><?=form::checkbox($STATUS, 'status', 'status', $status, 5)?></td>
    </tr>

    <tr> 
      <th></th>
      <td> 
	  <input type="hidden" name="forward" value="?mod=<?=$mod?>&file=<?=$file?>&action=manage&workflowid=<?=$workflowid?>"> 
	  <input type="submit" name="dosubmit" value=" 确定 "> 
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>
	</form>
</table>
</body>
</html>