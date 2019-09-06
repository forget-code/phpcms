<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>模型设置</caption>
	<tr>
	  <th width="30%"><strong>允许同一IP多次提交：</strong></th>
	  <td>
		<input type='radio' name='setting[allowmultisubmit]' value='1'  <?php if($allowmultisubmit){ ?>checked <?php } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='radio' name='setting[allowmultisubmit]' value='0'  <?php if(!$allowmultisubmit){ ?>checked <?php } ?>>否
	  </td>
	</tr>
	<tr>
	  <th><strong>允许匿名提交表单：</strong></th>
	  <td>
		<input type='radio' name='setting[allowunregsubmit]' value='1'  <?php if($allowunregsubmit){ ?>checked <?php } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='radio' name='setting[allowunregsubmit]' value='0'  <?php if(!$allowunregsubmit){ ?>checked <?php } ?>>否
	  </td>
	</tr>
    <tr>
	  <th><strong>允许发送邮件：</strong></th>
	  <td>
		<input type='radio' name='setting[allowsendemail]' value='1'  <?php if($allowsendemail){ ?>checked <?php } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='radio' name='setting[allowsendemail]' value='0'  <?php if(!$allowsendemail){ ?>checked <?php } ?>>否
	  </td>
	</tr>
	<tr>
	  <th><strong>模块路径：</strong></th>
	  <td>
		<input type="text" name="setting[url]" value="<?=$url?>" />
	  </td>
	</tr>
	<tr>
	  <th></th>
	  <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
	</tr>
</table>
</form>
</body>
</html>