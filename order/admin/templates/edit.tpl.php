<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javaScript">
function set_amount()
{
	var price = Math.abs($('#price').val());
	var number = Math.abs($('#number').val());
	var carriage = Math.abs($('#carriage').val());
	var amount = price*number + carriage;
	$('#amount').html(amount);
}
</script>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=edit&orderid=<?=$orderid?>">
<input type="hidden" name="unit" value="{$unit}" />
<input name='forward' type='hidden' value='<?=$forward?>'>
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>修改订单</caption>
	<tr>
	   <th width="15%">产品：</th>
	   <td><a href="<?=$goodsurl?>"><?=$goodsname?></a></td>
	</tr>
	<tr>
	   <th>单价：</th>
	   <td><input type="text" name="data[price]" id="price" value="<?=$price?>" size="10" onblur="set_amount()"> 元/<?=$unit?></td>
	</tr>
	<tr>
	   <th>数量：</th>
	   <td><input type="text" name="data[number]" id="number" value="<?=$number?>" size="5" onblur="set_amount()"> <?=$unit?></td>
	</tr>
	<tr>
	   <th>运费：</th>
	   <td><input type="text" name="data[carriage]" id="carriage" value="<?=$carriage?>" size="10" onblur="set_amount()"> 元</td>
	</tr>
	<tr>
	   <th>付款金额：</th>
	   <td style="color:red;font-weight:bold"><span id="amount"><?=$amount?></span>元</td>
	</tr>
	<tr>
	   <th>订单状态：</th>
	   <td><?=$order->STATUS[$status]?></td>
	</tr>
	<tr>
	   <th>买家：</th>
	   <td><a href="<?=member_view_url($userid)?>"><?=$username?></a></td>
	</tr>
	<tr>
	   <th>下单时间：</th>
	   <td><?=date('Y-m-d H:i:s', $time)?></td>
	</tr>
	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" value=" 确定 " onclick="set_amount()"></td>
	</tr>
</table>
</form>
</body>
</html>