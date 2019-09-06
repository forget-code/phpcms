<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&roleid=<?=$roleid?>" method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="table_form">
    <caption>修改角色</caption>
	<tr> 
      <th width="20%"><font color="red">*</font> <strong>角色名称</strong></th>
      <td><input type="text" name="info[name]" value="<?=$name?>" size="30" require="true" datatype="limit" min="2" max="50" msg="不得少于2个字符超过50个字符"></td>
    </tr>
	<tr> 
      <th><strong>角色描述</strong></th>
      <td><textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:100px;width:500px;"><?=$description?></textarea></td>
    </tr>
    <tr> 
      <th></th>
      <td> 
	  <input type="hidden" name="forward" value="?mod=<?=$mod?>&file=<?=$file?>&action=manage"> 
	  <input type="submit" name="dosubmit" value=" 确定 "> 
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>
</table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
$().ready(function() {
	  $('form').checkForm(1);
	});
</script>