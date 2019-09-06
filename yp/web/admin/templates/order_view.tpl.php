<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<?=$menu?>
当前位置：<a href="?file=order&action=manage">订单管理</a> >> 订单详细页面<BR><BR>
<form action="" method="post" name="myform" >
<table width="100%"  border="0" cellpadding="4" cellspacing="1" class="tableborder">
<th colspan=7>详细信息</th>
<tr onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td width="10%">物品名称：</td>
<td width="40%"><?=$title?></td>
<td width="10%">订购数量：</td>
<td width="40%"><?=$number?></td>
</tr>
<tr onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td width="10%">单价：</td>
<td width="40%"><?=$price?> 元</td>
<td width="10%">总价：</td>
<td width="40%"><?=$totalprice?> 元</td>
</tr>
<tr onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td width="10%">联系人：</td>
<td width="40%"><?=$linkman?></td>
<td width="10%">传真：</td>
<td width="40%"><?=$fax?></td>
</tr>
<tr onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td >联系电话：</td>
<td ><?=$telephone?></td>
<td >QQ：</td>
<td ><?=$qq?></td>
</td>
</tr>
<tr onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td >所在单位：</td>
<td ><?=$unit?></td>
<td >MSN：</td>
<td ><?=$msn?></td>
</td>
</tr>
<tr onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td >Email：</td>
<td colspan="3"><?=$email?></td>
</td>
</tr>
<tr onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'> 
<td >要求：</td>
<td colspan="3"><?=$content?></td>
</td>
</tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align='center'> </td>
  </tr>
</table>

</body>
</html>
