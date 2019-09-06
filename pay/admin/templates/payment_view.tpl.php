<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<style type='text/css'>
td {text-align:center;}
</style>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>
  支付方式列表
  </caption>
  <tr>
     <th>支付方式名称</th>
	 <th>插件版本</th>
	 <th>插件作者</th>
	 <th>费用</th>
	 <th>排序</th>
	 <th>操作</th>
  </tr>
  <?php foreach ($payments['data'] as $payment) {?>
	 <tr>
	  <td ><?=$payment['pay_name']?></td>
	  <td><?=$payment['version']?></td>
	  <td><?=$payment['author']?></td>
	  <td><span><?=$payment['pay_fee']?>%</span></td>
	  <td><span><?=$payment['pay_order']?></span></td>
	  <?php if (!$payment['enabled']) {?>
		<td><a href="?mod=<?=$mod?>&file=paymethod&action=add&code=<?=$payment['pay_code']?>">安装</a></td>
	  <?php } else {?>
	  <td><a href="?mod=<?=$mod?>&file=paymethod&action=edit&id=<?=$payment['pay_id']?>">编辑</a>|
      <a href="?mod=<?=$mod?>&file=paymethod&action=drop&id=<?=$payment['pay_id']?>">卸载</a></td>
	  <?php }?>
	 </tr>
<?php }?>
</table></body>
</html>