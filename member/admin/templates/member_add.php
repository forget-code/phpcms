<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/MyCalendar.js"></script>
<script LANGUAGE="javascript">
<!--
function CheckForm() {
if (document.myform.username.value=="")
	{
	  alert("请输入用户名！")
	  document.myform.username.focus()
	  return false
	 }
if (document.myform.password.value=="")
	{
	  alert("请输入密码！")
	  document.myform.password.focus()
	  return false
	 }
if (document.myform.pwdconfirm.value!=document.myform.password.value)
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
    document.myform.province.value=area.document.regionform.province.value;
    document.myform.city.value=area.document.regionform.city.value;
}
//-->
</script>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add&save=1" onSubmit='return CheckForm();'>
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本资料</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>详细资料</td>
<td id='TabTitle2' class='title1' onclick='ShowTabs(2)'>收费设置</td>
<td>&nbsp;</td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tbody id='Tabs0' style='display:'>
    <th colspan=2>基本资料</th>
      <tr>
        <td width="20%" class="tablerow"><b>用户名</b><br>
          </td>
        <td width="80%" class="tablerow"><input name="username" type="text" id="username" size="15"> <input type="button" name="submit" value=" 检查用户名 " onclick="javascript:openwinx('?mod=<?=$mod?>&file=member&action=user_exists&username='+myform.username.value,'user_exists','450','160')"> 3到20个字符，不得包含非法字符！
          </td>
      </tr>
      <tr>
        <td class="tablerow"><b>密码</b><br></td>
        <td class="tablerow"><input name="password" type="password" id="password" size="15"> 4到20个字符</td>
      </tr>
  <tr>
        <td class="tablerow"><b>确认密码</b></td>
        <td class="tablerow"><input name="pwdconfirm" type="password" id="pwdconfirm" size="15"></td>
      </tr>
      <tr>
        <td class="tablerow"><b>密码提示问题</b></td>
        <td class="tablerow"><input name="question" type="text" id="question" size="30"></td>
      </tr>
      <tr>
        <td class="tablerow"><b>问题答案</b></td>
        <td class="tablerow"><input name="answer" type="text" id="answer" size="30"></td>
      </tr>
      <tr>
        <td class="tablerow"><b>Email地址</b></td>
        <td class="tablerow"><input name="email" type="text" id="email" size="30" maxlength="50"></td>
      </tr>
  <tr>
    <td class="tablerow"><b>用户组</b></td>
    <td class="tablerow"><?=$groupid?></td>
 </tr>
  <tr>
    <td class="tablerow"><b>用户状态</b></td>
    <td class="tablerow"><input type='radio' name='locked' value='0'  checked>正常&nbsp;&nbsp; <input type='radio' name='locked' value='1'>锁定</td>
 </tr> 
</tbody>

<tbody id='Tabs1' style='display:none'>
  <th colspan=2>详细资料</th>
      <tr>
        <td class="tablerow"><b>真实姓名</b></td>
        <td class="tablerow"><input name="truename" type="text" id="truename" size="20" maxlength="50"></td>
      </tr>
      <tr>
        <td class="tablerow"><b>性别</b></td>
        <td class="tablerow">
		<input name="gender" type="radio" style="border:0px " value="1" checked> 男
        <input type="radio" name="gender" value="0" style="border:0px "> 女</td>
      </tr>
  <tr>
    <td class="tablerow"><b>生日</b></td>
    <td class="tablerow">
<input name="byear" type="text" size="4" value="19">
      年
<select name="bmonth" id="bmonth">
 <option value="00"></option>
 <option value="01">1</option>
 <option value="02">2</option>
 <option value="03">3</option>
 <option value="04">4</option>
 <option value="05">5</option>
 <option value="06">6</option>
 <option value="07">7</option>
 <option value="08">8</option>
 <option value="09">9</option>
 <option value="10">10</option>
 <option value="11">11</option>
 <option value="12">12</option>
      </select>
      月
      <select name="bday" id="bday">
 <option value="00"></option>
 <option value="01">1</option>
 <option value="02">2</option>
 <option value="03">3</option>
 <option value="04">4</option>
 <option value="05">5</option>
 <option value="06">6</option>
 <option value="07">7</option>
 <option value="08">8</option>
 <option value="09">9</option>
 <option value="10">10</option>
 <option value="11">11</option>
 <option value="12">12</option>
 <option value="13">13</option>
 <option value="14">14</option>
 <option value="15">15</option>
 <option value="16">16</option>
 <option value="17">17</option>
 <option value="18">18</option>
 <option value="19">19</option>
 <option value="20">20</option>
 <option value="21">21</option>
 <option value="22">22</option>
 <option value="23">23</option>
 <option value="24">24</option>
 <option value="25">25</option>
 <option value="26">26</option>
 <option value="27">27</option>
 <option value="28">28</option>
 <option value="29">29</option>
 <option value="30">30</option>
 <option value="31">31</option>
          </select>
      日</td>
    </tr>
      <tr>
        <td class="tablerow"><b>证件类别</b></td>
        <td class="tablerow">
		<select name="idtype">
			<option value="身份证" >身份证</option>
			<option value="学生证" >学生证</option>
			<option value="军人证" >军人证</option>
			<option value="护照" >护照</option>
		</select>
		</td>
      </tr>
      <tr>
        <td class="tablerow"><b>证件号码</b></td>
        <td class="tablerow"><input type=text name="idcard" value="" size=22 maxlength=18></td>
      </tr>
      <tr>
        <td class="tablerow"><b>所在地：</td>
        <td class="tablerow">
<iframe name='frm1' id='frm1' src='<?=PHPCMS_PATH?>region.php?country=&province=&city=' width='300' height='60' frameborder='0' scrolling='no'></iframe>
<input name='province' type='hidden'>
<input name='city' type='hidden'>
		</td>
      </tr>
      <tr>
        <td class="tablerow"><b>所属行业</b></td>
        <td class="tablerow">
	<select name="industry">
	 <option value="">请选择　　</option>
	 <option value="金融业">金融业</option>
	 <option value="服务业">服务业</option>
	 <option value="信息产业">信息产业</option>
	 <option value="制造业">制造业</option>
	 <option value="传播业">传播业</option>
	 <option value="教育">教育</option>
	 <option value="政府机构">政府机构</option>
	 <option value="医疗保健">医疗保健</option>
	 <option value="房地产">房地产</option>
	 <option value="其它">其它</option>
	</select>
		</td>
      </tr>
      <tr>
        <td class="tablerow"><b>教育水平</b></td>
        <td class="tablerow">
	<select name="edulevel" size=1>
	 <option value="">请选择　　</option>
	 <option value="博士">博士</option>
	 <option value="硕士">硕士</option>
	 <option value="大学">大学</option>
	 <option value="高中">高中</option>
	 <option value="初中">初中</option>
	 <option value="小学">小学</option>
	</select>
		</td>
      </tr>
      <tr>
        <td class="tablerow"><b>从事职业</b></td>
        <td class="tablerow">
	<select name="occupation">
	 <option value="">请选择　　</option>
	 <option value="学生">学生</option>
	 <option value="职员">职员</option>
	 <option value="经理">经理</option>
	 <option value="专业人士">专业人士</option>
	 <option value="公务员">公务员</option>
	 <option value="私营主">私营主</option>
	 <option value="待业">待业</option>
	 <option value="退休">退休</option>
	 <option value="其它">其它</option>
	</select>
		</td>
      </tr>
      <tr>
        <td class="tablerow"><b>收入水平</b></td>
        <td class="tablerow">
	<select name="income">
	 <option value="">请选择　　</option>
	 <option value="6000以上">6000以上</option>
	 <option value="4001-6000">4001-6000</option>
	 <option value="2001-4000">2001-4000</option>
	 <option value="1001-2000">1001-2000</option>
	 <option value="501-1000">501-1000</option>
	 <option value="500以下">500以下</option>
	</select>
		</td>
      </tr>
     <tr>
    <td class="tablerow"><b>电话</b></td>
    <td class="tablerow"><input name="telephone" type="text" id="telephone" size="20"></td>
    </tr>
     <tr>
    <td class="tablerow"><b>手机</b></td>
    <td class="tablerow"><input name="mobile" type="text" id="mobile" size="20"></td>
    </tr>
  <tr>
    <td class="tablerow"><b>地址</b></td>
    <td class="tablerow"><input name="address" type="text" id="address" size="50">	      </td>
    </tr>
  <tr>
    <td class="tablerow"><b>邮编</b></td>
    <td class="tablerow"><input name="postid" type="text" id="postid" size="10">	      </td>
  </tr>
      <tr>
        <td class="tablerow"><b>主页</b></td>
        <td class="tablerow"><input name="homepage" type="text" id="homepage" size="20"></td>
      </tr>
	  <tr>
        <td class="tablerow"><b>QQ号码</b></td>
        <td class="tablerow"><input name="qq" type="text" id="qq" size="20" maxlength="20"></td>
      </tr>
      <tr>
        <td class="tablerow"><b>MSN帐号</b></td>
        <td class="tablerow"><input name="msn" type="text" id="msn" size="20" maxlength="50"></td>
      </tr>
	  <tr>
        <td class="tablerow"><b>ICQ号码</b></td>
        <td class="tablerow"><input name="icq" type="text" id="icq" size="20" maxlength="20"></td>
      </tr>
      <tr>
        <td class="tablerow"><b>Skype帐号</b></td>
        <td class="tablerow"><input name="skype" type="text" id="skype" size="20" maxlength="50"></td>
      </tr>
      <tr>
        <td class="tablerow"><b>支付宝帐号</b></td>
        <td class="tablerow"><input name="alipay" type="text" id="alipay" size="20" maxlength="50"></td>
      </tr>
      <tr>
        <td class="tablerow"><b>贝宝帐号</b></td>
        <td class="tablerow"><input name="paypal" type="text" id="paypal" size="20" maxlength="50"></td>
      </tr>
      <tr>
        <td class="tablerow"><b>头像地址</b></td>
        <td class="tablerow"><input name="userface" type="text" id="userface" size="50" maxlength="50"></td>
      </tr>
      <tr>
        <td class="tablerow"><b>头像大小</b></td>
        <td class="tablerow">宽度：<input name="facewidth" type="text" id="facewidth" size="4" maxlength="50"> px 高度：<input name="faceheight" type="text" id="faceheight" size="4" maxlength="50"> px</td>
      </tr>
      <tr>
        <td class="tablerow"><b>签名信息</b></td>
        <td class="tablerow"><textarea name='sign' cols='35' rows='5' id='sign'></textarea></td>
      </tr>
 </tbody>

  <tbody id='Tabs2' style='display:none'>
      <th colspan=2>收费设置</th>
  <tr>
    <td class="tablerow"><b>计费方式</b></td>
    <td class="tablerow"><input name='chargetype' type='radio' value='0' checked>扣点数<font color='#0000FF'>（推荐）</font>：&nbsp;每阅读一篇收费文章，扣除相应点数。&nbsp;<br>        <input type='radio' name='chargetype' value='1'>有效期：在有效期内，用户可以任意阅读收费内容</td>
 </tr>
  <tr>
    <td class="tablerow"><b>用户点数</b></td>
    <td class="tablerow"><input name="point" type="text" id="point" size="10" value="0">点</td>
 </tr>
  <tr>
    <td class="tablerow"><b>有效期限</b></td>
    <td class="tablerow">开始日期：<script language=javascript>var dateFrom=new MyCalendar("begindate","<?=$begindate?>","选择,年,月,日,上一年,下一年,上个月,下个月,一,二,三,四,五,六"); dateFrom.display();</script>&nbsp;&nbsp;&nbsp;&nbsp;截止日期：<script language=javascript>var dateFrom=new MyCalendar("enddate","<?=$enddate?>","选择,年,月,日,上一年,下一年,上个月,下个月,一,二,三,四,五,六"); dateFrom.display();</script></td>
 </tr>
    </tbody>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
	<input type="submit" name="submit" value=" 添加 ">
      <input type="reset" name="Submit" value=" 清除 "></td>
  </tr>
</table>
</form>
</body>
</html>