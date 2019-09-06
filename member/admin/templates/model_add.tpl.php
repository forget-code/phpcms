<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="2" cellspacing="1" class="table_form">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform">
<input type="hidden" name="info[modeltype]" value="2">
  <caption>添加会员模型</caption>
	<tr>
      <th width="15%"><strong>会员模型名称:</strong></th>
      <td width="*"><?=form::text('info[name]', 'modelname', '', 'text', 30, '', 'require="true" datatype="limit|ajax" url="?mod=member&file=member_model&action=checkmodel" min="3" max="20" msg="3到20个字符，不得包含非法字符！|" ')?><font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>会员模型描述:</strong></th>
      <td><?=form::textarea('info[description]', 'description', '', 4, 40)?></td>
    </tr>
	<tr>
      <th><strong>数据表名:</strong></th>
      <td><?=DB_PRE?>member_<?=form::text('info[tablename]', 'tablename', '', 'text', 12, '', 'require="true" datatype="limit|ajax" url="?mod=member&file=member_model&action=checktable" min="1" max="30" msg="表名必须为大于1且小于30的字节数,不得包含非法字符!|"')?><font color="red">*</font></td>
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