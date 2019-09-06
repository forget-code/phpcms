<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<script language="javascript">
<!--
function Checkthis()
{
	if ($F('truename') == "")
	{
		alert("真实姓名不能为空！")
		Field.focus('truename');
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
			alert("Email 地址错误，请检查！")
			Field.focus('email');
			return false
		}
	}
	if ($F('telephone') == "")
	{
		alert("电话不能为空！")
		Field.focus('telephone');
		return false
	}
}
function CheckForm()
{
	if ($F('story') == "")
	{
		alert("工作经历不能为空！")
		Field.focus('story');
		return false
	}
	if ($F('introduce') == "")
	{
		alert("个人鉴定不能为空！")
		Field.focus('introduce');
		return false
	}
	if ($F('linkman') == "")
	{
		alert("联系人称呼不能为空！")
		Field.focus('linkman');
		return false
	}
	if ($F('school') == "")
	{
		alert("毕业院校不能为空！")
		Field.focus('school');
		return false
	}
	
	if ($F('specialty') == "")
	{
		alert("所学专业不能为空！")
		Field.focus('specialty');
		return false
	}
}
//-->
</script>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=editmemberinfo" method="post" name="myform" onSubmit='return Checkthis();'>

<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=4>[<?=$truename?>]的简历</th>

  <tr>
    <td width="19%" class="tablerow">真实姓名：</td>
    <td class="tablerow"><input name="truename" type="text" id="truename" size="20" value="<?=$truename?>" /><font color="#FF0000">*</font></td>
  </tr>
  <tr>
    <td class="tablerow">性别：</td>
    <td class="tablerow"><input name="gender" type="radio" style="border:0px " value="1" <?php if($gender) echo 'checked';?>/>
        <span >男</span>
        <input type="radio" name="gender" value="0" style="border:0px "  <?php if(!$gender) echo 'checked';?>/>
        <span >女</span> </td>
  </tr>
  <tr>
    <td class="tablerow">生日：</td>
    <td class="tablerow"><input name="byear" type="text" size="4" value="<?=$byear?>">
      <span class="color_2">年</span> 
<select name="bmonth" id="bmonth">
 <option value="00"></option>
<?php foreach($montharr AS $month)
{
	$selected = '';
	if($month==$bmonth)	$selected = 'selected';
	echo "<option value=\"$month\" $selected>$month</option>";
}
?>
</select>
      <span >月</span> 
<select name="bday" id="bday">
<option value="00"></option>
<?php foreach($dayarr AS $day)
{
	$selected = '';
	if($day==$bday)	$selected = 'selected';
	echo "<option value=\"$day\" $selected \>$day</option>";
}
?>
</select>
      <span class="color_2">日</span> </td>
  </tr>
  <tr>
    <td class="tablerow">证件类别：</td>
    <td class="tablerow"><select name="idtype">
      <option value="身份证" <?php if($idtype == '身份证') echo 'selected' ?>>身份证 </option>
      <option value="学生证" <?php if($idtype == '学生证') echo 'selected' ?>>学生证 </option>
      <option value="军人证" <?php if($idtype == '军人证') echo 'selected' ?>>军人证 </option>
      <option value="护照"  <?php if($idtype == '护照') echo 'selected' ?>>护照 </option>
    </select>
    </td>
  </tr>
  <tr>
    <td class="tablerow">证件号码：</td>
    <td class="tablerow"><input type=text name="idcard" size=22 maxlength=18 value="<?=$idcard?>"/></td>
  </tr>
  <tr>
    <td class="tablerow">户口所在地：</td>
    <td class="tablerow">

<select name="province" id="province" onchange="javascript:loadcity(this.value);">
<option value="0" selected="selected">请选择</option>
</select>

<select name="city" id="city" onchange="javascript:loadarea($('province').value, this.value);">
<option value="0" selected="selected">请选择</option>
</select>

<select name="area" id="area">
<option value="0" selected="selected">请选择</option>
</select>

<script language="javascript">
<!--
var phpcms_path = '<?=PHPCMS_PATH?>';
var selectedprovince = '<?=$province?>';
var selectedcity = '<?=$city?>';
var selectedarea = '<?=$area?>';
//-->
</script>
<script type="text/javascript" src="/include/js/area.js"></script>


    </td>
  </tr>
    <tr>
    <td class="tablerow">教育水平：</td>
    <td class="tablerow"><select name="edulevel" size=1>
      <option value="">请选择　　</option>
      <option value="博士后"  <?php if($edulevel=='博士后') echo 'selected'; ?>>博士后</option>
      <option value="博士"  <?php if($edulevel=='博士') echo 'selected'; ?>>博士</option>
      <option value="硕士" <?php if($edulevel=='硕士') echo 'selected'; ?>>硕士</option>
      <option value="大学" <?php if($edulevel=='大学') echo 'selected'; ?>>大学</option>
      <option value="高中" <?php if($edulevel=='高中') echo 'selected'; ?>>高中</option>
      <option value="初中" <?php if($edulevel=='初中') echo 'selected'; ?>>初中</option>
      <option value="小学" <?php if($edulevel=='小学') echo 'selected'; ?>>小学</option>
    </select>
    </td>
  </tr>
  <tr>
    <td class="tablerow">照片地址：</td>
    <td class="tablerow"><input name="userface" type="text" id="userface" size="50" value="<?=$userface?>" /> <input type="button" value="上传" onClick="javascript:openwinx('<?=PHPCMS_PATH?>upload.php?keyid=member&type=thumb&uploadtext=userface','upload','350','200')"></td>
  </tr>

<tr> 
<td class="tablerow">E-Mail</td>
<td valign="top" class="tablerow" colspan=3>
<input name="email" type="text" id="email" size="30" value="<?=$_email?>" ><font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">联系电话</td>
<td valign="top" class="tablerow" colspan=3>
<input name="telephone" type="text" id="telephone" size="30" value="<?=$telephone?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">联系地址</td>
<td valign="top" class="tablerow" colspan=3>
<input name="address" type="text" id="address" size="50" value="<?=$address?>">
</td>
</tr>
  <tr>
    <td class="tablerow"></td>
    <td class="tablerow">
	<input type="hidden" name="forward" value="<?=$forward?>" />
    <input type="submit" name="editmemberinfo" value=" 修改基本资料 " />
    </td>
  </tr>
</table>
</form>
<BR>
<form action="" method="post" name="form1" onSubmit='return CheckForm();'>

<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<td class="tablerow">工作性质</td>
<td class="tablerow" >
	<select id="character" name="apply[worktype]">
	<option value="不限" <?php if($worktype=='不限') echo 'selected'; ?>>不限</option>	
	<option value="全职" <?php if($worktype=='全职') echo 'selected'; ?>>全职</option>
	<option value="兼职" <?php if($worktype=='兼职') echo 'selected'; ?>>兼职</option>
	<option value="实习" <?php if($worktype=='实习') echo 'selected'; ?>>实习</option>	
	</select>
	</td>
</tr>
<tr> 
<td class="tablerow">工作经历</td>
<td valign="top" class="tablerow" colspan=3>
<textarea name="apply[story]" id="story" cols="100" rows="6"><?=$story?></textarea>
</td>
</tr>

<tr> 
  <td width="19%" class="tablerow">欲从事岗位</td>
  <td class="tablerow" colspan=3><?=$editstation?> <font color="#FF0000">*</font></td>
</tr>
<tr> 
	<td class="tablerow">工作年限</td>
	<td class="tablerow" >
	<input name="apply[experience]" type="text" id="experience" size="20" value="<?=$experience?>">
	</td>
</tr>
</tr>

<tr> 
	<td class="tablerow">薪资要求</td>
	<td class="tablerow" colspan=3>
	<input name="apply[pay]" type="text" id="pay" size="6" value="<?=$pay?>">/月 0 为面议
	</td>
</tr>
<tr>
<td class="tablerow">期待地区</td>
<td class="tablerow" colspan=3>
<input name="apply[area]" type="text" id="area" size="36" value="<?=$area?>">
</select>
</td>
</tr>
<tr> 
	<td class="tablerow">上岗时间</td>
	<td class="tablerow" colspan=3>
	<select id="period" name="apply[period]">
	<option value="0" <?php if($period=='0') echo 'selected'; ?>>随叫随到</option>
	<option value="2" <?php if($period=='2') echo 'selected'; ?>>两天内</option>
	<option value="3" <?php if($period=='3') echo 'selected'; ?>>三天内</option>
	<option value="7" <?php if($period=='7') echo 'selected'; ?>>一周内</option>
	<option value="30" <?php if($period=='30') echo 'selected'; ?>>一个月</option>
	<option value="90" <?php if($period=='90') echo 'selected'; ?>>三个月</option>
	</select>
	</td>
</tr>
<tr> 
<td class="tablerow">个人鉴定</td>
<td valign="top" class="tablerow" colspan=3>
<textarea name="apply[introduce]" id="introduce" cols="100" rows="15"><?=$introduce?></textarea>
</td>
</tr>
<tr> 
<td class="tablerow">联 系 人</td>
<td valign="top" class="tablerow" colspan=3>
<input name="apply[linkman]" type="text" id="linkman" size="10" value="<?=$linkman?>"> <font color="#FF0000">*</font>
真实姓名或王先生、李女士</td>
</tr>
<tr> 
<td class="tablerow">毕业时间</td>
<td valign="top" class="tablerow" colspan=3>
<input name="apply[graduatetime]" type="text" id="graduatetime" size="10" value="<?=$graduatetime?>">
</td>

</tr>
<tr> 
<td class="tablerow">毕业学校</td>
<td valign="top" class="tablerow" colspan=3>
<input name="apply[school]" type="text" id="school" size="30" value="<?=$school?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td class="tablerow">所学专业</td>
<td valign="top" class="tablerow" colspan=3>
<input name="apply[specialty]" type="text" id="specialty" size="30" value="<?=$specialty?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
	<td class="tablerow">招聘信息状态</td>
	<td class="tablerow" colspan=3>

	<input name="apply[status]" type="radio" value="3" <?php if($_groupid<4){?>checked<?php }else{ ?>disabled<?php } ?>> 已通过&nbsp;
	<input name="apply[status]" type="radio" value="1" <?php if($_groupid==4){?>checked<?php } ?>> 待审核&nbsp;
	<input name="apply[status]" type="radio" value="0"> 草稿&nbsp;
	</td>
</tr>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <td width="15%" class="tablerow">
	</td>
    <td class="tablerow" height="25">
	<input type="hidden" name="forward" value="<?=$forward?>" />
	<input type="hidden" name="applyid" value="<?=$applyid?>" />
	<input type="submit" name="dosubmit" value=" 确认修改 " />
	</td>
  </tr>
</table>
</form>
</body>
</html>