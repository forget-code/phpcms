<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
    <table cellpadding="0" cellspacing="1" class="table_info">
      <caption>订单处理</caption>
		<tr>
           <th width="10%">交易状态：</th>
           <td><?=$statusname?> <?php if($status==0){ ?>买家还有 <font color="red"><?=$closedtime['d']?>天<?=$closedtime['h']?>小时<?=$closedtime['m']?>分钟<?=$closedtime['s']?>秒</font> 来完成本次交易的付款。 <?php } ?></td>            
        </tr>
	</table>
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
           <td width="50%" valign="top">
    <table cellpadding="0" cellspacing="1" class="table_info">
      <caption>订单信息</caption>
		<tr>
           <th width="20%">订单ID：</th>
           <td><?=$orderid?></td>            
        </tr>
        <tr>
          <th>产品：</th>
          <td><a href="<?=$goodsurl?>"><?=$goodsname?></a></td>
        </tr>
        <tr>
          <th>单价：</th>
          <td><?=$price?>元/<?=$unit?></td>
        </tr>
        <tr>
          <th>数量：</th>
          <td><?=$number?><?=$unit?></td>
        </tr>
        <tr>
          <th>运费：</th>
          <td><?=$carriage?>元</td>
        </tr>
		<tr>
          <th>付款金额：</th>
          <td><span style="color:red;font-weight:bold">￥<?=$amount?>元</span></td>
        </tr>
        <tr>
          <th>下单时间：</th>
          <td><?=date('Y-m-d H:i:s', $time)?></td>
        </tr>
	</table>
		   </td>
           <td valign="top">
    <table cellpadding="0" cellspacing="1" class="table_info">
      <caption>收货信息</caption>
		<tr>
           <th width="20%">收货人：</th>
           <td><?=$consignee?></td>            
        </tr>
        <tr>
          <th>区域：</th>
          <td><?=areaname($areaid)?></td>
        </tr>
        <tr>
          <th>电话：</th>
          <td><?=$telephone?></td>
        </tr>
        <tr>
          <th>手机：</th>
          <td><?=$mobile?></td>
        </tr>
        <tr>
          <th>地址：</th>
          <td><?=$address?></td>
        </tr>
        <tr>
          <th>邮编：</th>
          <td><?=$postcode?></td>
        </tr>
        <tr>
          <th>留言：</th>
          <td><?=$note?></td>
        </tr>
	</table>
		   </td>            
        </tr>
	</table>
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>订单处理记录</caption>
  <tr>
	<th width="120">操作时间</th>
	<th width="120">订单状态</th>
    <th>备注</th>
    <th width="80">操作者</th>
    <th width="100">IP</th>
 </tr>
<tr>
<?php
 foreach($logs as $r)
{
?>
  <td class="align_c"><?=date('Y-m-d H:i:s', $r['time'])?></td>
  <td class="align_c"><?=$order->STATUS[$r['laststatus']]?>=><?=$order->STATUS[$r['status']]?></td>
  <td><?=$r['note']?></td>
  <td class="align_c"><a href="<?=member_view_url($r['userid'])?>"><?=$r['username']?></a></td>
  <td class="align_c"><a href="<?=ip_url($r['userid'])?>"><?=$r['ip']?></a></td>
</tr>
<?php
}
?>
</table>
</body>
</html>