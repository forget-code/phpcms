<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="images/js/validator.js"></script>
<body>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&module=<?=$module?>" method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>添加订阅类别</caption>
  <tr>
    <th width="25%"><strong>类别名称</strong></th>
    <td width="75%"><input type="text" name="info[name]" value="<?=$name?>" size="30" require="true" datatype="require" msg="请填写类别名称" msgid="msgid1"/> <?=form::style('info[style]', $style)?> <font color="red">*</font><span id="msgid1"/></td>
  </tr>
  <tr>
    <th><strong>类别描述</strong></th>
    <td><textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext"  style="height:100px;width:300px;"></textarea></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td><input type="hidden" name="forward" value="?mod=<?=$mod?>&file=<?=$file?>&action=manage&module=<?=$module?>">
	  <input type="submit" name="dosubmit" value="确定">
      &nbsp; <input type="reset" name="reset" value="清除"></td>
  </tr>
</table></form></body>
</html>
<script language="javascript" type="text/javascript">
$().ready(function() {
	  $('form').checkForm(1);
	});
</script>