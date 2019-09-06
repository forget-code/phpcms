<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="table_form">
    <caption>添加推荐位</caption>
	<tr> 
      <th><font color="red">*</font> <strong>推荐位名称</strong></th>
      <td><input type="text" name="info[name]" size="30" require="true" datatype="limit" min="2" max="30" msg="不得少于2个字符超过30个字符"></td>
    </tr>
	<tr> 
      <th><font color="red">*</font> <strong>排序权值</strong></th>
      <td><input type="text" name="info[listorder]" value="0" size="5" require="true" datatype="number" msg="请输入数字"></td>
    </tr>
	<tr> 
      <th><strong>拥有推荐权限的角色</strong></th>
      <td><?=form::checkbox($ROLE, 'roleids', 'roleids', '', 5);?></td>
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