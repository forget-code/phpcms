<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&module=<?=$module?>" method="post" onsubmit="return Check()">
<table class="table_form" cellspacing="1" cellpadding="0">
<caption> 添加分类 </caption>
	<tr>
      <th width="150"><strong>分类名称</strong></th>
      <td><input type="text" name="info[name]" id="name" size="30" require="true" datatype="require" msg="请填写类别名称" msgid="namemsg"> <?=form::style('info[style]')?> <font color="red">*</font><span id="namemsg"></span></td>
    </tr>
	<tr>
      <th><strong>分类描述</strong></th>
      <td><textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:100px;width:300px;"></textarea></td>
    </tr>
    <tr>
      <td></td>
      <td>
	  <input type="hidden" name="forward" value="?mod=<?=$mod?>&file=<?=$file?>&action=manage&module=<?=$module?>">
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