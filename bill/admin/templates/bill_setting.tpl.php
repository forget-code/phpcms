<?php
defined('IN_PHPCMS') or exit('Access Denied');
?>
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
	<thead>
		<tr>
			<th colspan="4">推广<?php echo $menutitle[$fid]; ?></th>
		</tr>
	</thead><form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" onsubmit="return validate();">
	<tbody class="trbg1">
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';" >
			<td width="20%" align="right" valign="middle">奖励类型：</td>
			<td width="80%" align="left" valign="middle"><input type="radio" name="type" value="points"<?php if ($type == 'points') {echo ' checked';} ?>>&nbsp;点数&nbsp;&nbsp;<input type="radio" name="type" value="days"<?php if ($type == 'days') {echo ' checked';} ?>>&nbsp;有效期(天数)&nbsp;&nbsp;<input type="radio" name="type" value="money"<?php if ($type == 'money') {echo ' checked';} ?>>&nbsp;货币</td>
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="20%" align="right" valign="middle">奖励数量：</td>
			<td width="80%" align="left" valign="middle"><input type="text" name="number" value="<?php echo $number; ?>" size="5"></td>
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="20%" align="right" valign="middle">禁止域名：</td>
			<td width="80%" align="left" valign="middle"><textarea name="domain" rows="10" style="width:50%;overflow:auto"><?php echo $domain; ?></textarea><br>(如有多个可用英文逗号“,”分隔)</td>
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="20%" align="right" valign="middle">&nbsp;</td>
			<td width="80%" align="left" valign="middle"><input type="submit" name="dosubmit" value="提 交"></td>
		</tr>
	</tbody></form>
</table>