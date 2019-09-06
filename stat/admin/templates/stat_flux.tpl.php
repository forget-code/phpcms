<?php
defined('IN_PHPCMS') or exit('Access Denied');
if (isset($hour) && intval($hour) >= 0) {
	if (isset($resault)) {
?>
<tbody class="trbg1">
	<tr>
		<td width="20%" align="center" valign="middle" class="tablerowhighlight">日期时间</td>
		<td width="20%" align="center" valign="middle" colspan="2" class="tablerowhighlight">页面访问量(PV,%)</td>
		<td width="20%" align="center" valign="middle" colspan="2" class="tablerowhighlight">独立IP访问量(IP,%)</td>
		<td width="30%" align="center" valign="middle" class="tablerowhighlight">图表</td>
		<td width="10%" align="center" valign="middle" class="tablerowhighlight">当日记录</td>
	</tr>
<?php
for ($i = 0; $i < count($resault); $i++) {
	$rate_pv = round(100 * $resault[$i][0] / $total_pv, 2);
	$rate_ip = round(100 * $resault[$i][1] / $total_ip, 2);
	$imgw_pv = floor(100 * $resault[$i][0] / $maxpv);
	$imgw_ip = floor(100 * $resault[$i][1] / $maxip);
?>
	<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
		<td width="20%" align="center" valign="middle"><?php echo $resault[$i][2]; ?></td>
		<td width="10%" align="right" valign="middle"><?php echo $resault[$i][0]; ?></td>
		<td width="10%" align="right" valign="middle"><?php echo $rate_pv; ?>%</td>
		<td width="10%" align="right" valign="middle"><?php echo $resault[$i][1]; ?></td>
		<td width="10%" align="right" valign="middle"><?php echo $rate_ip; ?>%</td>
		<td width="30%" align="left" valign="middle" style="padding-left:0px;padding-right:3px"><img src="<?php echo "$PHP_SITEURL/$mod"; ?>/pv.gif" width="<?php echo $imgw_pv; ?>%" border="0" height="8"><br><img src="<?php echo "$PHP_SITEURL/$mod"; ?>/ip.gif" width="<?php echo $imgw_ip; ?>%" border="0" height="8"></td>
		<td width="10%" align="center" valign="middle"><a href="<?php echo "$curUri&date=" . substr($resault[$i][2], 0, 10); ?>" target="_self">GO</a></td>
	</tr>
<?php
}
?>
	<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
		<td width='15%' align='center' valign='middle'>累计访问量:</td>
		<td width='85%' align='left' valign='middle' colspan='6'><?php echo "$total_pv&nbsp;PV;&nbsp;$total_ip&nbsp;IP"; ?></td>
	</tr>
</tbody>
<?php
	} else {
?>
<tfoot class="trbg1">
	<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
		<td width="100%" align="center" valign="middle">暂无相关记录</td>
	</tr>
</tfoot>
<?php
	}
} else {
?>
<tbody class="trbg1">
	<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
		<td width="100%" align="center" valign="middle" colspan="7"><form action="<?php echo $curUri; ?>" method="post"><div class="tablerow">日期选择：<?php echo date_select('mydate', $date); ?>&nbsp;&nbsp;<input type="submit" name="dosubmit" value="确 定"></div></form></td>
	</tr>
	<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
		<td width="5%" align="center" valign="middle" class="tablerowhighlight">时间</td>
		<td width="20%" align="center" valign="middle" colspan="2" class="tablerowhighlight">页面访问量(PV,%)</td>
		<td width="20%" align="center" valign="middle" colspan="2" class="tablerowhighlight">独立IP访问量(IP,%)</td>
		<td width="45%" align="center" valign="middle" class="tablerowhighlight">图表</td>
		<td width="10%" align="center" valign="middle" class="tablerowhighlight">历史记录</td>
	</tr>
<?php
	for ($i = 0; $i < count($hourStat); $i++) {
		if ($total_pv > 0) {
			$rate_pv = round(100 * $hourStat[$i][1] / $total_pv, 2);
			$rate_ip = round(100 * $hourStat[$i][2] / $total_ip, 2);
			$imgw_pv = floor(100 * $hourStat[$i][1] / $maxpv);
			$imgw_ip = floor(100 * $hourStat[$i][2] / $maxip);
		} else {
			$rate_pv = $rate_ip = $imgw_pv = $imgw_ip = 0;
		}
?>
	<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
		<td width="5%" align="center" valign="middle"><?php echo $hourStat[$i][0]; ?></td>
		<td width="10%" align="right" valign="middle"><?php echo $hourStat[$i][1]; ?></td>
		<td width="10%" align="right" valign="middle"><?php echo $rate_pv; ?>%</td>
		<td width="10%" align="right" valign="middle"><?php echo $hourStat[$i][2]; ?></td>
		<td width="10%" align="right" valign="middle"><?php echo $rate_ip; ?>%</td>
		<td width="45%" align="left" valign="middle" style="padding-left:0px;padding-right:3px"><?php if ($imgw_pv == 0 && $imgw_ip == 0) {echo '&nbsp;';} else {?><img src="<?php echo "$PHP_SITEURL/$mod"; ?>/pv.gif" width="<?php echo $imgw_pv; ?>%" border="0" height="8"><br><img src="<?php echo "$PHP_SITEURL/$mod"; ?>/ip.gif" width="<?php echo $imgw_ip; ?>%" border="0" height="8"><?php } ?></td>
		<td width="10%" align="center" valign="middle"><a href="<?php echo "$curUri&hour=" . intval($hourStat[$i][0]); ?>" target="_self">GO</a></td>
	</tr>
<?php
	}
?>
	<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
		<td width="5%" align="center" valign="middle">总量:</td>
		<td width="20%" align="left" valign="middle" colspan='2'><?php echo "$total_pv&nbsp;PV;&nbsp;$total_ip&nbsp;IP"; ?></td>
		<td width="20%" align="center" valign="middle" colspan="2">每小时平均量:</td>
		<td width="55%" align="left" valign="middle" colspan="2">
<?php
if ($total_pv > 0) {
echo floor($total_pv / $db -> num_rows($res)) . "&nbsp;PV;&nbsp;&nbsp;" . floor($total_ip / $db -> num_rows($res)) . "&nbsp;IP";
} else {
	echo "0&nbsp;PV;&nbsp;&nbsp;0&nbsp;IP";
}
?>
		</td>
	</tr>
	<tr onmouseover="this.className='trbg2';" onmouseout="this.className='trbg1';">
		<td width="100%" align="center" valign="middle" colspan="7"><img src="<?php echo "$PHP_SITEURL/$mod"; ?>/pv.gif" border="1" width="10" height="10" align="absmiddle">&nbsp;页面总访问量&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo "$PHP_SITEURL/$mod"; ?>/ip.gif" border="1" width="10" height="10" align="absmiddle">&nbsp独立IP访问量</td>
	</tr>
</tbody>
<?php
}
?>
</table>
</body>
</html>