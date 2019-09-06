<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="2" cellspacing="1" class="table_form">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&modelid=<?=$modelid?>" method="post" name="myform">
  <caption>修改<?=$name?>模型</caption>
	<tr> 
      <th width="15%"><strong>会员模型名称:</strong></th>
      <td><input type="text" name="info[name]" value="<?=$name?>" size="30" require="true" datatype="limit|ajax" url="?mod=member&file=member_model&action=checkmodel&modelid=<?=$modelid?>" min="3" max="20" msg="3到20个字符，不得包含非法字符！|"><font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>会员模型描述:</strong></th>
      <td><?=form::textarea('info[description]', 'description', $description, 4, 40)?></td>
    </tr>
	<tr> 
      <th><strong>数据表名:</strong></th>
      <td><?=DB_PRE?>member_<?=form::text('info[tablename]', 'tablename', $tablename, 'text', 12, '', 'readonly')?><font color="red">*</font></td>
    </tr>
    <tr>
	  <td></td>
      <td>
      <div class="button_box">
	  <input type="hidden" name="forward" value="?mod=<?=$mod?>&file=<?=$file?>&action=manage"> 
	  <input type="submit" name="dosubmit" value=" 确定 "> 
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
      </div>
	  </td>
    </tr>
	</form>
</table>
</body>
</html>
<script LANGUAGE="javascript">
<!--
$().ready(function() {
	  $('form').checkForm(1);
	});
//-->
</script>