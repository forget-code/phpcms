<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<?=$menu?>
<script language="javascript">
<!--
function CheckForm()
{
	if ($('catid').value=='0'){
	alert('请选择栏目');
	$('catid').focus();
	return false;
	}
	if ($F('title') == "")
	{
		alert("标题不能为空！")
		Field.focus('title');
		return false
	}
	if ($F('unit') == "")
	{
		alert("单位名称不能为空！")
		Field.focus('unit');
		return false
	}
	if ($F('linkman') == "")
	{
		alert("联系人名称不能为空！")
		Field.clear('unlinkmanit')
		Field.focus('linkman');
		return false
	}
	if ($F('email') == "")
	{
		alert("Email地址不能为空！")
		Field.focus('email');
		return false
	}
	else
	{
		var mail = $F('email');
		if(!RegExp(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/).test(mail))
		{
			alert("Email 地址错误，请检查")
			Field.focus('email');
			return false
		}
	}
	if ($F('phone') == "")
	{
		alert("电话不能为空！")
		Field.focus('phone');
		return false
	}
}
//-->
</script>
<form action="" method="post" name="myform" onSubmit='return CheckForm();'>
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=4>发布求购信息</th>
 <tr> 
      <td width="19%" class="tablerow">所属栏目</td>
      <td class="tablerow"><?=trade_select('product[catid]', '请选择所属栏目','',"id='catid'")?></td>
    </tr>
<tr> 
	<td class="tablerow">标题</td>
	<td class="tablerow"><input name="product[title]" type="text" id="title" size="44" maxlength="100" class="inputtitle" > 
	</td>
</tr>

<tr> 
<td class="tablerow">采购要求</td>
<td valign="top" class="tablerow">
<textarea name="product[introduce]" id="introduce" cols="100" rows="15"></textarea><?=editor("introduce", 'phpcms','100%','400')?>
</td>
</tr>
<tr> 
	<td class="tablerow">有效期至</td>
	<td class="tablerow" colspan=3>
	<?=date_select('product[period]',$totime)?>  （包括当天）
	</td>
</tr>
<?=$fields?>
<tr> 
<td class="tablerowhighlight" colspan=2>该信息联系方式</td>
</tr>

<tr> 
<td class="tablerow">单位名称</td>
<td valign="top" class="tablerow" colspan=3>
<input name="product[unit]" type="text" id="unit" size="30" value="<?=$pagename?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">联 系 人</td>
<td valign="top" class="tablerow" colspan=3>
<input name="product[linkman]" type="text" id="linkman" size="10" value="<?=$_username?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">E-Mail</td>
<td valign="top" class="tablerow" colspan=3>
<input name="product[email]" type="text" id="email" size="30" value="<?=$_email?>" ><font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">联系电话</td>
<td valign="top" class="tablerow" colspan=3>
<input name="product[phone]" type="text" id="phone" size="30" value="<?=$telephone?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">联系地址</td>
<td valign="top" class="tablerow" colspan=3>
<input name="product[address]" type="text" id="address" size="50" value="<?=$address?>">
</td>
</tr>
<?php if(!$arrgroupidpost) {?>
<tr> 
	<td class="tablerow">信息状态</td>
	<td class="tablerow" colspan=3>
	<font color="#0000FF"><input name="product[status]" type="hidden" value="1" >你所在的会员组，发布信息后需要管理员审核！</font>
	</td>
</tr>
<?php
}
else
{
	echo "<input name='product[status]' type='hidden' value='3' >";
}
?>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1" >
  <tr>
    <td width="40%" >
	</td>
    <td height="25">
	<input type="hidden" name="product[companyid]" value="<?=$companyid?>" />
	<input type="hidden" name="labelfile" value="buy" />
	<input type="submit" name="dosubmit" value=" 立即发布 " />
	</td>
  </tr>
</table>
</form>
</body>
</html>