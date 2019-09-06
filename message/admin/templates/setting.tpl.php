<?php
defined('IN_PHPCMS') or exit('Access Denied');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$CONFIG['charset']; ?>">
<title><?php echo $PHPCMS['sitename']; ?>网站管理 - Power by PHPCMS <?php echo PHPCMS_VERSION; ?></title>
<link href="<?php echo PHPCMS_PATH; ?>admin/skin/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="<?php echo PHPCMS_PATH; ?>include/js/common.js"></script>
<script language="JavaScript" src="<?php echo PHPCMS_PATH; ?>include/js/prototype.js"></script>
<style type="text/css">
.trbg1 {
	background-color:#F1F3F5;
}
.trbg2 {
	background-color:#BFDFFF;
}
</style>
</head>
<body>
<br>
<table width="100%" border="0" cellpadding="5" cellspacing="0" align="center" class="tableborder" style="margin-bottom:10px">
	<tr>
		<td width="100%" align="left" valign="middle" style="text-indent:24px">设置用户组被允许的短消息数量。该数量为用户收件箱、发件箱、回收站中短消息的数量总和，一旦用户的短消息数量超过所属用户组的数量限制，在用户没有删除自己的过时消息或清空回收站之前将不能发送和接收新的短消息(系统消息除外)。</td>
	</tr>
</tbody></table>
<table width="100%" cellpadding="2" cellspacing="1" align="center" class="tableborder"><tbody>
<?php
if (is_array($usergroups)) {
?>
<script language="javascript" type="text/javascript">
<!--
function formChk() {
	var oObj = document.getElementById("numlimit");
	if (oObj.length > 1) {
		for (var i = 0; i < oObj.length; i++) {
			var intVal = parseInt(oObj[i].value);
			if (isNaN(intVal)) {
				var intErr = 1;
				break;
			}
		}
		if (intErr) {
			alert("消息数量中包含无效数据!");
			return false;
		} else {
			return true;
		}
	} else {
		var intVal = parseInt(oObj.value);
		if (isNaN(intVal)) {
			alert("消息数量中包含无效数据!");
			return false;
		} else {
			return true;
		}
	}
}
//-->
</script>
	<tr>
		<th colspan="2">短消息配置</th>
	</tr>
	<tr><form action="<?php $_SERVER['REQUEST_URI']; ?>" method="post" onsubmit="return formChk();">
		<td width="50%" align="center" valign="middle" class="tablerowhighlight">用户组</td>
		<td width="50%" align="center" valign="middle" class="tablerowhighlight">消息数量</td>
	</tr>
<?php
foreach($usergroups as $key => $value) {
?>
	<tr onmouseout="this.style.backgroundColor='#F1F3F5';" onmouseover="this.style.backgroundColor='#BFDFFF';" bgColor="#F1F3F5">
		<td width="50%" height="25" align="center" valign="middle"><?php echo $value['groupname']; ?></td>
		<td width="50%" height="25" align="center" valign="middle"><input id="numlimit" type="text" name="group[]" size="5" value="<?php echo $value['messagelimit']; ?>" style="text-align:center" onfocus="this.select();"></td>
	</tr>
<?php
}
?>
</tbody>
</table>
<p style="text-align:center"><input type="submit" name="dosubmit" value="保存设置"></p></form>
<?php
} else {
?>
	<tr>
		<td width="100%" align="center" valign="middle" class="tablerow"><?php echo $usergroups; ?></td>
	</tr>
</tbody></table>
<?php
}
?>
</body>
</html>