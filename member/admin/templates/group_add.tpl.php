<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<script LANGUAGE="javascript">
<!--
function Check() {
if (document.myform.groupname.value=="")
	{
	  alert("请输入用户组名称")
	  document.myform.groupname.focus()
	  return false
	 }
}
//-->
</script>
<table cellpadding="2" cellspacing="1" class="tableborder">
<form method="post" name="myform" onsubmit="return Check()" action="?mod=<?=$mod?>&file=<?=$file?>&action=add">
  <tr>
    <th colspan=2>添加会员组</th>
  </tr>
<tr>
<td width="20%" class="tablerow">会员组名称</td>
<td width="80%" class="tablerow"><input name="groupname" size="30"  maxlength="50"></td>
</tr>
<tr>
<td class="tablerow">会员组说明：</td>
<td class="tablerow"><input name="introduce" size="60" maxlength="255"></td>
</tr>
<tr>
<td class="tablerow">会员组类型：</td>
<td class="tablerow">
<select name="grouptype">
<option value="special">自定义</option>
<option value="system">系统组</option>
</select>
</td>
</tr>
<tr>
<td class="tablerow">计费方式</td>
<td class="tablerow">
<fieldset>
<legend><input type="radio" name="chargetype" value="0">扣点数
</legend>
&nbsp;&nbsp;默认可用点数 <input name="defaultpoint" size="5" maxlength="50" value="100"> 点
<br>&nbsp;&nbsp;会员加入此用户组时，默认得到的点数。每阅读一篇收费文章，扣除相应点数。
</fieldset>
<br>
<fieldset>
<legend><input type="radio" name="chargetype" value="1" checked>有效期
</legend>
&nbsp;&nbsp;默认有效期 
<input name="defaultvalidday" size="5" maxlength="50" value="-1"> 天（<a href="#" onclick="javascript:myform.defaultvalidday.value=-1"><font color="red">无限期为-1天</font></a>）<br>
&nbsp;&nbsp;
<select name='setbymonth' onchange="myform.defaultvalidday.value=this.value*30">
 <option value="0">按月设置</option>
 <option value="1">1月</option>
 <option value="2">2月</option>
 <option value="3">3月</option>
 <option value="4">4月</option>
 <option value="5">5月</option>
 <option value="6">6月</option>
 <option value="7">7月</option>
 <option value="8">8月</option>
 <option value="9">9月</option>
 <option value="10">10月</option>
 <option value="11">11月</option>
 <option value="12">12月</option>
</select>
<select name='setbyyear' onchange="myform.defaultvalidday.value=this.value*365">
 <option value="0">按年设置</option>
 <option value="1">1年</option>
 <option value="2">2年</option>
 <option value="3">3年</option>
 <option value="4">4年</option>
 <option value="5">5年</option>
 <option value="6">6年</option>
 <option value="7">7年</option>
 <option value="8">8年</option>
 <option value="9">9年</option>
 <option value="10">10年</option>
</select>
系统会自动换算为天数，1月=30天，1年=365天
<br>&nbsp;&nbsp;会员加入此用户组时，默认得到的有效期。在有效期内可阅读收费内容。
</fieldset>
</td>
</tr>
<tr>
<td class="tablerow">服务购买优惠</td>
<td class="tablerow"><input name="discount" size="5" maxlength="3" value="100">% 购物时可以享受的折扣率</td>
</tr>
<tr>
<td class="tablerow">是否拥有发布特权</td>
<td class="tablerow">
<input type="radio" name="enableaddalways" value="1"> 在发布信息需要审核的频道，此组会员发布信息不需要审核<br/>
<input type="radio" name="enableaddalways" value="0" checked> 在发布信息需要审核的频道，此组会员发布信息需要审核

</td>
</tr>
<tr>
<td class="tablerow"></td>
<td class="tablerow">
<input type="submit" name="dosubmit" value=" 添加 ">&nbsp;&nbsp;&nbsp;&nbsp;
<input type="reset" name="reset" value=" 清除 ">
</td>
</tr>
</form>
</table>
</body>
</html>