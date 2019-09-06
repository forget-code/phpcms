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
<th colspan=4>编辑招聘信息</th>
 <tr> 
      <td width="19%" class="tablerow">岗位分类</td>
      <td class="tablerow" colspan=3><?=$station?> <font color="#FF0000">*</font>
	<input type="hidden" name="job[station]" value="<?=$station?>" />
</td>
    </tr>
<tr> 
	<td class="tablerow">职位名称</td>
	<td class="tablerow" colspan=3><input name="job[title]" type="text" id="title" size="44" maxlength="100" value="<?=$title?>"> <font color="#FF0000">*</font> <?=$style_edit?>
	</td>
</tr>
<tr>

      <td class="tablerow">招聘人数</td>
      <td class="tablerow" colspan=3><input name="job[employ]" type="text" id="employ" size="4" value="<?=$employ?>"> 0 为若干
</td>
</tr>
<tr> 
	<td class="tablerow">工作经验</td>
	<td class="tablerow" >
	<select id="experience" name="job[experience]">
	<option value="不限" selected="selected">不限</option>
	<option value="1年" <?php if($experience=='1年') echo 'selected'; ?>>1年</option>
	<option value="2年" <?php if($experience=='2年') echo 'selected'; ?>>2年</option>
	<option value="3年" <?php if($experience=='3年') echo 'selected'; ?>>3年</option>
	<option value="4年" <?php if($experience=='4年') echo 'selected'; ?>>4年</option>
	<option value="5年以上" <?php if($experience=='5年以上') echo 'selected'; ?>>5年以上</option>
	</select></td>
	<td class="tablerow" >
 工作性质 :</td>
 <td class="tablerow" >
	<select id="character" name="job[worktype]">
	<option value="不限" <?php if($worktype=='不限') echo 'selected'; ?>>不限</option>
	<option value="全职" <?php if($worktype=='全职') echo 'selected'; ?>>全职</option>
	<option value="兼职" <?php if($worktype=='兼职') echo 'selected'; ?>>兼职</option>
	</select>
	</td>
</tr>

<tr> 
	<td class="tablerow">性别要求</td>
	<td class="tablerow" >
<select id="sex" name="job[sex]">
<option value="0" <?php if(!$sex) echo 'selected'; ?>>不限</option>
<option value="1" <?php if($sex==1) echo 'selected'; ?>>男</option>
<option value="2" <?php if($sex==2) echo 'selected'; ?>>女</option>
</select></td>
<td class="tablerow">
学历要求</td>
<td class="tablerow">
<select id="degree" name="job[degree]">
	<option value="不限" <?php if($degree=='不限') echo 'selected'; ?>>不限</option>
	<option value="高中" <?php if($degree=='高中') echo 'selected'; ?>>高中</option>
	<option value="大专" <?php if($degree=='大专') echo 'selected'; ?>>大专</option>
	<option value="本科" <?php if($degree=='本科') echo 'selected'; ?>>本科</option>
	<option value="研究生" <?php if($degree=='研究生') echo 'selected'; ?>>研究生</option>
	<option value="硕士" <?php if($degree=='硕士') echo 'selected'; ?>>硕士</option>
	<option value="博士" <?php if($degree=='博士') echo 'selected'; ?>>博士</option>
	</select>
	</td>
</tr>
<tr> 
	<td class="tablerow">薪    水</td>
	<td class="tablerow" colspan=3>
	<input name="job[pay]" type="text" id="pay" size="6" value="<?=$pay?>">/月 0 为面议
	</td>
</tr>
<tr>
<td class="tablerow">所在地</td>
<td class="tablerow" colspan=3>
<span onclick="this.style.display='none';$('select_area').style.display='';" style="cursor:pointer;"><?=$AREA[$areaid]['areaname']?> <font color="red">点击重选</font></span><span id="select_area" style="display:none;">
<?=ajax_area_select('job[areaid]', $mod, $areaid)?>
</td>
</tr>
<tr> 
	<td class="tablerow">有效期</td>
	<td class="tablerow" colspan=3>
	<select id="period" name="job[period]">
	<option value="7" <?php if($period==7) echo 'selected'; ?>>一周</option>
	<option value="3" <?php if($period==3) echo 'selected'; ?>>三天</option>
	<option value="30" <?php if($period==30) echo 'selected'; ?>>一个月</option>
	<option value="90" <?php if($period==90) echo 'selected'; ?>>三个月</option>
	<option value="0" <?php if(!$period) echo 'selected'; ?>>不限制</option>
	</select>
	</td>
</tr>
<tr> 
<td class="tablerow">职位描述</td>
<td valign="top" class="tablerow" colspan=3>
<textarea name="job[introduce]" id="introduce" cols="100" rows="15"><?=$introduce?></textarea><?=editor("introduce", 'phpcms','100%','260')?>
</td>
</tr>

<tr> 
<td class="tablerow">招聘单位</td>
<td valign="top" class="tablerow" colspan=3>
<input name="job[unit]" type="text" id="unit" size="30" value="<?=$unit?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">联 系 人</td>
<td valign="top" class="tablerow" colspan=3>
<input name="job[linkman]" type="text" id="linkman" size="10" value="<?=$username?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">E-Mail</td>
<td valign="top" class="tablerow" colspan=3>
<input name="job[email]" type="text" id="email" size="30" value="<?=$email?>" ><font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">联系电话</td>
<td valign="top" class="tablerow" colspan=3>
<input name="job[phone]" type="text" id="phone" size="30" value="<?=$phone?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">联系地址</td>
<td valign="top" class="tablerow" colspan=3>
<input name="job[address]" type="text" id="address" size="50" value="<?=$address?>">
</td>
</tr>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1" >
  <tr>
    <td width="15%" >
	</td>
    <td height="25">
	<input type="hidden" name="job[companyid]" value="<?=$companyid?>" />
	<input type="hidden" name="forward" value="<?=$forward?>" />
	<input type="submit" name="dosubmit" id="dosubmit" value=" 确认修改 " />
	</td>
  </tr>
</table>
</form>
</body>
</html>