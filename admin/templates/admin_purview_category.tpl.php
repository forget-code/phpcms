<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="2">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder" align=center>
  <tr>
    <th width="10%" align="center">选中</th>
    <th width="90%">栏目名称</th>
  </tr>
<form method="post" name="myform" action="">
<?=$categorys?>
</form>
</table>
</body>
</html>