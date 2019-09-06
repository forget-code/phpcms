<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<?=$menu?>
<script language="javascript">
<!--
function CheckForm()
{
	if ($F('title') == "")
	{
		alert("职位名称不能为空！")
		Field.focus('title');
		return false
	}
	if ($F('unit') == "")
	{
		alert("招聘单位名称不能为空！")
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
<th colspan=4>发布招聘信息</th>
 <tr> 
      <td width="19%" class="tablerow">岗位分类</td>
      <td class="tablerow" colspan=3><?=$station?> <font color="#FF0000">*</font></td>
    </tr>
<tr> 
	<td class="tablerow">职位名称</td>
	<td class="tablerow" colspan=3><input name="job[title]" type="text" id="title" size="44" maxlength="100" > <font color="#FF0000">*</font> <?=$style_edit?>
	</td>
</tr>
<tr>

      <td class="tablerow">招聘人数</td>
      <td class="tablerow" colspan=3><input name="job[employ]" type="text" id="employ" size="4" > 0 为若干
</td>
</tr>
<tr> 
	<td class="tablerow">工作经验</td>
	<td class="tablerow" >
	<select id="experience" name="job[experience]">
	<option value="不限" selected="selected">不限</option>
	<option value="1年">1年</option>
	<option value="2年">2年</option>
	<option value="3年">3年</option>
	<option value="4年">4年</option>
	<option value="5年以上">5年以上</option>
	</select></td>
	<td class="tablerow" >
 工作性质 :</td>
 <td class="tablerow" >
	<select id="character" name="job[worktype]">
	<option value="不限" selected="selected">不限</option>
	<option value="全职">全职</option>
	<option value="兼职">兼职</option>
	</select>
	</td>
</tr>

<tr> 
	<td class="tablerow">性别要求</td>
	<td class="tablerow" >
<select id="sex" name="job[sex]">
<option value="0" selected="selected">不限</option>
<option value="1">男</option>
<option value="2">女</option>
</select></td>
<td class="tablerow">
学历要求</td>
<td class="tablerow">
<select id="degree" name="job[degree]">
	<option value="不限" selected="selected">不限</option>
	<option value="高中">高中</option>
	<option value="大专">大专</option>
	<option value="本科">本科</option>
	<option value="研究生">研究生</option>
	<option value="硕士">硕士</option>
	<option value="博士">博士</option>
	</select>
	</td>
</tr>
<tr> 
	<td class="tablerow">薪    水</td>
	<td class="tablerow" colspan=3>
	<input name="job[pay]" type="text" id="pay" size="6" value="0">/月 0 为面议
	</td>
</tr>
<tr>
<td class="tablerow">所在地</td>
<td class="tablerow" colspan=3>
<span id="select_area">
<?=ajax_area_select('job[areaid]', $mod, $areaid)?>
</td>
</tr>
<tr> 
	<td class="tablerow">有效期</td>
	<td class="tablerow" colspan=3>
	<select id="period" name="job[period]">
	<option value="7" selected="selected">一周</option>
	<option value="3">三天</option>
	<option value="30">一个月</option>
	<option value="90">三个月</option>
	<option value="0">不限制</option>
	</select>
	</td>
</tr>
<tr> 
<td class="tablerow">职位描述</td>
<td valign="top" class="tablerow" colspan=3>
<textarea name="job[introduce]" id="introduce" cols="100" rows="15"></textarea><?=editor("introduce", 'phpcms','100%','400')?>
</td>
</tr>

<tr> 
<td class="tablerow">招聘单位</td>
<td valign="top" class="tablerow" colspan=3>
<input name="job[unit]" type="text" id="unit" size="30" value="<?=$pagename?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">联 系 人</td>
<td valign="top" class="tablerow" colspan=3>
<input name="job[linkman]" type="text" id="linkman" size="10" value="<?=$_username?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">E-Mail</td>
<td valign="top" class="tablerow" colspan=3>
<input name="job[email]" type="text" id="email" size="30" value="<?=$_email?>" ><font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">联系电话</td>
<td valign="top" class="tablerow" colspan=3>
<input name="job[phone]" type="text" id="phone" size="30" value="<?=$telephone?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">联系地址</td>
<td valign="top" class="tablerow" colspan=3>
<input name="job[address]" type="text" id="address" size="50" value="<?=$address?>">
</td>
</tr>

<?php if(!$arrgroupidpost) {?>
<tr> 
	<td class="tablerow">信息状态</td>
	<td class="tablerow" colspan=3>
	<font color="#0000FF"><input name="job[status]" type="hidden" value="1" >你所在的会员组，发布信息后需要管理员审核！</font>
	</td>
</tr>
<?php
}
else
{
	echo "<input name='job[status]' type='hidden' value='3' >";
}
?>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1" >
  <tr>
    <td width="40%" >
	</td>
    <td  height="25">
	<input type="hidden" name="job[companyid]" value="<?=$companyid?>" />
	<input type="hidden" name="forward" value="<?=$forward?>" />
	<input type="submit" name="dosubmit" value=" 发布招聘 " />
	</td>
  </tr>
</table>
</form>
</body>
</html>