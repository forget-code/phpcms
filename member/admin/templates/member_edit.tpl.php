<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<script LANGUAGE="javascript">
<!--
function CheckForm() {
    if (document.myform.username.value=="")
	{
	  alert("请输入用户名！")
	  document.myform.username.focus()
	  return false
	 }
    if (document.myform.password.value!="" && document.myform.pwdconfirm.value!=document.myform.password.value)
	{
	  alert("两次输入的密码不一致！")
      document.myform.password.value = ""
      document.myform.pwdconfirm.value = ""
	  document.myform.password.focus()
	  document.myform.password.select()
	  return false
	 }
    if (document.myform.email.value=="")
	{
	  alert("请输入E-mail！")
	  document.myform.email.focus()
	  return false
	 }
}
//-->
</script>
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=edit&userid=<?=$userid?>" onSubmit='return CheckForm();'>
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本资料</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>详细资料</td>
<td id='TabTitle2' class='title1' onclick='ShowTabs(2)'>会员组</td>
<td id='TabTitle3' class='title1' onclick='ShowTabs(3)'>收费设置</td>
<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tbody id='Tabs0' style='display:'>
    <th colspan=2>基本资料</th>
      <tr>
        <td width="20%" class="tablerow">用户名：
          </td>
        <td width="80%" class="tablerow"><input name="username" type="text" id="username" size="15" value="<?=$username?>" disabled> 3到20个字符，不得包含非法字符！
          </td>
      </tr>
      <tr>
        <td class="tablerow">密码(至少6位)：</td>
        <td class="tablerow"><input name="password" type="password" id="password" size="15"> 4到20个字符</td>
      </tr>
  <tr>
        <td class="tablerow">确认密码：</td>
        <td class="tablerow"><input name="pwdconfirm" type="password" id="pwdconfirm" size="15"></td>
      </tr>
      <tr>
        <td class="tablerow">密码提示问题：</td>
        <td class="tablerow"><input name="question" type="text" id="question" size="20" value="<?=$question?>"></td>
      </tr>
      <tr>
        <td class="tablerow">问题答案：</td>
        <td class="tablerow"><input name="answer" type="text" id="answer" size="20"></td>
      </tr>
      <tr>
        <td class="tablerow">Email地址：</td>
        <td class="tablerow"><input name="email" type="text" id="email" size="20" maxlength="50" value="<?=$email?>"> <input type="checkbox" name="showemail" id="showemail" value="1" <?php echo $showemail ? 'checked' : ''; ?>> 是否公开</td>
      </tr>
</tbody>

<tbody id='Tabs1' style='display:none'>
  <th colspan=2>详细资料</th>
      <tr>
        <td class="tablerow">真实姓名：</td>
        <td class="tablerow"><input name="truename" type="text" id="truename" size="20" maxlength="50" value="<?=$truename?>"></td>
      </tr>
      <tr>
        <td class="tablerow">性别：</td>
        <td class="tablerow">
		<input name="gender" type="radio" style="border:0px" value="1" <?php if($gender==1){ ?> checked <?php } ?>> 男
        <input name="gender" type="radio" style="border:0px" value="0" <?php if($gender==0){ ?> checked <?php } ?>> 女</td>
      </tr>
  <tr>
    <td class="tablerow">生日：</td>
    <td class="tablerow">
<input name="byear" type="text" size="4" value="<?=$byear?>">
      年
<select name="bmonth" id="bmonth">
 <option value="00"></option>
<?php for($i=1;$i<13;$i++){
	      $k = $i<10 ? "0".$i : $i;
?>
 <option value="<?=$k?>" <?php if($k==$bmonth){ ?>selected <?php } ?>><?=$k?></option>
<?php } ?>
      </select>
      月
      <select name="bday" id="bday">
 <option value="00"></option>
<?php for($i=1;$i<32;$i++){
	      $k = $i<10 ? "0".$i : $i;
?>
 <option value="<?=$k?>" <?php if($k==$bday){ ?>selected <?php } ?>><?=$k?></option>
<?php } ?>
          </select>
      日</td>
    </tr>
      <tr>
        <td class="tablerow">证件类别：</td>
        <td class="tablerow">
		<select name="idtype">
			<option value="身份证" <?php if($idtype=="身份证"){ ?> selected <?php } ?>>身份证</option>
			<option value="学生证" <?php if($idtype=="学生证"){ ?> selected <?php } ?>>学生证</option>
			<option value="军人证" <?php if($idtype=="军人证"){ ?> selected <?php } ?>>军人证</option>
			<option value="护照" <?php if($idtype=="护照"){ ?> selected <?php } ?>>护照</option>
		</select>
		</td>
      </tr>
      <tr>
        <td class="tablerow">证件号码：</td>
        <td class="tablerow"><input type=text name="idcard" size=22 maxlength=18 value="<?=$idcard?>"></td>
      </tr>
      <tr>
        <td class="tablerow">所在地：</td>
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
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/area.js"></script>
		</td>
      </tr>
      <tr>
        <td class="tablerow">所属行业：</td>
        <td class="tablerow">
	<select name="industry">
	 <option value="">请选择　</option>
	 <option value="金融业" <?php if($industry=="金融业"){ ?> selected <?php } ?>>金融业</option>
	 <option value="服务业" <?php if($industry=="服务业"){ ?> selected <?php } ?>>服务业</option>
	 <option value="信息产业" <?php if($industry=="信息产业"){ ?> selected <?php } ?>>信息产业</option>
	 <option value="制造业" <?php if($industry=="制造业"){ ?> selected <?php } ?>>制造业</option>
	 <option value="传播业" <?php if($industry=="传播业"){ ?> selected <?php } ?>>传播业</option>
	 <option value="教育" <?php if($industry=="教育"){ ?> selected <?php } ?>>教育</option>
	 <option value="政府机构" <?php if($industry=="政府机构"){ ?> selected <?php } ?>>政府机构</option>
	 <option value="医疗保健" <?php if($industry=="医疗保健"){ ?> selected <?php } ?>>医疗保健</option>
	 <option value="房地产" <?php if($industry=="房地产"){ ?> selected <?php } ?>>房地产</option>
	 <option value="其它" <?php if($industry=="其它"){ ?> selected <?php } ?>>其它</option>
	</select>
		</td>
      </tr>
      <tr>
        <td class="tablerow">教育水平：</td>
        <td class="tablerow">
	<select name="edulevel" size=1>
	 <option value="">请选择　　</option>
	 <option value="博士" <?php if($edulevel=="博士"){ ?> selected <?php } ?>>博士</option>
	 <option value="硕士" <?php if($edulevel=="硕士"){ ?> selected <?php } ?>>硕士</option>
	 <option value="大学" <?php if($edulevel=="大学"){ ?> selected <?php } ?>>大学</option>
	 <option value="高中" <?php if($edulevel=="高中"){ ?> selected <?php } ?>>高中</option>
	 <option value="初中" <?php if($edulevel=="初中"){ ?> selected <?php } ?>>初中</option>
	 <option value="小学" <?php if($edulevel=="小学"){ ?> selected <?php } ?>>小学</option>
	</select>
		</td>
      </tr>
      <tr>
        <td class="tablerow">从事职业：</td>
        <td class="tablerow">
	<select name="occupation">
	 <option value="">请选择　　</option>
	 <option value="学生" <?php if($occupation=="学生"){ ?> selected <?php } ?>>学生</option>
	 <option value="职员" <?php if($occupation=="职员"){ ?> selected <?php } ?>>职员</option>
	 <option value="经理" <?php if($occupation=="经理"){ ?> selected <?php } ?>>经理</option>
	 <option value="专业人士" <?php if($occupation=="专业人士"){ ?> selected <?php } ?>>专业人士</option>
	 <option value="公务员" <?php if($occupation=="公务员"){ ?> selected <?php } ?>>公务员</option>
	 <option value="私营主" <?php if($occupation=="私营主"){ ?> selected <?php } ?>>私营主</option>
	 <option value="待业" <?php if($occupation=="待业"){ ?> selected <?php } ?>>待业</option>
	 <option value="退休" <?php if($occupation=="退休"){ ?> selected <?php } ?>>退休</option>
	 <option value="其它" <?php if($occupation=="其它"){ ?> selected <?php } ?>>其它</option>
	</select>
		</td>
      </tr>
      <tr>
        <td class="tablerow">收入水平：</td>
        <td class="tablerow">
	<select name="income">
	 <option value="">请选择　　</option>
	 <option value="6000以上" <?php if($income=="6000以上"){ ?> selected <?php } ?>>6000以上</option>
	 <option value="4001-6000" <?php if($income=="4001-6000"){ ?> selected <?php } ?>>4001-6000</option>
	 <option value="2001-4000" <?php if($income=="2001-4000"){ ?> selected <?php } ?>>2001-4000</option>
	 <option value="1001-2000" <?php if($income=="1001-2000"){ ?> selected <?php } ?>>1001-2000</option>
	 <option value="501-1000" <?php if($income=="501-1000"){ ?> selected <?php } ?>>501-1000</option>
	 <option value="500以下" <?php if($income=="500以下"){ ?> selected <?php } ?>>500以下</option>
	</select>
		</td>
      </tr>
     <tr>
    <td class="tablerow">电话：</td>
    <td class="tablerow"><input name="telephone" type="text" id="telephone" size="20" value="<?=$telephone?>"></td>
    </tr>
     <tr>
    <td class="tablerow">手机：</td>
    <td class="tablerow"><input name="mobile" type="text" id="mobile" size="20" value="<?=$mobile?>"></td>
    </tr>
  <tr>
    <td class="tablerow">地址：</td>
    <td class="tablerow"><input name="address" type="text" id="address" size="50" value="<?=$address?>">	      </td>
    </tr>
  <tr>
    <td class="tablerow">邮编：</td>
    <td class="tablerow"><input name="postid" type="text" id="postid" size="10" value="<?=$postid?>">	      </td>
  </tr>
      <tr>
        <td class="tablerow">主页：</td>
        <td class="tablerow"><input name="homepage" type="text" id="homepage" size="20" value="<?=$homepage?>"></td>
      </tr>
	  <tr>
        <td class="tablerow">QQ号码：</td>
        <td class="tablerow"><input name="qq" type="text" id="qq" size="20" maxlength="20" value="<?=$qq?>"></td>
      </tr>
      <tr>
        <td class="tablerow">MSN帐号：</td>
        <td class="tablerow"><input name="msn" type="text" id="msn" size="20" maxlength="50" value="<?=$msn?>"></td>
      </tr>
	  <tr>
        <td class="tablerow">ICQ号码：</td>
        <td class="tablerow"><input name="icq" type="text" id="icq" size="20" maxlength="20" value="<?=$icq?>"></td>
      </tr>
      <tr>
        <td class="tablerow">Skype帐号：</td>
        <td class="tablerow"><input name="skype" type="text" id="skype" size="20" maxlength="50" value="<?=$skype?>"></td>
      </tr>
      <tr>
        <td class="tablerow">支付宝帐号：</td>
        <td class="tablerow"><input name="alipay" type="text" id="alipay" size="20" maxlength="50" value="<?=$alipay?>"></td>
      </tr>
      <tr>
        <td class="tablerow">贝宝帐号：</td>
        <td class="tablerow"><input name="paypal" type="text" id="paypal" size="20" maxlength="50" value="<?=$paypal?>"></td>
      </tr>
      <tr>
        <td class="tablerow">头像地址：</td>
        <td class="tablerow"><input name="userface" type="text" id="userface" size="50" maxlength="50" value="<?=$userface?>"></td>
      </tr>
      <tr>
        <td class="tablerow">头像大小：</td>
        <td class="tablerow">宽度：<input name="facewidth" type="text" id="facewidth" size="4" maxlength="3" value="<?=$facewidth?>"> px 高度：<input name="faceheight" type="text" id="faceheight" size="4" maxlength="3" value="<?=$faceheight?>"> px</td>
      </tr>
      <tr>
        <td class="tablerow">签名信息：</td>
        <td class="tablerow"><textarea name='sign' cols='35' rows='5' id='sign'><?=$sign?></textarea></td>
      </tr>
	  <?=$fields?>
 </tbody>

  <tbody id='Tabs2' style='display:none'>
  <th colspan=2>会员组设置</th>
  <tr>
    <td class="tablerow" width="20%" >主会员组：</td>
    <td class="tablerow">
<select name="groupid">
<?php 
foreach($groups as $id=>$group)
{
	$selected = $group['groupid'] == $groupid ? 'selected' : '';
	echo "<option value=\"{$group['groupid']}\" $selected>{$group['groupname']}</option>";
}
?>
</select> &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="ischargebynewgroup" value="1"> <font color="blue">把会员组计费方式、有效期、点数默认值应用到用户吗？</font>
	</td>
 </tr>
  <tr>
    <td class="tablerow">扩展会员组：</td>
    <td class="tablerow">
<?php 
foreach($arrgroups as $k=>$group)
{
	$br = ($k && $k%5 == 0) ? '<br/>' : '';
	$checked = in_array($group['groupid'], $arrgroupid) ? 'checked' : '';
	echo "<input type=\"checkbox\" name=\"arrgroupid[]\" value=\"{$group['groupid']}\" $checked> {$group['groupname']} $br";
}
?>
	</td>
 </tr>
 </tbody>

  <tbody id='Tabs3' style='display:none'>
      <th colspan=2>收费设置</th>
  <tr>
    <td class="tablerow">计费方式：</td>
    <td class="tablerow"><input name='chargetype' type='radio' value='0' <?php if($chargetype==0){ ?> checked <?php } ?>>扣点数<font color='#0000FF'>（推荐）</font>：&nbsp;每阅读一篇收费文章，扣除相应点数。<br>
	<input type='radio' name='chargetype' value='1' <?php if($chargetype==1){ ?> checked <?php } ?>>有效期：在有效期内，用户可以任意阅读收费内容</td>
 </tr>
  <tr>
    <td class="tablerow">用户点数：</td>
    <td class="tablerow"><input name="point" type="text" id="point" size="10" value="<?=$point?>">点</td>
 </tr>
  <tr>
    <td class="tablerow">有效期限：</td>
    <td class="tablerow">开始日期：<?=date_select('begindate', $begindate)?>
&nbsp;&nbsp;&nbsp;&nbsp;截止日期：<?=date_select('enddate', $enddate)?>
   </td>
 </tr>
    </tbody>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
	<input type="submit" name="dosubmit" value=" 修改 ">
      <input type="reset" name="reset" value=" 清除 "></td>
  </tr>
</table>
</form>
</body>
</html>