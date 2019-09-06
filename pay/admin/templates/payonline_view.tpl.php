<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="2">财务操作</th>
  </tr>
     <tr> 
      <td class="tablerow" width="20%">用户名</td>
      <td class="tablerow"><a href="?mod=member&file=member&action=view&username=<?=urlencode($username)?>"><?=$username?></a></td>
    </tr>
     <tr> 
      <td class="tablerow">流水号</td>
      <td class="tablerow"><?=$orderid?></td>
    </tr>
     <tr> 
      <td class="tablerow">支付金额</td>
      <td class="tablerow"><font color="red"><?=($amount+$trade_fee)?>元</font> <?php if($trade_fee){ ?>（充值<?=$amount?>元，手续费<?=$trade_fee?>元） <?php } ?> </td>
    </tr>
     <tr> 
      <td class="tablerow">支付结果</td>
      <td class="tablerow"><?=$STATUS[$status]?></td>
    </tr>
     <tr> 
      <td class="tablerow">下单时间</td>
      <td class="tablerow"><?=$sendtime?></td>
    </tr>
     <tr> 
      <td class="tablerow">支付时间</td>
      <td class="tablerow"><?=$receivetime?></td>
    </tr>
     <tr> 
      <td class="tablerow">IP</td>
      <td class="tablerow"><?=$ip?></td>
    </tr>
     <tr> 
      <td class="tablerow">联系人</td>
      <td class="tablerow"><?=$contactname?></td>
    </tr>
     <tr> 
      <td class="tablerow">E-mail</td>
      <td class="tablerow"><?=$email?></td>
    </tr>
     <tr> 
      <td class="tablerow">电话</td>
      <td class="tablerow"><?=$telephone?></td>
    </tr>

</table>
</body>
</html>