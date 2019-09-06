<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th><?=$name?> 模块使用帮助</th>
  </tr>
	<tr> 
      <td class="tablerow"><?=$faq?></td>
    </tr>
</table>
</body>
</html>