<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_from">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&modelid=<?=$modelid?>" method="post" name="myform">
    <caption>模型预览</caption>
 <?php 
 foreach($forminfos as $fieldid=>$info)
 {
 ?>
	<tr> 
      <th><strong><?=$info['name']?></strong><br />
	  <?=$info['tips']?>
	  </th>
      <td><?=$info['form']?> <?php if($info['minlength']){ ?><font color="red">*</font><?php } ?></td>
    </tr>
<?php 
}
?>
    <tr> 
      <td></td>
      <td> 
	  <input type="hidden" name="forward" value="<?=$forward?>"> 
	  <input type="submit" name="dosubmit" value=" 确定 "> 
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>
	</form>
</table>
</body>
</html>