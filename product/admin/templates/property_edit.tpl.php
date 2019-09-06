<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>修改商品类型</th>
  </tr>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=edit"  onsubmit="javascript:if($F('pro_name')=='') {alert('请填写商品类型名称');$('pro_name').focus(); return false;}">
<input type="hidden" name='pro_id' value="<?=$pro_id?>" />

<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td width="30%" class="tablerow">商品类型名称：</td>
<td class="tablerow"  align="left"><input type="text" name="pro[pro_name]" id="pro_name" size="25" value="<?=$pro['pro_name']?>"/>&nbsp;<font color="Red">*</font></td>
</tr>

<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td width="30%" class="tablerow">启用：</td>
<td class="tablerow" align="left"><input type="radio" name="pro[disabled]" id=pro_disabled <? if($pro['disabled']==0) echo " checked ";?> value="0"/>√&nbsp;&nbsp;&nbsp;
<input type="radio" name="pro[disabled]" id=pro_disabled  <? if($pro['disabled']==1) echo " checked ";?> value="1"/>×</td>
</tr>

</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><input name="submit" type="submit" size="4" value="确定"></td>
  </tr>
</table>
</form>
</body>
</html>