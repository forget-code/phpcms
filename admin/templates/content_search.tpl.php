<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="get" action="">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>搜索信息</caption>
 <?php 
 foreach($forminfos as $field=>$info)
 {
 ?>
	<tr> 
      <th width="25%"><strong><?=$info['name']?></strong></th>
      <td><?=$info['form']?> </td>
    </tr>
<?php 
}
?>
	<tr> 
      <th width="25%"><strong>排序</strong></th>
      <td><?=form::select($orderfields, 'orderby', 'orderby', 'contentid DESC', 1)?></td>
    </tr>
    <tr> 
      <td></td>
      <td>
	  <input type="hidden" name="mod" value="<?=$mod?>"> 
	  <input type="hidden" name="file" value="content"> 
	  <input type="hidden" name="action" value="search"> 
	  <input type="submit" name="dosubmit" value=" 搜索 "> 
	  </td>
    </tr>
</table>
</form>
</body>
</html>