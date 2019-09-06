<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<form method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="9">在线支付记录</th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="34%" class="tablerowhighlight">流水号</td>
<td width="10%" class="tablerowhighlight">用户名</td>
<td width="8%" class="tablerowhighlight">金额</td>
<td width="*" class="tablerowhighlight">手续费</td>
<td width="8%" class="tablerowhighlight">支付结果</td>
<td width="12%" class="tablerowhighlight">支付时间</td>
<td width="12%" class="tablerowhighlight">支付银行</td>
<td width="5%" class="tablerowhighlight">操作</td>
</tr>
<?php 
if(is_array($pays))
{
    foreach($pays as $pay)
	{ ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="payid[]" value="<?=$pay['payid']?>"></td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&payid=<?=$pay['payid']?>"><?=$pay['orderid']?></a></td>
<td><a href="?mod=member&file=member&action=view&username=<?=urlencode($pay['username'])?>"><?=$pay['username']?></a></td>
<td><?=$pay['amount']?></td>
<td><?=$pay['trade_fee']?></td>
<td><?=$STATUS[$pay['status']]?></td>
<td><?=$pay['receivetime'] ? date('Y-m-d h:i:s', $pay['receivetime']) : ''?></td>
<td><?=$pay['bank']?></td>
<td>
<?php if(!$pay['status']){?>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=check&payid=<?=$pay['payid']?>">审核</a>
<?php } ?>
</td>
</tr>
<?php
	} 
}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全选/反选</td>
    <td>
<input type="submit" name="submit" value=" 删除选定的订单 " onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'">&nbsp;&nbsp;
    </td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><?=$pages?></td>
  </tr>
</table>
</form>
</body>
</html>
