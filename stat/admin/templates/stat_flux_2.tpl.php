<?php
defined('IN_PHPCMS') or exit('Access Denied');
?>
	<tbody class="trbg1">
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle" colspan="6"><form action="<?php echo $curUri; ?>" method="post">年份选择：<select id="year" name="year">
<?php
for ($i = date('Y'); $i >= $startYear; $i--) {
	echo "<option value='$i'";
	if ($i == $year) {
		echo " selected";
	}
	echo ">{$i}年</option>";
}
?>
			</select>&nbsp;<input type="submit" name="dosubmit" value="确 定"></form></td>
		</tr>
<?php
if ($total_pv > 0) {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="20%" align="center" valign="middle" class="tablerowhighlight">日期</td>
			<td width="20%" align="center" valign="middle" colspan="2" class="tablerowhighlight">页面访问量(PV,%)</td>
			<td width="20%" align="center" valign="middle" colspan="2" class="tablerowhighlight">独立IP访问量(IP,%)</td>
			<td width="40%" align="center" valign="middle" class="tablerowhighlight">图表</td>
		</tr>
<?php
for ($i = 0; $i < count($weekStat); $i++) {
	$rate_pv = round(100 * $weekStat[$i][1] / $total_pv, 2);
	$rate_ip = round(100 * $weekStat[$i][2] / $total_ip, 2);
	if ($maxpv > 0) {
		$imgw_pv = floor(100 * $weekStat[$i][1] / $maxpv);
	} else {
		$imgw_pv = 0;
	}
	if ($maxip > 0) {
		$imgw_ip = floor(100 * $weekStat[$i][2] / $maxip);
	} else {
		$imgw_ip = 0;
	}
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="20%" align="center" valign="middle"><?php echo $weekStat[$i][0]; ?></td>
			<td width="10%" align="right" valign="middle"><?php echo $weekStat[$i][1]; ?></td>
			<td width="10%" align="right" valign="middle"><?php echo $rate_pv; ?>%</td>
			<td width="10%" align="right" valign="middle"><?php echo $weekStat[$i][2]; ?></td>
			<td width="10%" align="right" valign="middle"><?php echo $rate_ip; ?>%</td>
			<td width="40%" align="left" valign="middle" style="padding-left:0px;padding-right:3px"><?php if ($imgw_pv == 0 && $imgw_ip == 0) {echo '&nbsp;';} else {echo "<img src='$PHP_SITEURL/$mod/pv.gif' width='$imgw_pv%' border='0' height='8'><br><img src='$PHP_SITEURL/$mod/ip.gif' width='$imgw_ip%' border='0' height='8'>";} ?></td>
		</tr>
<?php
}
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="20%" align="center" valign="middle">总访问量:</td>
			<td width="15%" align="left" valign="middle" colspan="3"><?php echo "$total_pv&nbsp;PV;&nbsp;$total_ip&nbsp;IP"; ?></td>
			<td width="10%" align="center" valign="middle">每周平均量:</td>
			<td width="40%" align="left" valign="middle"><?php echo floor($total_pv / $db -> num_rows($res)) . "&nbsp;PV;&nbsp;&nbsp;" . floor($total_ip / $db -> num_rows($res)) . "&nbsp;IP"; ?></td>
		</tr>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle" colspan="7"><img src="<?php echo "$PHP_SITEURL/$mod"; ?>/pv.gif" border="1" width="10" height="10" align="absmiddle">&nbsp;页面总访问量&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo "$PHP_SITEURL/$mod"; ?>/ip.gif" border="1" width="10" height="10" align="absmiddle">&nbsp独立IP访问量</td>
		</tr>
<?php
} else {
?>
		<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
			<td width="100%" align="center" valign="middle" colspan="6">暂无相关记录</td>
		</tr>
<?php
}
?>
	</tbody>
</table>
</body>
</html>