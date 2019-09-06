<?php
defined('IN_PHPCMS') or exit('Access Denied');
echo "$menu<div style='text-align:left'>当前位置：$curpos</div>";
?>
<script language="javascript" type="text/javascript">
<!--
function doCheck() {
	var objDate = new Date();
	var year = objDate.getYear();
	var month = objDate.getMonth() + 1;
	month = parseInt(month) < 10 ? month = "0" + month : month;
	var day = objDate.getDate();
	day = parseInt(day) < 10 ? day = "0" + day : day;
	var today = year + "-" + month + "-" + day;
	with(document.forms[0]) {
		if (elements['atitle'].value == "") {
			alert("公告标题不能为空！");
			elements['atitle'].focus();
			return false;
		} else if (elements['fromdate'].value == "") {
			alert("起始日期不能为空！");
			elements['fromdate'].value = today;
			elements['fromdate'].focus();
			return false;
		} else if (/^\d{4}(\-\d{2}){2}$/.test(elements['fromdate'].value) == false) {
			alert("起始日期格式无效！");
			elements['fromdate'].value = today;
			elements['fromdate'].focus();
			return false;
		} else if (elements['todate'].value != "" && /^\d{4}(\-\d{2}){2}$/.test(elements['todate'].value) == false) {
			alert("截止日期格式无效！");
			elements['todate'].value = "";
			elements['todate'].focus();
			return false;
		} else {
			return true;
		}
	}
}
//-->
</script>
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
	<thead>
		<tr>
			<th colspan="2"><?php echo $title; ?></th>
		</tr>
	</thead>
	<tbody class="trbg1">
		<tr><form action="<?php echo $curUri; ?>" method="post" onsubmit="return doCheck();">
			<td width="15%" align="center" valign="middle">公告标题：</td>
			<td width="85%" align="left" valign="middle"><input name="atitle" type="text" size="60"></td>
		</tr>
		<tr>
			<td width="15%" align="center" valign="middle">起始日期：</td>
			<td width="85%" align="left" valign="middle"><?php echo date_select('fromdate', date('Y-m-d')); ?></td>
		</tr>
		<tr>
			<td width="15%" align="center" valign="middle">截止日期：</td>
			<td width="85%" align="left" valign="middle"><?php echo date_select('todate', ''); ?></td>
		</tr>
		<tr>
			<td width="15%" align="center" valign="middle">公告内容：</td>
			<td width="85%" align="left" valign="middle"><textarea name="content" id="content"></textarea><?php echo editor('content', 'introduce', 500, 300); ?></td>
		</tr>
		<tr>
			<td width="15%" align="center" valign="middle">公告状态：</td>
			<td width="85%" align="left" valign="middle"><input name="passed" type="radio" value="1" checked>&nbsp;通过&nbsp;&nbsp;<input name="passed" type="radio" value="0">&nbsp;待审核</td>
		</tr>
		<tr>
			<td width="15%" align="center" valign="middle">风格设置：</td>
			<td width="85%" align="left" valign="middle"><?php echo showskin('skinid',0); ?></td>
		</tr>
		<tr>
			<td width="15%" align="center" valign="middle">模板设置：</td>
			<td width="85%" align="left" valign="middle"><?php echo showtpl($mod,'tag_announce_list','templateid', 1, ''); ?></td>
		</tr>
		<tr>
			<td width="15%" align="center" valign="middle">&nbsp;</td>
			<td width="85%" align="left" valign="middle"><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;<input type="reset" value=" 清除 "></td>
		</tr>
	</tbody></form>
</table>
</body>
</html>