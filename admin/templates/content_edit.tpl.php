<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="images/js/form.js"></script>
<body>
<?=$menu?>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&contentid=<?=$contentid?>" method="post" name="myform" enctype="multipart/form-data">
<table cellpadding="0" cellspacing="1" class="table_form">
  <tbody id="Tabs0" style="display:">
  <caption>修改信息</caption>
 <?php
 foreach($forminfos as $field=>$info)
 {
 ?>
	<tr>
      <th width="20%"><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <strong><?=$info['name']?></strong><br />
	  <?=$info['tips']?>
	  </th>
      <td><?=$info['form']?></td>
    </tr>
<?php
}
?>
</tbody>
    <tr>
      <td></td>
      <td>
	  <input type="hidden" name="catid" value="<?=$catid?>">
	  <input type="hidden" name="forward" value="<?=$forward?>">
	  <input type="submit" name="dosubmit" value=" 确定 ">
	  &nbsp; <input type="button" name="preview" value=" 预览 " onclick="preview_content();">
	  &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>
</table>
</form>
<script LANGUAGE="javascript">
<!--
function preview_content()
{
	myform.action = "preview.php";
	myform.target = "_blank"; 
	myform.submit(); 
	myform.action = "?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&catid=<?=$catid?>&modelid=<?=$modelid?>";
	myform.target="_self";
}
$().ready(function() {
	  $('form').checkForm(1);
	});
//-->
</script>
</body>
</html>