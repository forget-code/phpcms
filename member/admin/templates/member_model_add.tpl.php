<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>添加用户信息</caption>
 <?php 
 foreach($forminfos as $field=>$info)
 {
 ?>
	<tr> 
      <th width="25%"><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <strong><?=$info['name']?></strong> <br />
	  <?=$info['tips']?>
	  </th>
      <td><?=$info['form']?> </td>
    </tr>
<?php 
}
?>
</body>
</html>