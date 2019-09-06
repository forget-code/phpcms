<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="2" cellspacing="1" class="table_form">
    <caption><?=$username?> 详细信息</caption>
    <tr> 
      <th width="12%"><strong>用户名</strong></th>
      <td><?=$username?></td>
    </tr>
	<tr> 
      <th><strong>角色</strong></th>
      <td><?=$roles?></td>
    </tr>
</table>
</body>
</html>