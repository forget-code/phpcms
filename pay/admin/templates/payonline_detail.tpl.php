<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<!--标签页-->
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>
  财务操作
  </caption>
  <tr>
  <form name="myform" method="post" action="" ">
    <th width="25%"><strong>用户名</strong></th>
    <td width="75%">admin</td>
  </tr>
  <tr>
    <th><strong>流水号</strong></th>
    <td><?=$sn?></td>
  </tr>
  <tr>
    <th><strong>支付金额</strong></th>
    <td width="75%"><font color="red"><?=($amount+$trade_fee)?>元</font> <?php if($trade_fee){ ?>（充值<?=$amount?>元，手续费<?=$trade_fee?>元） <?php } ?> </td>
  </tr>
  <tr>
    <th><strong>支付结果</strong></th>
    <td><?php if($status){?>支付成功<?php }else{?><font style="color:red">支付失败</font><?php }?></td>
  </tr>
  <tr>
    <th><strong>下单时间</strong></th>
    <td><?=date('Y-d-m',$addtime)?></td>
  </tr>
  <tr>
    <th><strong>支付时间</strong></th>
    <td><?=$receivetime?></td>
  </tr>
  <tr>
    <th><strong>下单IP</strong></th>
    <td><?=$ip?></td>
  </tr>
  <tr>
    <th><strong>联系人</strong></th>
    <td><?=$contactname?></td>
  </tr>
  <tr>
    <th><strong>E-mail</strong></th>
    <td><?=$email?></td>
  </tr>
  <tr>
    <th><strong>电话</strong></th>
    <td><?=$telephone?></td>
  </tr>
 </form>
</table>
</body>
</html>
