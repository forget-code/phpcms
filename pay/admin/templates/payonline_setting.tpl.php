<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<form method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="2">在线支付接口设置</th>
  </tr>
<?php 
if(is_array($settings))
{
    foreach($settings as $setting)
	{
?>
<tr>
<td colspan="2" class="tablerowhighlight"><?=$setting['name']?></td>
</tr>
<tr>
<td class="tablerow">是否启用</td>
<td class="tablerow"><input type="checkbox" name="enable[<?=$setting['id']?>]" value="1" <?php if($setting['enable']){?>checked<?php }?>></td>
</tr>
<tr>
<td class="tablerow">接口名称</td>
<td class="tablerow"><input size="28"  type="text" name="name[<?=$setting['id']?>]"  value="<?=$setting['name']?>"></td>
</tr>
<tr>
<td class="tablerow">接口LOGO</td>
<td class="tablerow"><input size="50"  type="text" name="logo[<?=$setting['id']?>]"  value="<?=$setting['logo']?>"></td>
</tr>
<tr>
<td class="tablerow">接口网址</td>
<td class="tablerow"><input size="50"  type="text" name="sendurl[<?=$setting['id']?>]"  value="<?=$setting['sendurl']?>"></td>
</tr>
<tr>
<td class="tablerow">结果返回网址</td>
<td class="tablerow"><input size="50"  type="text" name="receiveurl[<?=$setting['id']?>]"  value="<?=$setting['receiveurl']?>"></td>
</tr>
<tr>
<td class="tablerow">商户编号</td>
<td class="tablerow"><input size="28"  type="text" name="partnerid[<?=$setting['id']?>]"  value="<?=$setting['partnerid']?>"></td>
</tr>
<tr>
<td class="tablerow">支付密钥</td>
<td class="tablerow"><input size="28"  type="password" name="keycode[<?=$setting['id']?>]"  value="<?=$setting['keycode']?>"></td>
</tr>
<tr>
<td class="tablerow">扣除手续费</td>
<td class="tablerow"><input size="5"  type="text" name="percent[<?=$setting['id']?>]"  value="<?=$setting['percent']?>">%</td>
</tr>
<?php
	} 
}
?>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><input type="submit" name="dosubmit" value=" 保存配置 "></td>
  </tr>
</table>
</form>
</body>
</html>
