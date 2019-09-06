<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<script language="javascript" type="text/javascript">
<!--
function validate() {
	var objText = document.forms[0].elements["number"];
	if (objText.value == "") {
		alert("请输入奖励数量!");
		objText.focus();
		return false;
	} else if (/^\d+$/.test(objText.value) == false) {
		alert("奖励数量只能为数字，请重新输入！")
		objText.value = "";
		objText.focus();
		return false;
	} else {
		return true;
	}
}
//-->
</script>
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
		<tr>
			<th colspan="4">推广奖励设置</th>
		</tr>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" onsubmit="return validate();">
		<tr>
			<td width="20%" align="right" valign="middle" class="tablerow">奖励类型：</td>
			<td width="80%" align="left" valign="middle" class="tablerow"><input type="radio" name="type" value="points"<?php if ($type == 'points') {echo ' checked';} ?>>&nbsp;点数&nbsp;&nbsp;<input type="radio" name="type" value="days"<?php if ($type == 'days') {echo ' checked';} ?>>&nbsp;有效期(天数)&nbsp;&nbsp;<input type="radio" name="type" value="money"<?php if ($type == 'money') {echo ' checked';} ?>>&nbsp;货币&nbsp;&nbsp;<input type="radio" name="type" value="credit"<?php if ($type == 'credit') {echo ' checked';} ?>>&nbsp;积分</td>
		</tr>
		<tr>
			<td width="20%" align="right" valign="middle" class="tablerow">奖励数量：</td>
			<td width="80%" align="left" valign="middle" class="tablerow"><input type="text" name="number" value="<?php echo $number; ?>" size="5"></td>
		</tr>
		<tr>
			<td width="20%" align="right" valign="middle" class="tablerow">禁止域名：</td>
			<td width="80%" align="left" valign="middle" class="tablerow"><textarea name="domain" rows="10" style="width:50%;overflow:auto"><?php echo $domain; ?></textarea><br>(如有多个可用英文逗号“,”分隔)</td>
		</tr>
		<tr>
			<td width="20%" align="right" valign="middle" class="tablerow">&nbsp;</td>
			<td width="80%" align="left" valign="middle" class="tablerow"><input type="submit" name="dosubmit" value=" 确定 "></td>
		</tr>
</form>
</table>
</body>
</html>