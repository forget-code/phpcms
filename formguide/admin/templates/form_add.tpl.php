<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&catid=<?=$catid?>&modelid=<?=$modelid?>" method="post" name="myform"  enctype="multipart/form-data">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>表单预览</caption>
 <?php 
 foreach($forminfos as $field=>$info)
 {
 ?>
	<tr> 
      <th><strong><?=$info['name']?> <?php if($info['star']){ ?><font color="red">*</font><?php } ?></strong><br />
	  <?=$info['tips']?>
      
	  </th>
      <td><?=$info['form']?> </td>
    </tr>
<?php 
}
?>
    <tr> 
      <th></th>
      <td> 
	  <input type="hidden" name="forward" value="<?=$forward?>"> 
	  <input type="submit" name="dosubmit" value=" 确定 "> 
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>
</table>
</form>
</body>
</html>