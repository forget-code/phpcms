<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_info">
  <caption>编辑简历</caption>
  <tr>
    <th width="19%" class="td_right"><font color="#FF0000">*</font> <strong>真实姓名：</strong></th>
    <td class="td_left"><input name="info[truename]" type="text" id="truename" size="20" value="<?=$truename?>" />
<input name="info[gender]" type="radio" style="border:0px " value="0" <?php if(!$gender) echo 'checked';?>/>
        <span >先生</span>
        <input type="radio" name="info[gender]" value="1" style="border:0px " <?php if($gender) echo 'checked';?>/>
        <span >女士</span></td>
  </tr>
  <tr>
    <th><strong>生日：</strong></th>
    <td class="td_left"><input name="byear" type="text" size="4" value="<?=$byear?>">
      <span class="color_2">年</span> 
<select name="bmonth" id="bmonth">
<?php foreach($montharr AS $month)
{
	$selected = '';
	if($month==$bmonth) $selected = 'selected';
	echo "<option value='$month' $selected>$month</option>";
}
?>
</select>
      <span class="color_2">月</span> 
      <select name="bday" id="bday">
<?php foreach($dayarr AS $day)
{
	$selected = '';
	if($day==$bday) $selected = 'selected';
	echo "<option value='$day' $selected>$day</option>";
}
?>
        </select>
      <span class="color_2">日</span> </td>
  </tr>
  <tr>
    <th><strong>身份证号：</strong></th>
    <td class="td_left"><input type="text" name="info[idcard]" size=22 maxlength=18 value="<?=$idcard?>"/></td>
  </tr>
  <tr>
    <th><strong>户    籍：</strong></th>
    <td class="td_left">
	<select id="SelectSheng" name="info[province]" onChange="City1Select();"><option value="<?=$province?>" selected><?=$province?></option></select>
	<select name="info[city]" id="SelectShi"><option value="<?=$city?>" selected><?=$city?></option></select>
    </td>
  </tr>
<tr>
    <th><strong>目前居住地：</strong></th>
    <td class="td_left">
<select id="SelectSheng2" name="info[placeprovince]" onChange="City2Select();">
<option value="<?=$placeprovince?>" selected><?=$placeprovince?></option>
</select>
<select name="info[placecity]" id="SelectShi2"><option value="<?=$placecity?>" selected><?=$placecity?></option></select>
    </td>
  </tr>
    <tr>
    <th><strong>教育水平：</strong></th>
    <td class="td_left"><select name="info[edulevel]" size=1>
      <option value="">请选择　　</option>
      <option value="博士" <?php if($edulevel=='博士') echo 'selected';?>>博士</option>
      <option value="硕士" <?php if($edulevel=='硕士') echo 'selected';?>>硕士</option>
      <option value="大学" <?php if($edulevel=='大学') echo 'selected';?>>大学</option>
      <option value="高中" <?php if($edulevel=='高中') echo 'selected';?>>高中</option>
      <option value="初中" <?php if($edulevel=='初中') echo 'selected';?>>初中</option>
      <option value="小学" <?php if($edulevel=='小学') echo 'selected';?>>小学</option>
    </select>
    </td>
  </tr>
  <tr>
    <th><strong>照片地址：</strong></th>
    <td class="td_left"><input name="info[userface]" type="text" id="userface" size="50" value="<?=$userface?>" /> <input type="button" value="上传" onClick="javascript:openwinx('<?=PHPCMS_PATH?>yp/upload.php?uploadtext=userface','upload','350','200')"></td>
  </tr>

<tr>
<th><strong>工作性质：</strong></th>
<td width="81%" class="td_left" >
	<select id="character" name="info[worktype]">
	<option value="不限" <?php if($worktype=='不限') echo 'selected';?>>不限</option>	
	<option value="全职" <?php if($worktype=='全职') echo 'selected';?>>全职</option>
	<option value="兼职" <?php if($worktype=='兼职') echo 'selected';?>>兼职</option>
	<option value="实习" <?php if($worktype=='实习') echo 'selected';?>>实习</option>	
	</select>
	</td>
</tr>
<tr> 
<th><strong>工作经历：</strong></th>
<td valign="top" class="td_left">
<textarea name="info[story]" id="story" cols="80" rows="6"><?=$story?></textarea>
</td>
</tr>

<tr> 
  <th><strong>欲从事岗位：</strong></th>
  <td class="td_left">
  <select name="info[station]">
  <?=$station?>
  </select>
<font color="#FF0000">*</font></td>
</tr>
<tr> 
	<th><strong>工作年限：</strong></th>
	<td class="td_left" >
	<input name="info[experience]" type="text" id="experience" size="20" value="<?=$experience?>">
	</td>
</tr>
</tr>

<tr> 
	<th><strong>薪资要求：</strong></th>
	<td class="td_left">
	<input name="info[pay]" type="text" id="pay" size="6" value="<?=$pay?>">/月 0 为面议
	</td>
</tr>
<tr>
<th><strong>期待地区：</strong></th>
<td class="td_left">
<input name="info[area]" type="text" id="area" size="36" value="<?=$area?>">
</select>
</td>
</tr>
<tr> 
	<th><strong>上岗时间：</strong></th>
	<td class="td_left">
	<select id="period" name="info[period]">
	<option value="0" <?php if($period==0) echo 'selected';?>>随叫随到</option>
	<option value="2" <?php if($period==2) echo 'selected';?>>两天内</option>
	<option value="3" <?php if($period==3) echo 'selected';?>>三天内</option>
	<option value="7" <?php if($period==7) echo 'selected';?>>一周内</option>
	<option value="14" <?php if($period==14) echo 'selected';?>>两周内</option>
	<option value="30" <?php if($period==30) echo 'selected';?>>一个月</option>
	<option value="60" <?php if($period==60) echo 'selected';?>>二个月</option>
	<option value="90" <?php if($period==90) echo 'selected';?>>三个月</option>
	</select>
	</td>
</tr>
<tr> 
<th><strong>个人鉴定：</strong></th>
<td valign="top" class="td_left">
<textarea name="info[introduce]" id="introduce" cols="80" rows="15"><?=$introduce?></textarea>
</td>
</tr>
<tr>
<th><strong>毕业时间：</strong></th>
<td valign="top" class="td_left">
<input name="info[graduatetime]" type="text" id="graduatetime" size="10" value="<?=$graduatetime?>">
</td>

</tr>
<tr> 
<th><strong>毕业学校：</strong></th>
<td valign="top" class="td_left">
<input name="info[school]" type="text" id="school" size="30" value="<?=$school?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<th><strong>所学专业：</td>
<td valign="top" class="td_left">
<input name="info[specialty]" type="text" id="specialty" size="30" value="<?=$specialty?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<td colspan="2" bgcolor="#E6E6E6"><B>联系方式：</B> 为了迅速的找到更理想的工作，请尽量详细填写每项联系方式。 </td>
</td>
</tr>
<tr>
<th><strong>联系电话：</strong></th>
<td valign="top" class="td_left">
<input name="info[mobile]" type="text" id="mobile" size="30" value="<?=$mobile?>"> <font color="#FF0000">*</font>
</td>
</tr>
<tr> 
<th><strong>家庭电话：</strong></th>
<td valign="top" class="td_left">
<input name="info[telephone]" type="text" id="telephone" size="30" value="<?=$telephone?>">
</td>
</tr>
<tr> 
<th><strong>E-Mail：</strong></th>
<td valign="top" class="td_left">
<input name="info[email]" type="text" id="email" size="30" value="<?=$email?>" >
</td>
</tr>
<tr> 
<th><strong>QQ：</strong></th>
<td valign="top" class="td_left">
<input name="info[qq]" type="text" id="qq" size="30" value="<?=$qq?>" >
</td>
</tr>


<tr> 
<th><strong>通讯地址：</strong></th>
<td valign="top" class="td_left">
<input name="info[address]" type="text" id="address" size="50" value="<?=$address?>">
</td>
</tr>
<tr> 
<th><strong>邮编：</strong></th>
<td valign="top" class="td_left">
<input name="info[zip]" type="text" id="zip" size="6" value="<?=$zip?>" >
</td>
</tr>
<tr>
<th><strong>个人主页：</strong></th>
<td valign="top" class="td_left">
<input name="info[homepage]" type="text" id="homepage" size="30" value="<?=$homepage?>" >
</td>
</tr>
 <tr>
    <td width="15%" class="td_right">
	</td>
    <td class="td_left" height="25">
	<input type="hidden" name="applyid" value="<?=$applyid?>" />
	<input type="hidden" name="action" value="edit" />
	<input type="submit" name="dosubmit" value=" 确认修改 " />
	</td>
  </tr>
</table>
</form>
</body>
</html>