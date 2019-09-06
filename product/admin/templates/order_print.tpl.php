<?php 
defined('IN_PHPCMS') or exit('Access Denied');
?>
    
<style>
td{font-size:10pt;}
</style>
<table width="98%"  cellspacing="1" cellpadding="3" align="center" bgcolor="#333333">
    <tr bgcolor="#FFFFFF">
      <td width="50%" colspan="4" align="center"><h1 align="center">订单信息</h1></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>
	  
	  
<table width="98%"  cellspacing="1" cellpadding="3" align="center" bgcolor="#333333">
   <tr bgcolor="#EEEEEE">
      <td  colspan="2"  align="center"> 订单信息</td>
  </tr>
   <tr bgcolor="#FFFFFF">
      <td width="30%"> 订单号:</td>
      <td><?=$odr_info['odr_No']?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
      <td> 下单时间:</td>
      <td><?=$odr_info['addtime']?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
      <td> 用户名:</td>
      <td><?=$odr_info['username']?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
      <td> 审核状态:</td>
      <td><?=$odr_info['isverify']?> 操作人：<?=$odr_info['verifyuser']?> 时间：<?=$odr_info['verifytime']?> </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td> 付款状态:</td>
    <td><?=$odr_info['ispay']?> 操作人：<?=$odr_info['payuser']?> 时间：<?=$odr_info['paytime']?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td> 发货状态:</td>
    <td><?=$odr_info['isship']?> 操作人：<?=$odr_info['shipuser']?> 时间：<?=$odr_info['shiptime']?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td> 付款方式:</td>
    <td><?=$odr_info['paytype']?></td>
  </tr>
</table>	  </td>
      <td>
	  
<table width="98%"  cellspacing="1" cellpadding="3" align="center" bgcolor="#333333">
   <tr bgcolor="#EEEEEE">
      <td  colspan="2" align="center"> 发货信息</td>
  </tr>
	<tr bgcolor="#FFFFFF">
		<td  width="30%"> 收货人 （真实姓名）:</td>
		<td><?=$odr_info['truename']?></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td> 省市（邮编）:</td>
		<td><?=$odr_info['province']?>  <?=$odr_info['city']?> <?=$odr_info['area']?>&nbsp;&nbsp;邮编：<?=$odr_info['zipcode']?></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td> 详细地址:</td>
		<td><?=$odr_info['address']?></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td> 电话:</td>
		<td><?=$odr_info['telephone']?></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	  <td> 手机:</td>
	  <td><?=$odr_info['mobile']?></td>
	  </tr>
	<tr bgcolor="#FFFFFF">
	  <td> Email:</td>
	  <td><a href="?mod=mail&file=send&type=1&email=<?=$odr_info['email']?>"><?=$odr_info['email']?></a></td>
	  </tr>
	<tr bgcolor="#FFFFFF">
	  <td> 备注:</td>
	  <td><?=$odr_info['note']?></td>
	  </tr>
</table>  
	  
	  </td>
    </tr>
	<tr bgcolor="#FFFFFF">
      <td colspan="3">
	  
	  <table width="99%"  cellspacing="1" cellpadding="3" align="center" bgcolor="#333333">
	  <tr bgcolor="#EEEEEE" align="center">
		<td  align="center" colspan="10">商品信息</td>
		</tr>
	<tr bgcolor="#FFFFFF" align="center">
		<td  align="center"> ID</td>
		<td align="center"> 商品编号</td>
		<td align="center"> 商品名称</td>
		<td align="center"> 分类</td>
		<td align="center"> 品牌</td>
		<td align="center"> 价格</td>
		<td align="center"> 订购数量</td>
		<td align="center"> 小计</td>
	</tr>
	<?php
 foreach($odr_pdts as $odr_pdt)
{
?>
	<tr bgcolor="#FFFFFF"  align="center">
		  <td><?=$odr_pdt['productid']?></td>
		  <td><?=$odr_pdt['pdt_No']?></td>
		  <td><?=$odr_pdt['pdt_name']?></a></td>
		  <td><?=$CATEGORY[$odr_pdt['catid']]['catname']?></td>
		  <td><?=$BRANDS[$odr_pdt['brand_id']]['brand_name']?></td>
		  <td><?=$odr_pdt['price']?></td>
		  <td><?=$odr_pdt['pdt_number']?></td>
		  <td><?=$odr_pdt['item_total']?></td>
	</tr>
	<?php
}
?>
	<tr bgcolor="#FFFFFF">
	  <td colspan="8" align="right">总计： <strong>￥<?=$total_mount?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	  </tr>
	<tr bgcolor="#FFFFFF">
	  <td colspan="8" align="right">用户折扣： <strong><?=$discount?></strong>&nbsp;&nbsp;总价：￥<strong><?=$total_mount*$discount?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	  </tr>
</table>	  </td>
    </tr>
</table>
<script type="text/javascript" language="javascript">
//<![CDATA[
// Do print the page
window.onload = function()
{
    if (typeof(window.print) != 'undefined') {
        window.print();
    }
}
//]]>
</script>
