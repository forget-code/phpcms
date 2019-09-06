<?php
defined('IN_PHPCMS') or exit('Access Denied');
if (isset($row)) {
echo "$menu<div style='text-align:left'>当前位置：$curpos</div>";
?>
<script language="javascript" type="text/javascript">
<!--
function goback() {
	window.location.replace("<?php echo $referer; ?>");
}
//-->
</script>
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
	<thead>
		<tr>
			<th colspan="2">后台预览</th>
		</tr>
	</thead>
	<tbody class="trbg1">
		<tr>
			<td width="15%" align="right" valign="middle" class="tablerowhighlight">公告标题：</td>
			<td width="85%" align="left" valign="middle"><?php echo $row[0]; ?></td>
		</tr>
		<tr>
			<td width="15%" align="right" valign="middle" class="tablerowhighlight">添加时间：</td>
			<td width="85%" align="left" valign="middle"><?php echo date('Y-m-d H:i:s', $row[6]); ?></td>
		</tr>
		<tr>
			<td width="15%" align="right" valign="middle" class="tablerowhighlight">起始日期：</td>
			<td width="85%" align="left" valign="middle"><?php echo $row[3]; ?></td>
		</tr>
		<tr>
			<td width="15%" align="right" valign="middle" class="tablerowhighlight">截止日期：</td>
			<td width="85%" align="left" valign="middle"><?php if ($row[4] == '0000-00-00') {echo '不限';} else {echo $row[4];} ?></td>
		</tr>
		<tr>
			<td width="15%" align="right" valign="middle" class="tablerowhighlight">发&nbsp;布&nbsp;人：</td>
			<td width="85%" align="left" valign="middle"><?php echo $row[5]; ?></td>
		</tr>
		<tr>
			<td width="15%" align="right" valign="middle" class="tablerowhighlight">浏览次数：</td>
			<td width="85%" align="left" valign="middle"><?php echo $row[2]; ?></td>
		</tr>
		<tr>
			<td width="15%" align="right" valign="middle" class="tablerowhighlight">公告内容：</td>
			<td width="85%" align="left" valign="middle"><?php echo $row[1]; ?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td width="100%" align="right" valign="middle" colspan="2" style="padding-right:10px"><a href="javascript:goback();">返 回</td>
		</tr>
	</tfoot>
</table>
<?php
}
?>
</body>
</html>