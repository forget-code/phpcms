<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<form name="myform" action="" method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_form">
 <caption>添加新方案</caption>
  <tr>
    <th class="align_left"><strong>方案名称</strong></th>
    <td colspan="3"><input type="text" name="name" size="30"> 提示：最少为2个选项，最多为15个选项</td>
  </tr>
  <tr><th  class="align_left"><strong>选项ID</strong></th><th class="align_left"><strong>名称</strong></th><th class="align_left"><strong>图片地址</strong></th></tr>
  <?php
  for($i=1;$i<16;$i++)
  {?>
  <tr>
    <td class="align_left">选项<?=$i?>、</td><td><input type="text" name="m[]" size="30"></td><td><input type="text" name="p[]" size="60"></td>
  </tr>
 <?php
  }
  ?>
  <tr>
    <td class="align_left" colspan="3"><input type="submit" name="dosubmit" value=" 添加 "></td>
  </tr>
</table>
</form>
</body>
</html>