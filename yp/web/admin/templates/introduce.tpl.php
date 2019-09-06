<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<form action="" method="post" name="myform" >
<BR>
<table width="100%"  border="0" cellpadding="5" cellspacing="2" class="tableborder">
<th colspan=3>企业简介管理</th>
<tr>
<td valign="top" >
<textarea name="introduce" id="introduce" cols="100" rows="25"><?=$introduce?></textarea> <?=editor("introduce", 'phpcms','100%','400')?>
</td>
</tr>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1">
  <tr>
    <td width="40%">
	</td>
    <td  height="25">
	<input type="submit" name="dosubmit" value=" 确认修改 " />
	</td>
  </tr>
</table>
</form>
</body>
</html>