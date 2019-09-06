<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_form">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform">
    <caption>添加关联链接</caption>
	<tr> 
      <th><strong>关联链接名称</strong></th>
      <td><input type="text" name="info[word]" size="30"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>关联链接网址</strong></th>
      <td><input type="text" name="info[url]" value="http://" size="50"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>排序权值</strong></th>
      <td><input type="text" name="info[listorder]" value="0" size="5"> <font color="red">*</font></td>
    </tr>
    <tr> 
      <td></th>
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