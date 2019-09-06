<?php
defined('IN_PHPCMS') or exit('Access Denied');
?>
<script language="javascript" type="text/javascript">
<!--
function setSubbtn() {
	if (document.getElementById("time").selectedIndex != 0) {
		document.getElementById("subbtn").disabled = false;
		document.getElementById("rebtn").disabled = false;
	}
}
function setTime(intIndex) {
	if (intIndex == 0) {
		document.forms[0].reset();
	} else {
		for (var i = 0; i < document.forms[0].types.length; i++) {
			if (document.forms[0].types[i].checked) {
				setSubbtn();
				break;
			}
		}
	}
}
function disSubbtn() {
	document.getElementById("subbtn").disabled = true;
	document.getElementById("rebtn").disabled = true;
	return true;
}
function formSubmit() {
	var strTypes;
	for (var i = 0; i < document.forms[0].types.length; i++) {
		if (document.forms[0].types[i].checked) {
			if (document.forms[0].types[i].value == 1) {
				strTypes = "系统消息";
			} else {
				strTypes = "会员消息";
			}
			break;
		}
	}
	var oObj = document.getElementById("time");
	var strTime = oObj.options[oObj.selectedIndex].text;
	if (confirm("您确定要清除["+strTime+"]的"+strTypes+"？")) {
		return true;
	} else {
		return false;
	}
}
//-->
</script>
<table width="100%" cellpadding="2" cellspacing="1" align="center" class="tableborder"><tbody>
	<tr>
		<th colspan="2"><?php echo $menutitle[$fid]; ?></th>
	</tr>
	<tr>
		<td width="100%" height="25" align="center" valign="middle" colspan="2" class="tablerowhighlight">&nbsp;</td>
	</tr>
	<tr><form action="<?php $_SERVER['REQUEST_URI']; ?>" method="post" onsubmit="return formSubmit();" onreset="return disSubbtn();">
		<td width="50%" align="center" valign="top"><table width="100%" height="100%" cellpadding="2" cellspacing="1" align="center" class="tableborder"><tbody></tbody>
			<tr>
				<th colspan="2">系统消息</th>
			</tr>
			<tr onmouseout="this.style.backgroundColor='#F1F3F5';" onmouseover="this.style.backgroundColor='#BFDFFF';" bgColor="#F1F3F5">
				<td width="30%" height="25" align="center" valign="top">总消息数：</td>
				<td width="70%" height="25" align="left" valign="top">
<?php
if ($arrcnt1 > 0) {
	echo $sysmessage[0];
} else {
	echo "&nbsp;";
}
?>
			</td>
			</tr>
			<tr onmouseout="this.style.backgroundColor='#F1F3F5';" onmouseover="this.style.backgroundColor='#BFDFFF';" bgColor="#F1F3F5">
				<td width="30%" height="25" align="center" valign="top">最早时间：</td>
				<td width="70%" height="25" align="left" valign="top">
<?php
if ($arrcnt1 > 0) {
	echo $sysmessage[1];
} else {
	echo "&nbsp;";
}
?>
				</td>
			</tr>
		</table></td>
		<td width="50%" align="center" valign="top"><table width="100%" height="100%" cellpadding="2" cellspacing="1" align="center" class="tableborder"><tbody></tbody>
			<tr>
				<th colspan="2">会员消息</th>
			</tr>
			<tr onmouseout="this.style.backgroundColor='#F1F3F5';" onmouseover="this.style.backgroundColor='#BFDFFF';" bgColor="#F1F3F5">
				<td width="30%" height="25" align="center" valign="top">总消息数：</td>
				<td width="70%" height="25" align="left" valign="top">
<?php
if ($arrcnt2 > 0) {
	echo $uermessage[0];
} else {
	echo "&nbsp;";
}
?>
				</td>
			</tr>
			<tr onmouseout="this.style.backgroundColor='#F1F3F5';" onmouseover="this.style.backgroundColor='#BFDFFF';" bgColor="#F1F3F5">
				<td width="30%" height="25" align="center" valign="top">最早时间：</td>
				<td width="70%" height="25" align="left" valign="top">
<?php
if ($arrcnt2 > 0) {
	echo $uermessage[1];
} else {
	echo "&nbsp;";
}
?>
				</td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td width="100%" height="25" align="center" valign="middle" colspan="2" class="tablerowhighlight"><input id="types" type="radio" name="types" value="1" onclick="setSubbtn();"><span style="font-weight:normal">清除系统消息</span>&nbsp;&nbsp;&nbsp;&nbsp;<select id="time" name="time" onchange="setTime(this.selectedIndex);">
			<option value="">时间段</option>
			<option value="7">一周前</option>
			<option value="30">一月前</option>
			<option value="90">三月前</option>
			<option value="0">全&nbsp;&nbsp;&nbsp;部</option>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;<input id="types" type="radio" name="types" value="0" onclick="setSubbtn();"><span style="font-weight:normal">清除会员消息</span><p style="text-align:center;margin-bottom:10px"><input id="rebtn" type="reset" value="取  消" disabled>&nbsp;&nbsp;&nbsp;&nbsp;<input id="subbtn" type="submit" name="dosubmit" value="确  定" disabled></p></td>
	</tr></form>
</tbody></table>
<?php
if ($arrcnt1 * $arrcnt2 == 0) {
?>
<script language="javascript" type="text/javascript">
<!--
<?php
if ($arrcnt1 == 0) {
	echo "document.forms[0].types[0].disabled=true;";
}
if ($arrcnt2 == 0) {
	echo "document.forms[0].types[1].disabled=true;";
}
?>
//
</script>
<?php
}
?>
</body>
</html>