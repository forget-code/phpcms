<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>

<body onLoad="is_ie();$('#div_category_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=<?=$ishtml?>&type=category&category_urlruleid=<?=$category_urlruleid?>');$('#div_show_urlruleid').load('?mod=<?=$mod?>&file=<?=$file?>&action=urlrule&ishtml=<?=$ishtml?>&type=show&show_urlruleid=<?=$show_urlruleid?>');">
<table cellpadding="2" cellspacing="1" class="table_form">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&modelid=<?=$modelid?>" method="post" name="myform">
    <caption>修改企业黄页模型</caption>
	<tr> 
      <th width="300"><strong>企业黄页模型名称</strong></th>
      <td><input type="text" name="info[name]" value="<?=$name?>" size="30" require="true" datatype="limit" min="1" max="50"  msg="字符长度范围必须为1到50位"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>企业黄页模型描述</strong></th>
      <td><textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:43px;width:208px;"><?=$description?></textarea></td>
    </tr>
	<tr> 
      <th><strong>项目名称</strong></th>
      <td><input type="text" name="info[itemname]" value="<?=$itemname?>" size="30"> <font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>数据表名</strong></th>
      <td><?=DB_PRE?>yp_<input type="text" name="info[tablename]" value="<?=$tablename?>" size="15" readonly></td>
    </tr>
    <tr> 
      <th></th>
      <td> 
	  <input type="hidden" name="ishtml" value="<?=$ishtml?>"> 
	  <input type="hidden" name="forward" value="?mod=<?=$mod?>&file=<?=$file?>&action=manage"> 
	  <input type="submit" name="dosubmit" value=" 确定 "> 
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
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