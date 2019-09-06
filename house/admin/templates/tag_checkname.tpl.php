<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<table width="100%" cellpadding="5" cellspacing="1"  height="100%">
  <tr>
    <td align="center" class="tablerow"><?=$message?></td>
  </tr>
  <tr>
    <td align="center" class="tablerow"><input type="button" value="确定" onclick="self.close();">&nbsp;&nbsp;<input type="button" value="关闭" onclick="self.close();"></td>
  </tr>
</table>
</body>
</html>