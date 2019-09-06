<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="images/js/validator.js"></script>
<body onload="$('form').checkForm(1);">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>添加分类</caption>
	<tr>
      <th width="30%"><font color="red">*</font><strong>分类</strong><br />只能由字母、数字和下划线组成</th>
      <td><input type="text" name="type" size="15" require="true" datatype="limit|ajax" min="2" max="15" url="?mod=<?=$mod?>&file=<?=$file?>&action=check" msg="字符长度范围必须为2到15位|"> </td>
    </tr>
	<tr>
      <th width="30%"><font color="red">*</font><strong>名称</strong><br />可使用中文</th>
      <td><input type="text" name="name" size="30" require="true" datatype="limit" min="1" max="20" msg="字符长度范围必须为1到20位"></td>
    </tr>
	<tr>
      <th width="30%"><strong>API密钥</strong><br />全站搜索API通信的密钥</th>
      <td><input type="text" name="md5key" size="32" require="true" datatype="limit" min="0" max="32" msg="字符长度范围必须为0到32位"></td>
    </tr>
	<tr>
      <th width="30%"><strong>类别描述</strong></th>
      <td><textarea name="description" rows="2" cols="20" id="description" class="inputtext" style="height:100px;width:300px;"></textarea></td>
    </tr>
    <tr>
      <td></td>
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
<script LANGUAGE="javascript">
<!--
$().ready(function() {
	  $('form').checkForm(1);
	});
//-->
</script>