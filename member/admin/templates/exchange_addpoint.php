<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script LANGUAGE="javascript">
<!--
function CheckForm() {
if (document.myform.username.value=="")
	{
	  alert("请输入用户名！")
	  document.myform.username.focus()
	  return false
	 }
if (!isint(document.myform.point.value))
	{
	  alert("请输入赠送点数！")
      document.myform.point.value = ""
	  document.myform.point.focus()
	  return false
	 }
	  return true;
}
//-->
</script>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>增送点数</th>
  </tr>
  <form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&save=1" onSubmit="return CheckForm();">
     <tr> 
      <td class="tablerow" >用户名</td>
      <td class="tablerow" ><input type="text" name="username" value="<?=$username?>" size=20> <input type="button" name="submit" value=" 检查会员名 " onclick="javascript:openwinx('?mod=<?=$mod?>&file=member&action=user_exists&username='+myform.username.value,'user_exists','450','160')"></td>
    </tr>
     <tr> 
      <td class="tablerow" >赠送点数</td>
      <td class="tablerow" ><input type="text" name="point" size=20></td>
    </tr>
   <tr> 
      <td class="tablerow" >操作说明</td>
      <td class="tablerow" ><textarea name="note" cols="60" rows="5"><?=$note?></textarea></td>
	</tr>
   <tr> 
      <td class="tablerow" ></td>
      <td class="tablerow" >
	  <input type="hidden" name="type" value="赠送点数">
	  <input type="submit" name="submit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="submit" value=" 重置 "></td>
    </tr>
  </form>
</table>
</body>
</html>