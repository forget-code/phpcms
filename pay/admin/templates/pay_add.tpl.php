<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script LANGUAGE="javascript">
<!--
function CheckForm() 
{
    if(!checkradio(document.myform.typeid))
	{
		alert("请选择类型！");
	   document.myform.typeid[0].focus()
	   return false
	}

	if(document.myform.amount.value=="")
	{
	   alert("请输入金额！")
	   document.myform.amount.focus()
	   return false
	}

    if(!checkselect(document.myform.paytype))
	{
	   alert("请选择支付方式！");
	   return false
	}

    if(document.myform.note.value=="")
	{
	  alert("请输入交易事由！")
	  document.myform.note.focus()
	  return false
	}
	document.myform.submit.disabled=true;
	return true;
}
//-->
</script>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>财务操作</th>
  </tr>
  <form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" onSubmit="return CheckForm();">
     <tr> 
      <td class="tablerow" width="15%">操作类型</td>
      <td class="tablerow" >
<?php 
if(is_array($types)) 
{
	foreach($types as $id=>$val)
	{
		echo "<input type=\"radio\" name=\"typeid\" value=\"".$id."\" ".($id == $typeid ? 'checked' : '').">".$val['name'].($val['operation'] ? '('.$val['operation'].')' : '')."&nbsp;&nbsp; ";
	}
}
?>
    </tr>
     <tr> 
      <td class="tablerow">用户名</td>
      <td class="tablerow"><input type="text" name="username" value="<?=$username?>" size="20"></td>
    </tr>
     <tr> 
      <td class="tablerow" >金额</td>
      <td class="tablerow" ><input type="text" name="amount" value="<?=$amount?>" size="10"> 元</td>
    </tr>
     <tr> 
      <td class="tablerow" >付款方式</td>
      <td class="tablerow" >
<select name="paytype">
<option value="0">请选择</option>
<?php 
if(is_array($paytypes)) 
{
	foreach($paytypes as $val)
	{
		echo "<option value=\"".$val."\" ".($val==$paytype ? 'selected' : '').">".$val."</option>\n";
	}
}
?>
</select>
	</td>
    </tr>
    <tr> 
      <td class="tablerow" >交易事由</td>
      <td class="tablerow" ><textarea name="note" cols="60" rows="8"><?=$note?></textarea></td>
	</tr>
    <tr> 
      <td class="tablerow" ></td>
      <td class="tablerow" > <input type="hidden" name="forward" value="<?=$forward?>"> <input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
    </tr>
  </form>
</table>
</body>
</html>