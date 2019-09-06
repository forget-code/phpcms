<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td></td>
  </tr>
</table>
<?=$menu?>
<table width="455" cellpadding="2" cellspacing="2" class="tableborder">
  <tr bgColor='#F1F1F1'  height="26">
    <td colspan="8"><font color="#0000FF">订单高级搜索：</font>	(可以选择填写一个或多个条件组合查找)  </td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="2" width="100%">
  <tr>
    <td width="50%" valign="top">
<table cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=2><font color="white">订单信息</font></th> 
<tr  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"  bgcolor="#F1F3F5"  height="22">
<td  width="115"><strong>订单号</strong></td>
<td><?=$odr_info['odr_No']?></td>
</tr>
<tr  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"  bgcolor="#F1F3F5"  height="22">
<td><strong>下单时间</strong></td>
<td><?=$odr_info['addtime']?></td>
</tr>
<tr  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"  bgcolor="#F1F3F5"  height="22">
<td><strong>用户名</strong></td>
<td><?=$odr_info['username']?></td>
</tr>
<tr  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"  bgcolor="#F1F3F5"  height="22">
<td><strong>审核状态</strong></td>
<td><?=$odr_info['isverify']?> 操作人：<?=$odr_info['verifyuser']?> 时间：<?=$odr_info['verifytime']?> </td>
</tr>
<tr  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"  bgcolor="#F1F3F5"  height="22">
<td><strong>付款状态</strong></td>
<td><?=$odr_info['ispay']?> 操作人：<?=$odr_info['payuser']?> 时间：<?=$odr_info['paytime']?></td>
</tr>
<tr  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"  bgcolor="#F1F3F5"  height="22">
<td><strong>发货状态</strong></td>
<td><?=$odr_info['isship']?> 操作人：<?=$odr_info['shipuser']?> 时间：<?=$odr_info['shiptime']?></td>
</tr>
<tr  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"  bgcolor="#F1F3F5"  height="22">
  <td><strong>付款方式</strong></td>
  <td><?=$odr_info['paytype']?></td>
</tr>
</table></td>


<td valign="top"><table cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=2><font color="white">发货信息</font></th> 
<tr  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"  bgcolor="#F1F3F5"  height="22">
<td><strong>收货人</strong>（真实姓名）<br></td>
<td><?=$odr_info['truename']?></td>
</tr>
<tr  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"  bgcolor="#F1F3F5"  height="22">
<td><strong>省市（邮编）</strong></td>
<td><?=$odr_info['province']?>  <?=$odr_info['city']?> <?=$odr_info['area']?>&nbsp;&nbsp;邮编：<?=$odr_info['zipcode']?></td>
</tr>
<tr  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"  bgcolor="#F1F3F5"  height="22">
<td><strong>详细地址</strong></td>
<td><?=$odr_info['address']?></td>
</tr>
<tr  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"  bgcolor="#F1F3F5"  height="22">
<td><strong>电话</strong></td>
<td><?=$odr_info['telephone']?></td>
</tr>
<tr  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"  bgcolor="#F1F3F5"  height="22">
<td><strong>手机</strong></td>
<td><?=$odr_info['mobile']?></td>
</tr>
<tr  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"  bgcolor="#F1F3F5"  height="22">
<td><strong>Email</strong></td>
<td><?=$odr_info['email']?></td>
</tr>
<tr  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'"  bgcolor="#F1F3F5"  height="22">
<td width="115"><strong>备注</strong></td>
<td><?=$odr_info['note']?></td>
</tr>
</table></td>
  </tr>

</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=9>商品信息</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder">
<tr align="center">
<td width="5%" class="tablerowhighlight">ID</td>
<td width="16%" class="tablerowhighlight">商品编号</td>
<td width="12%" class="tablerowhighlight">商品名称</td>
<td width="11%" class="tablerowhighlight">分类</td>
<td width="12%" class="tablerowhighlight">品牌</td>
<td width="13%" class="tablerowhighlight">价格</td>
<td width="10%" class="tablerowhighlight">订购数量</td>
<td width="15%" class="tablerowhighlight">小计</td>
</tr>
<?php
 foreach($odr_pdts as $odr_pdt)
{
?>
<tr align="center"  onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' height="22">
  <td><?=$odr_pdt['productid']?></td>
  <td><a href="<?=linkurl($odr_pdt['linkurl'])?>" target="_blank"><?=$odr_pdt['pdt_No']?></a></td>
  <td><a href="<?=linkurl($odr_pdt['linkurl'])?>" target="_blank"><?=$odr_pdt['pdt_name']?></a></td>
  <td><a href="<?=$CATEGORY[$odr_pdt['catid']]['linkurl']?>" target="_blank"><?=$CATEGORY[$odr_pdt['catid']]['catname']?></a></td>
  <td><?=$BRANDS[$odr_pdt['brand_id']]['brand_name']?></td>
  <td><?=$odr_pdt['pdt_price']?></td>
  <td><?=$odr_pdt['pdt_number']?></td>
  <td><?=$odr_pdt['item_total']?></td>
</tr>
<?php
}
?>
<tr align="right" bgColor='#F1F1F1'  height="26">
  <td colspan="8">总计： <strong>￥ 
      <?=$total_mount?>
  </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><input type="button" name="submits" value="返回" onClick="history.back(-1);">
 </td>
  </tr>
</table>
</body>
</html>