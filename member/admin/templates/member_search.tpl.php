<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>会员搜索</th>
  </tr>
<form method="get" name="search" action="?">
<tr>
<td align="center" width="10%" class="tablerowhighlight">用户名</td>
<td width="15%" class="tablerow"><input name='username' type='text' size='15' value='<?=$username?>'></td>
<td align="center" width="10%" class="tablerowhighlight">真实姓名</td>
<td width="15%" class="tablerow"><input name='truename' type='text' size='15' value='<?=$truename?>'></td>
<td align="center" width="10%" class="tablerowhighlight">用户组</td>
<td width="15%" class="tablerow"><?=$groupids?></td>
<td align="center" width="10%" class="tablerowhighlight">会员状态</td>
<td width="15%" class="tablerow">
<select name='locked'>
<option value='-1'>不限</option>
<option value='0'>正常</option>
<option value='1'>锁定</option>
</select>
</td>

</tr>
<tr>
<td align="center" width="10%" class="tablerowhighlight">所属行业</td>
<td width="15%" class="tablerow">
<select name="industry">
	 <option value="">不限</option>
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
<td align="center" width="10%" class="tablerowhighlight">教育水平</td>
<td width="15%" class="tablerow">
	<select name="edulevel" size=1>
	 <option value="">不限</option>
	 <option value="博士" <?php if($edulevel=="博士"){ ?> selected <?php } ?>>博士</option>
	 <option value="硕士" <?php if($edulevel=="硕士"){ ?> selected <?php } ?>>硕士</option>
	 <option value="大学" <?php if($edulevel=="大学"){ ?> selected <?php } ?>>大学</option>
	 <option value="高中" <?php if($edulevel=="高中"){ ?> selected <?php } ?>>高中</option>
	 <option value="初中" <?php if($edulevel=="初中"){ ?> selected <?php } ?>>初中</option>
	 <option value="小学" <?php if($edulevel=="小学"){ ?> selected <?php } ?>>小学</option>
	</select>
</td>
<td align="center" width="10%" class="tablerowhighlight">收入状况</td>
<td width="15%" class="tablerow">
	<select name="income">
	 <option value="">不限</option>
	 <option value="6000以上" <?php if($income=="6000以上"){ ?> selected <?php } ?>>6000以上</option>
	 <option value="4001-6000" <?php if($income=="4001-6000"){ ?> selected <?php } ?>>4001-6000</option>
	 <option value="2001-4000" <?php if($income=="2001-4000"){ ?> selected <?php } ?>>2001-4000</option>
	 <option value="1001-2000" <?php if($income=="1001-2000"){ ?> selected <?php } ?>>1001-2000</option>
	 <option value="501-1000" <?php if($income=="501-1000"){ ?> selected <?php } ?>>501-1000</option>
	 <option value="500以下" <?php if($income=="500以下"){ ?> selected <?php } ?>>500以下</option>
	</select>
</td>
<td align="center" width="10%" class="tablerowhighlight">从事职业</td>
<td width="15%" class="tablerow">
	<select name="occupation">
	 <option value="">不限</option>
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
<td align="center" width="10%" class="tablerowhighlight">省份</td>
<td width="15%" class="tablerow">
<select name="province" id="province" style="width:110">
<option value="">不限</option>
<?php 
foreach($provinces as $p)
{
	$selected = $p == $province ? "selected" : "";
    echo "<option value='".$p."' ".$selected.">".$p."</option>\n";
}
?>
</select>
</td>
<td align="center" width="10%" class="tablerowhighlight">城市</td>
<td width="15%" class="tablerow"><input name='city' type='text' size='15' value='<?=$city?>'></td>
<td align="center" width="10%" class="tablerowhighlight">地址</td>
<td width="15%" class="tablerow"><input name='address' type='text' size='15' value='<?=$address?>'></td>
<td align="center" width="10%" class="tablerowhighlight">E-mail</td>
<td width="15%" class="tablerow"><input name='email' type='text' size='15' value='<?=$email?>'></td>
</tr>
<tr>
<td align="center" width="10%" class="tablerowhighlight">MSN</td>
<td width="15%" class="tablerow"><input name='msn' type='text' size='15' value='<?=$msn?>'></td>
<td align="center" width="10%" class="tablerowhighlight">SKYPE</td>
<td width="15%" class="tablerow"><input name='skype' type='text' size='15' value='<?=$skype?>'></td>
<td align="center" width="10%" class="tablerowhighlight">个人主页</td>
<td width="15%" class="tablerow"><input name='homepage' type='text' size='15' value='<?=$homepage?>'></td>
<td align="center" width="10%" class="tablerowhighlight">QQ</td>
<td width="15%" class="tablerow"><input name='qq' type='text' size='15' value='<?=$qq?>'></td>
</tr>
<tr>
<td align="center" width="10%" class="tablerowhighlight">资金余额</td>
<td width="15%" class="tablerow"><input name='frommoney' type='text' size='5' value='<?=$frommoney?>'> - <input name='tomoney' type='text' size='5' value='<?=$tomoney?>'></td>
<td align="center" width="10%" class="tablerowhighlight">消费金额</td>
<td width="15%" class="tablerow"><input name='frompayment' type='text' size='5' value='<?=$frompayment?>'> - <input name='topayment' type='text' size='5' value='<?=$topayment?>'></td>
<td align="center" width="10%" class="tablerowhighlight">可用点数</td>
<td width="15%" class="tablerow"><input name='frompoint' type='text' size='5' value='<?=$frompoint?>'> - <input name='topoint' type='text' size='5' value='<?=$topoint?>'></td>
<td align="center" width="10%" class="tablerowhighlight">可用积分</td>
<td width="15%" class="tablerow"><input name='fromcredit' type='text' size='5' value='<?=$fromcredit?>'> - <input name='tocredit' type='text' size='5' value='<?=$tocredit?>'></td>
</tr>
<tr>
<td colspan=8 height="30" class="tablerow" align="center">
<input name='mod' type='hidden' value='<?=$mod?>'>
<input name='file' type='hidden' value='<?=$file?>'>
<input name='action' type='hidden' value='manage'>
<input name='submit' type='submit' value=' 会员搜索 '>
</td>
  </tr>
</form>
</table>
</body>
</html>
