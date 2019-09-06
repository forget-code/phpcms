<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_info">
  <tr>
    <caption><?=$name?> 模块使用帮助</caption>
	<tr> 
      <td><?=$faq?></td>
    </tr>
</table>
</body>
</html>