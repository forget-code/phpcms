<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="2" cellspacing="1" class="table_form">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&tagid=<?=$tagid?>" method="post" name="myform">
    <caption>修改关键词</caption>
	<tr> 
      <th width="20%"><font color="red">*</font> <strong>关键词</strong></th>
      <td><input type="text" name="info[tag]" value="<?=$tag?>" size="30" maxlength="20" require="true" datatype="limit" min="2" max="20" msg="不得少于2个字符超过20个字符" msgid="tag_notice"> <?=form::style('info[style]',  $style)?><span id="tag_notice"></span></td>
    </tr>
	<tr> 
      <th><font color="red">*</font> <strong>排序权值</strong></th>
      <td><input type="text" name="info[listorder]" value="<?=$listorder?>" size="5" require="true" datatype="number" msg="请输入数字" ></td>
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
<script language="javascript" type="text/javascript">
$().ready(function() {
	  $('form').checkForm(1);
	});
</script>