<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="images/js/form.js"></script>
<style type="text/css" >
img { 
vertical-align: middle;
max-width:600px;   /* FF IE7 */
width:expression(this.width > 600 && this.width > this.height ? 600 : true);
overflow:hidden;
}
</style>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>详细信息</caption>
 <?php 
 foreach($info as $k=>$v)
 {
 ?>
	<tr> 
      <th width="25%"><strong><?=$coutput->fields[$k][name]?></strong>
	  </td>
      <td><?=$v?></td>
    </tr>
<?php 
}
?>
</table>
</body>
</html>