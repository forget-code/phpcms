<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<?=$menu?>
<table width="100%" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=4>「<?=$truename?>」的简历</th>
  <tr>
    <td width="19%" class="tablerow">真实姓名：</td>
    <td class="tablerow"><?=$truename?></td>
  </tr>
  <tr>
    <td class="tablerow">性别：</td>
    <td class="tablerow"><?php if($gender) echo '男'; else echo '女';?></td>
  </tr>
  <tr>
    <td class="tablerow">生日：</td>
    <td class="tablerow"><?=$birthday?> </td>
  </tr>
  <tr>
    <td class="tablerow">证件类别：</td>
    <td class="tablerow"><?=$idtype?></td>
  </tr>
  <tr>
    <td class="tablerow">证件号码：</td>
    <td class="tablerow"><?=$idcard?>******** &nbsp;&nbsp;&nbsp;&nbsp;为保护会员权利，后面几位隐藏</td>
  </tr>
  <tr>
    <td class="tablerow">户口所在地：</td>
    <td class="tablerow"><?=$province?><?=$city?><?=$area?></td>
  </tr>
    <tr>
    <td class="tablerow">教育水平：</td>
    <td class="tablerow"><?=$edulevel?></td>
  </tr>
  <tr>
    <td class="tablerow">照片：</td>
    <td class="tablerow"><?php if($userface) echo "<img src='".PHPCMS_PATH.$userface."' width=111 height=150>";?></td>
  </tr>

<tr> 
<td class="tablerow">E-Mail</td>
<td valign="top" class="tablerow">
<?=$_email?>
</td>
</tr>
<tr> 
<td class="tablerow">联系电话</td>
<td valign="top" class="tablerow" >
<?=$telephone?>
</td>
</tr>
<tr> 
<td class="tablerow">联系地址</td>
<td valign="top" class="tablerow" >
<?=$address?>
</td>
</tr>
</table>
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<td class="tablerow">工作性质</td>
<td class="tablerow" ><?=$worktype?></td>
</tr>
<tr> 
<td class="tablerow">工作经历</td>
<td valign="top" class="tablerow">
<?=$story?>
</td>
</tr>

<tr> 
  <td width="19%" class="tablerow">欲从事岗位</td>
  <td class="tablerow" ><?=$station?> <font color="#FF0000">*</font></td>
</tr>
<tr> 
	<td class="tablerow">工作年限</td>
	<td class="tablerow" >
<?=$experience?>
	</td>
</tr>
</tr>

<tr> 
	<td class="tablerow">薪资要求</td>
	<td class="tablerow" >
	<?php if(!$pay) echo '面议'; else echo $pay;?>
	</td>
</tr>
<tr>
<td class="tablerow">期待地区</td>
<td class="tablerow" >
<?=$area?>
</select>
</td>
</tr>
<tr> 
	<td class="tablerow">上岗时间</td>
	<td class="tablerow" >
	<?php
	if($period)
	{
		echo $period.'天内';
	}
	else
	{
		 echo '随叫随到';
	}
	?>
	</td>
</tr>
<tr> 
<td class="tablerow">个人鉴定</td>
<td valign="top" class="tablerow" >
<?=$introduce?>
</td>
</tr>
<tr> 
<td class="tablerow">联 系 人</td>
<td valign="top" class="tablerow" ><?=$linkman?></td>
</tr>
<tr> 
<td class="tablerow">毕业时间</td>
<td valign="top" class="tablerow" >
<?=$graduatetime?>
</td>

</tr>
<tr> 
<td class="tablerow">毕业学校</td>
<td valign="top" class="tablerow" >
<?=$school?>
</td>
</tr>
<tr> 
<td class="tablerow">所学专业</td>
<td valign="top" class="tablerow" >
<?=$specialty?>
</td>
</tr>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1" class="tableborder">
<form name="myform" action="?file=<?=$file?>&action=interview" method="post">
  <tr>
    <td width="15%" class="tablerow">
	</td>
    <td class="tablerow" height="25">
	<input type="hidden" name="stockid" value="<?=$stockid?>" />
	<input type="hidden" name="username" value="<?=$username?>" />
	<input type="submit" name="dosubmit" value=" 邀请面试 " />
	</td>
  </tr>
</table>
</form>
</body>
</html>