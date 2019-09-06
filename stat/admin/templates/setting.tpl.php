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
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
	<thead>
		<tr>
			<th colspan="2"><?php echo $MOD['name']; ?>配置</th>
		</tr>
	</thead><form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
	<tbody class="trbg1">
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="40%" align="right" valign="middle">是否开启访问统计：</td>
			<td width="60%" align="left" valign="middle">&nbsp;<input type="radio" name="disabled" value="0"<?php if (!$disabled) {echo ' checked';} ?>>是&nbsp;&nbsp;<input type="radio" name="disabled" value="1"<?php if ($disabled) {echo ' checked';} ?>>否</td>
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="40%" align="right" valign="middle">访问记录保存时间：</td>
			<td width="60%" align="left" valign="middle">&nbsp;<select name="savetime">
				<option value="0"<?php if ($savetime == 0) {echo ' selected';} ?>>不限</option>
				<option value="30"<?php if ($savetime == 30) {echo ' selected';} ?>>一月</option>
				<option value="180"<?php if ($savetime == 180) {echo ' selected';} ?>>半年</option>
				<option value="365"<?php if ($savetime == 365) {echo ' selected';} ?>>一年</option>
			</select></td>
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="40%" align="right" valign="middle">页面统计间隔时间：</td>
			<td width="60%" align="left" valign="middle">&nbsp;<input type="text" name="interval" size="3" maxlength="3" value="<?php echo $interval; ?>" style="text-align:center">&nbsp;秒</td>
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="40%" align="right" valign="middle">从前台查看用户名：</td>
			<td width="60%" align="left" valign="middle">&nbsp;<input type="text" name="username" value="<?php echo $username; ?>" style="width:100px"></td>
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="40%" align="right" valign="middle">前台查看所需密码：</td>
			<td width="60%" align="left" valign="middle">&nbsp;<input type="password" name="passwd" value="<?php echo $passwd; ?>" style="width:100px"></td>
		</tr>
	</tbody>
	<tfoot class="trbg1">
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="40%" align="right" valign="middle">&nbsp;</td>
			<td width="60%" align="left" valign="middle"><input type="submit" name="dosubmit" value="提 交"></td>
		</tr>
	</tfoot></form>
</table>
</body>
</html>