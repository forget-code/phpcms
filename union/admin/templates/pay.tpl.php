<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>推广联盟结算记录</th>
  </tr>
<tr align="center">
<td width="14%" class="tablerowhighlight">用户名</td>
<td width="22%" class="tablerowhighlight">结算日期</td>
<td width="10%" class="tablerowhighlight">结算金额</td>
<td width="18%"  class="tablerowhighlight">支付宝帐号</td>
<td width="18%"  class="tablerowhighlight">操作人</td>
</tr>
<?php
if(is_array($pays)) 
{
foreach($pays AS $pay) {
?>
<tr height="20" align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><a href="?mod=union&file=settle&userid=<?=$pay['userid']?>"><?=$pay['username']?></a></td>
<td><?=$pay['adddate']?></td>
<td><?=$pay['amount']?> 元</td>
<td><?=$pay['alipay']?></td>
<td><a href="?mod=member&file=member&action=view&username=<?=urlencode($pay['inputer'])?>"><?=$pay['inputer']?></a></td>
</tr>
<?php
	}
}
?>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td height="20" align="center"><?=$pages?></td>
  </tr>
</table>

</body>
</html>